<?php

namespace App\Http\Controllers\Drafter;

use App\Models\Admin\Mdata;
use App\Models\Admin\Engine;
use App\Models\Admin\Varian;
use Illuminate\Http\Request;
use App\Models\Admin\Mgambar;
use App\Models\Admin\Customer;
use App\Models\Admin\Employee;
use App\Models\Admin\Pemeriksa;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Admin\Submission;
use App\Models\Drafter\Workspace;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use App\Models\Admin\MgambarOptional;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\MgambarElectricity;

class WorkspaceController extends Controller
{
    public function index()
    {
        $workspaces = Workspace::with(['workspaceGambar.engineModel', 'workspaceGambar.brandModel', 'workspaceGambar.chassisModel', 'workspaceGambar.vehicleModel', 'submission'])->paginate(10);

        return view('drafter.workspace.index', compact('workspaces'));
    }

    public function workspace_add()
    {
        $customers = Customer::active()->orderBy('name', 'asc')->get();
        $employees = Employee::active()->orderBy('name', 'asc')->get();
        $pemeriksas = Pemeriksa::orderBy('name', 'asc')->get();
        $submissions = Submission::orderBy('name', 'asc')->get();
        $keterangans = MGambar::all();
        $varians = Varian::orderBy('name_utama', 'asc')->orderBy('name_terurai', 'asc')->orderBy('name_kontruksi', 'asc')->get();
        $engines = Engine::orderBy('name', 'asc')->get();

        $electricities = MgambarElectricity::select('id', 'description', 'file_path')->get();

        return view('drafter.workspace.add_workspace', compact('customers', 'employees', 'pemeriksas', 'submissions', 'varians', 'engines', 'keterangans', 'electricities'));
    }

    public function store(Request $request)
    {
        // 1️⃣ Filter rincian hide/kosong
        $rincian = $request->input('rincian', []);
        foreach ($rincian as $kategori => $items) {
            foreach ($items as $index => $item) {
                $isHide = isset($item['hide']) && $item['hide'] === 'on';
                $isEmpty = empty($item['varian_id']) && empty($item['keterangan']);
                if ($isHide || $isEmpty) {
                    unset($rincian[$kategori][$index]);
                }
            }
            if (empty($rincian[$kategori])) {
                unset($rincian[$kategori]);
            }
        }
        $request->merge(['rincian' => $rincian]);

        // 2️⃣ Validasi input
        $rules = [
            'customer_id' => 'required|exists:tb_customers,id',
            'employee_id' => 'required|exists:tb_employees,id',
            'pemeriksa_id' => 'required|exists:tb_pemeriksa,id',
            'submission_id' => 'required|exists:tb_submissions,id',
            'engine_id' => 'required|exists:tb_engines,id',
            'brand_id' => 'required|exists:tb_brands,id',
            'chassis_id' => 'required|exists:tb_chassiss,id',
            'vehicle_id' => 'required|exists:tb_vehicles,id',
            'sk_varian' => 'nullable|string',
            'jumlah_halaman' => 'required|numeric|min:1',
            'rincian' => 'required|array',
        ];

        if ($request->has('rincian')) {
            foreach ($request->rincian as $kategori => $items) {
                if (!empty($items)) {
                    $rules["rincian.$kategori.*.varian_id"] = 'required|exists:tb_varians,id';
                    $rules["rincian.$kategori.*.keterangan"] = 'required|string';
                }
            }
        }

        $request->validate($rules, [
            'rincian.*.*.varian_id.required' => 'Varian harus dipilih untuk setiap baris rincian.',
            'rincian.*.*.keterangan.required' => 'Keterangan wajib diisi untuk setiap baris rincian.',
        ]);

        // 3️⃣ Generate nomor transaksi
        $todayDate = now()->format('dmy');
        $lastWorkspace = Workspace::whereDate('created_at', now()->toDateString())
            ->orderByDesc('id')
            ->first();
        $nextNumber = $lastWorkspace ? (int) substr($lastWorkspace->no_transaksi, -4) + 1 : 1;
        $noTransaksi = 'RKS-' . $todayDate . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // 4️⃣ Flatten rincian
        $allRincian = [];
        foreach ($request->rincian as $kategori => $items) {
            foreach ($items as $item) {
                if (empty($item['varian_id']) && empty($item['keterangan'])) {
                    continue;
                }

                // ... [Logika Foto tidak berubah] ...
                $foto = [];
                if (!empty($item['foto'])) {
                    if (is_string($item['foto'])) {
                        $decoded = json_decode($item['foto'], true);
                        $foto = is_array($decoded) ? $decoded : [];
                    } elseif (is_array($item['foto'])) {
                        $foto = $item['foto'];
                    }
                }

                // **PERUBAHAN DISINI:** Ubah string kosong menjadi NULL untuk varian_name
                $varianName = $item['varian_name'] ?? null;
                if ($varianName === '') {
                    $varianName = null;
                }

                $allRincian[] = [
                    'kategori' => $kategori,
                    'varian_id' => $item['varian_id'] ?? null,
                    'varian_name' => $varianName, // Menggunakan variabel yang sudah di-check
                    'keterangan' => $item['keterangan'] ?? null,
                    'halaman_gambar' => $item['halaman_gambar'] ?? null,
                    'jumlah_gambar' => $item['jumlah_gambar'] ?? 1,
                    'foto' => $foto,
                    'hide' => 0,
                ];
            }
        }

        if (empty($allRincian)) {
            return back()->withErrors(['rincian' => 'Minimal satu rincian gambar harus diisi.']);
        }

        // 5️⃣ Simpan workspace utama
        $workspace = Workspace::create([
            'no_transaksi' => $noTransaksi,
            'customer_id' => $request->customer_id,
            'employee_id' => $request->employee_id,
            'pemeriksa_id' => $request->pemeriksa_id,
            'submission_id' => $request->submission_id,
            'varian_id' => $allRincian[0]['varian_id'] ?? null,
            'jumlah_gambar' => count($allRincian),
            'sk_varian' => $request->sk_varian,
        ]);

        // 6️⃣ Simpan rincian gambar
        foreach ($allRincian as $row) {
            $workspace->workspaceGambar()->create([
                'engine' => $request->engine_id,
                'brand' => $request->brand_id,
                'chassis' => $request->chassis_id,
                'vehicle' => $request->vehicle_id,
                'varian_id' => $row['varian_id'],
                'varian_name' => $row['varian_name'],
                'keterangan' => $row['keterangan'],
                'halaman_gambar' => $row['halaman_gambar'],
                'jumlah_gambar' => $row['jumlah_gambar'],
                'foto_body' => json_encode($row['foto'] ?? []),
            ]);
        }

        // 7️⃣ Load relasi sebelum generate overlay
        $workspace->load('workspaceGambar.varianModel', 'customer', 'employee', 'pemeriksa');

        // 8️⃣ Generate overlay langsung
        $overlayedImages = $this->generateOverlayImages($workspace);

        // 9️⃣ Redirect sukses
        return redirect()
            ->route('index.workspace')
            ->with([
                'success' => 'Workspace berhasil disimpan!',
                'overlayed_images' => $overlayedImages, // opsional, bisa dikirim ke view
            ]);
    }

    public function workspace_edit($id)
    {
        $workspace = Workspace::with(['workspaceGambar.engineModel', 'workspaceGambar.brandModel', 'workspaceGambar.chassisModel', 'workspaceGambar.vehicleModel'])->findOrFail($id);

        $employees = Employee::active()->orderBy('name', 'asc')->get();
        $customers = Customer::active()->orderBy('name', 'asc')->get();
        $submissions = Submission::orderBy('name', 'asc')->get();
        $engines = Engine::orderBy('name', 'asc')->get();
        $varians = Varian::orderBy('name', 'asc')->get();

        $rincianJs = $workspace->workspaceGambar
            ->map(function ($g) use ($workspace) {
                $keteranganText = $g->keterangan;
                if (is_numeric($g->keterangan)) {
                    $m = Mgambar::find($g->keterangan);
                    if ($m) {
                        $keteranganText = $m->keterangan;
                    }
                }

                return [
                    'engine' => $g->engine,
                    'engineText' => optional($g->engineModel)->name ?? '',
                    'brand' => $g->brand,
                    'brandText' => optional($g->brandModel)->name ?? '',
                    'chassis' => $g->chassis,
                    'chassisText' => optional($g->chassisModel)->name ?? '',
                    'vehicle' => $g->vehicle,
                    'vehicleText' => optional($g->vehicleModel)->name ?? '',
                    'keterangan' => $g->keterangan,
                    'keteranganText' => $keteranganText,
                    'halaman_gambar' => $g->halaman_gambar,
                    'jumlah_gambar' => $g->jumlah_gambar,

                    'submission_id' => $workspace->submission_id ?? null,
                    'employee_id' => $workspace->employee_id ?? null,
                    'customer_id' => $workspace->customer_id ?? null,
                    'varian_id' => $g->varian_id,
                    'varianText' => optional($g->varian)->name ?? '-',

                    'fotoBody' => is_string($g->foto_body) ? json_decode($g->foto_body, true) ?? [] : $g->foto_body ?? [],
                ];
            })
            ->toArray();

        return view('drafter.workspace.edit_workspace', compact('workspace', 'employees', 'customers', 'submissions', 'engines', 'varians', 'rincianJs'));
    }

    public function update(Request $request, $id)
    {
        $workspace = Workspace::findOrFail($id);

        $workspace->employee_id = $request->employee_id ?? $workspace->employee_id;
        $workspace->customer_id = $request->customer_id ?? $workspace->customer_id;
        $workspace->submission_id = $request->submission_id ?? $workspace->submission_id;
        $workspace->varian_id = $request->varian_id ?? $workspace->varian_id;

        $rincians = $request->rincian ?? [];

        $workspace->workspaceGambar()->delete();

        foreach ($rincians as $r) {
            $workspace->workspaceGambar()->create([
                'halaman_gambar' => $r['halaman_gambar'] ?? null,
                'jumlah_gambar' => isset($r['jumlah_gambar']) ? (int) $r['jumlah_gambar'] : 0, // tetap per baris
                'engine' => $r['engine'] ?? null,
                'brand' => $r['brand'] ?? null,
                'chassis' => $r['chassis'] ?? null,
                'vehicle' => $r['vehicle'] ?? null,
                'varian_id' => $r['varian_id'] ?? null,
                'keterangan' => $r['keterangan'] ?? null,
                'foto_body' => json_encode($r['fotoBody'] ?? []),
            ]);
        }

        $workspace->jumlah_gambar = collect($rincians)->sum(fn($r) => isset($r['jumlah_gambar']) ? (int) $r['jumlah_gambar'] : 0);

        $workspace->save();

        return response()->json([
            'error' => false,
            'message' => 'Workspace berhasil diperbarui',
            'total_gambar' => $workspace->jumlah_gambar,
        ]);
    }

    public function previewOverlay($id)
    {
        $workspace = Workspace::with([
            'customer',
            'employee',
            'pemeriksa',
            'varian',
            'workspaceGambar.varianModel',
            'workspaceGambar' => function ($q) {
                $q->orderBy('id');
            },
        ])->findOrFail($id);

        try {
            // 🔥 Generate overlay
            $overlayedImages = $this->generateOverlayImages($workspace);

            // ✅ Jika overlay gagal (kosong), ambil langsung dari DB sebagai fallback
            if (empty($overlayedImages)) {
                Log::warning('Overlay gagal dibuat atau belum di-preview, ambil data langsung dari DB.');

                $overlayedImages = $workspace->workspaceGambar
                    ->flatMap(function ($gambar) {
                        $fotos = is_string($gambar->foto_body) ? json_decode($gambar->foto_body, true) : $gambar->foto_body;

                        return collect($fotos)
                            ->map(function ($f) use ($gambar) {
                                return [
                                    'file_path' => $f['file_path'] ?? null,
                                    'file_name' => $f['file_name'] ?? null,
                                    'varian_name' => $gambar->varian_name ?? (optional($gambar->varianModel)->name ?? '-'),
                                    'keterangan' => $gambar->keterangan ?? '-',
                                ];
                            })
                            ->filter(fn($f) => !empty($f['file_path']))
                            ->values();
                    })
                    ->toArray();
            }

            return view('drafter.workspace.overlay_preview', [
                'workspace' => $workspace,
                'images' => $overlayedImages,
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal generate overlay: ' . $e->getMessage());

            // fallback terakhir
            $images = [];
            foreach ($workspace->workspaceGambar as $gambar) {
                $fotos = is_string($gambar->foto_body) ? json_decode($gambar->foto_body, true) : $gambar->foto_body;

                if (is_array($fotos)) {
                    foreach ($fotos as $foto) {
                        if (isset($foto['file_path'])) {
                            $filePath = str_replace('\\', '', $foto['file_path']);
                            $filePath = ltrim($filePath, '/');
                            if (file_exists(storage_path('app/public/' . str_replace('storage/', '', $filePath)))) {
                                $images[] = $filePath;
                            }
                        }
                    }
                }
            }

            return view('drafter.workspace.overlay_preview', [
                'workspace' => $workspace,
                'images' => $images,
                'error' => 'Terjadi kesalahan saat membuat overlay. Menampilkan gambar asli.',
            ]);
        }
    }

    private function generateOverlayImages($workspace)
    {
        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        $overlayedImages = [];

        Log::info('=== START GENERATE OVERLAY ===');
        Log::info('Workspace ID: ' . $workspace->id);

        $workspace->load(['workspaceGambar.varianModel', 'customer', 'employee', 'pemeriksa']);

        // Pastikan folder tmp ada
        $tmpFolder = storage_path('app/public/tmp');
        if (!file_exists($tmpFolder)) {
            mkdir($tmpFolder, 0777, true);
        }

        foreach ($workspace->workspaceGambar as $gambar) {
            // Ambil varian_name
            $varianName = trim($gambar->varian_name) ?: optional($gambar->varianModel)->name_utama ?: optional($gambar->varianModel)->name_terurai ?: optional($gambar->varianModel)->name_kontruksi ?: optional($gambar->varianModel)->name_optional ?: '-';

            Log::info("Gambar ID {$gambar->id} | varian_id = {$gambar->varian_id} | varianName = {$varianName}");

            // Decode foto_body
            $fotos = is_string($gambar->foto_body) ? json_decode($gambar->foto_body, true) : $gambar->foto_body;

            if (!is_array($fotos) || empty($fotos)) {
                Log::warning("Gambar ID {$gambar->id} tidak memiliki foto_body valid.");
                continue;
            }

            foreach ($fotos as $foto) {
                // ✅ Fallback path kosong
                $filePath = is_array($foto) && isset($foto['file_path']) ? $foto['file_path'] : $foto;

                if (empty($filePath) || $filePath === '/storage/' || $filePath === '\\/storage\\/') {
                    if (isset($foto['file_name']) && !empty($foto['file_name'])) {
                        $filePath = '/storage/body/' . ltrim($foto['file_name'], '/');
                        Log::info("Path kosong diganti fallback untuk gambar ID {$gambar->id}: {$filePath}");
                    } else {
                        Log::warning("Foto path dan file_name kosong untuk gambar ID {$gambar->id}");
                        continue;
                    }
                }

                // Bersihkan path
                $cleanPath = trim(str_replace('\\', '/', $filePath), '/');
                $cleanPath = preg_replace('/^(storage|public)\//i', '', $cleanPath);
                $path = storage_path('app/public/' . $cleanPath);

                // Cek file
                if (!file_exists($path)) {
                    Log::warning("File tidak ditemukan: {$path}");
                    continue;
                }

                // Salin ke tmp
                $filename = basename($path);
                $tmpPath = $tmpFolder . '/' . $filename;

                try {
                    copy($path, $tmpPath);
                    Log::info("File disalin ke tmp: {$tmpPath}");
                } catch (\Throwable $e) {
                    Log::error('Gagal menyalin ke tmp: ' . $e->getMessage());
                    continue;
                }

                // Proses gambar
                try {
                    $img = $manager->read($tmpPath);
                } catch (\Throwable $e) {
                    Log::error("Gagal membaca gambar ID {$gambar->id}: " . $e->getMessage());
                    continue;
                }

                $imgW = $img->width();
                $imgH = $img->height();
                $scaleX = $imgW / 1087;
                $scaleY = $imgH / 768;
                $map = fn($x, $y) => [max(0, min(intval($x * $scaleX), $imgW - 10)), max(0, min(intval($y * $scaleY), $imgH - 10))];

                $applyFont = function ($font, $size, $color = '#000000') {
                    $fontPath = public_path('fonts/arial.ttf');
                    if (file_exists($fontPath)) {
                        $font->file($fontPath);
                    }
                    $font->size($size);
                    $font->color($color);
                };

                $halaman = $gambar->halaman_gambar ? str_pad($gambar->halaman_gambar, 2, '0', STR_PAD_LEFT) : '-';
                $jumlah = $workspace->jumlah_gambar ? str_pad($workspace->jumlah_gambar, 2, '0', STR_PAD_LEFT) : '-';
                $halamanJumlah = "{$halaman} / {$jumlah}";

                $overlays = [
                    ['text' => $workspace->customer->name ?? '-', 'x' => 875, 'y' => 720, 'size_percent' => 0.008, 'align' => 'center'],
                    ['text' => $workspace->customer->direktur ?? '-', 'x' => 831, 'y' => 663, 'size_percent' => 0.006],
                    ['text' => $varianName, 'x' => 918, 'y' => 675, 'size_percent' => 0.007, 'align' => 'center'],
                    ['text' => $workspace->employee->name ?? '-', 'x' => 831, 'y' => 644, 'size_percent' => 0.006],
                    ['text' => $workspace->pemeriksa->name ?? '-', 'x' => 831, 'y' => 653, 'size_percent' => 0.006],
                    ['text' => $workspace->created_at->format('d/m/y'), 'x' => 907, 'y' => 644, 'size_percent' => 0.006, 'align' => 'center'],
                    ['text' => $workspace->created_at->format('d/m/y'), 'x' => 907, 'y' => 654, 'size_percent' => 0.006, 'align' => 'center'],
                    ['text' => $workspace->created_at->format('d/m/y'), 'x' => 907, 'y' => 664, 'size_percent' => 0.006, 'align' => 'center'],
                    ['text' => $halaman, 'x' => 1015, 'y' => 715, 'size_percent' => 0.01, 'align' => 'center'],
                    ['text' => $halamanJumlah, 'x' => 1025, 'y' => 729, 'size_percent' => 0.007, 'align' => 'center'],
                ];

                foreach ($overlays as $o) {
                    [$x, $y] = $map($o['x'], $o['y']);
                    $fontSize = intval($imgW * $o['size_percent']);
                    $text = trim($o['text'] ?? '-') ?: '-';
                    $img->text($text, $x, $y, function ($font) use ($applyFont, $fontSize, $o, $text) {
                        $color = $text === '-' ? '#888888' : '#000000';
                        $applyFont($font, $fontSize, $color);
                        $font->align($o['align'] ?? 'left');
                        $font->valign('middle');
                    });
                }

                // DRAFTER PARAF
                $fotoParafRaw = $workspace->employee->foto_paraf ?? null;

                // Jika berupa JSON array, ambil elemen pertama
                if (is_string($fotoParafRaw) && str_starts_with($fotoParafRaw, '[')) {
                    $decoded = json_decode($fotoParafRaw, true);
                    $fotoParafFilename = is_array($decoded) ? $decoded[0] ?? null : null;
                } elseif (is_array($fotoParafRaw)) {
                    $fotoParafFilename = $fotoParafRaw[0] ?? null;
                } else {
                    $fotoParafFilename = $fotoParafRaw;
                }

                // Pastikan file di folder paraf
                $parafPath = $fotoParafFilename ? storage_path('app/public/paraf/' . ltrim($fotoParafFilename, '/')) : null;

                if ($parafPath && file_exists($parafPath)) {
                    try {
                        // Baca file paraf
                        $parafImg = $manager->read($parafPath);

                        // === Scaling otomatis berdasarkan ukuran gambar utama ===
                        $mainW = $img->width();
                        $mainH = $img->height();

                        // Ubah nilai ini untuk kontrol ukuran relatif (contoh: 0.08 = 8% dari lebar gambar)
                        $scale = 0.02;
                        $targetWidth = intval($mainW * $scale);
                        $parafImg = $parafImg->scaleDown(width: $targetWidth);

                        // === Posisi otomatis (kanan bawah, tapi bisa kamu ubah) ===
                        $parafW = $parafImg->width();
                        $parafH = $parafImg->height();

                        // Offset (jarak dari tepi kanan & bawah)
                        $offsetX = 310; // ubah ini untuk geser kiri-kanan
                        $offsetY = 185; // ubah ini untuk geser atas-bawah

                        $x = $mainW - $parafW - $offsetX;
                        $y = $mainH - $parafH - $offsetY;

                        // Tempelkan ke gambar utama
                        $img = $img->place($parafImg, 'top-left', $x, $y);

                        Log::info("✅ Foto paraf disisipkan di posisi ({$x}, {$y}) | path: {$parafPath}");
                    } catch (\Throwable $e) {
                        Log::error('❌ Gagal memproses foto paraf: ' . $e->getMessage());
                    }
                } else {
                    Log::warning('⚠️ File foto paraf tidak ditemukan di folder paraf: ' . json_encode($parafPath));
                }

                // Pemeriksa PARAF
                $fotoParafRaw = $workspace->pemeriksa->foto_paraf ?? null;

                // Jika berupa JSON array, ambil elemen pertama
                if (is_string($fotoParafRaw) && str_starts_with($fotoParafRaw, '[')) {
                    $decoded = json_decode($fotoParafRaw, true);
                    $fotoParafFilename = is_array($decoded) ? $decoded[0] ?? null : null;
                } elseif (is_array($fotoParafRaw)) {
                    $fotoParafFilename = $fotoParafRaw[0] ?? null;
                } else {
                    $fotoParafFilename = $fotoParafRaw;
                }

                // Pastikan file di folder paraf
                $parafPath = $fotoParafFilename ? storage_path('app/public/paraf/' . ltrim($fotoParafFilename, '/')) : null;

                if ($parafPath && file_exists($parafPath)) {
                    try {
                        // Baca file paraf
                        $parafImg = $manager->read($parafPath);

                        // === Scaling otomatis berdasarkan ukuran gambar utama ===
                        $mainW = $img->width();
                        $mainH = $img->height();

                        // Ubah nilai ini untuk kontrol ukuran relatif (contoh: 0.08 = 8% dari lebar gambar)
                        $scale = 0.02;
                        $targetWidth = intval($mainW * $scale);
                        $parafImg = $parafImg->scaleDown(width: $targetWidth);

                        // === Posisi otomatis (kanan bawah, tapi bisa kamu ubah) ===
                        $parafW = $parafImg->width();
                        $parafH = $parafImg->height();

                        // Offset (jarak dari tepi kanan & bawah)
                        $offsetX = 315; // ubah ini untuk geser kiri-kanan
                        $offsetY = 158; // ubah ini untuk geser atas-bawah

                        $x = $mainW - $parafW - $offsetX;
                        $y = $mainH - $parafH - $offsetY;

                        // Tempelkan ke gambar utama
                        $img = $img->place($parafImg, 'top-left', $x, $y);

                        Log::info("✅ Foto paraf disisipkan di posisi ({$x}, {$y}) | path: {$parafPath}");
                    } catch (\Throwable $e) {
                        Log::error('❌ Gagal memproses foto paraf: ' . $e->getMessage());
                    }
                } else {
                    Log::warning('⚠️ File foto paraf tidak ditemukan di folder paraf: ' . json_encode($parafPath));
                }

                // Customers PARAF
                $fotoParafRaw = $workspace->customer->foto_paraf ?? null;

                // Jika berupa JSON array, ambil elemen pertama
                if (is_string($fotoParafRaw) && str_starts_with($fotoParafRaw, '[')) {
                    $decoded = json_decode($fotoParafRaw, true);
                    $fotoParafFilename = is_array($decoded) ? $decoded[0] ?? null : null;
                } elseif (is_array($fotoParafRaw)) {
                    $fotoParafFilename = $fotoParafRaw[0] ?? null;
                } else {
                    $fotoParafFilename = $fotoParafRaw;
                }

                // Pastikan file di folder paraf
                $parafPath = $fotoParafFilename ? storage_path('app/public/paraf/' . ltrim($fotoParafFilename, '/')) : null;

                if ($parafPath && file_exists($parafPath)) {
                    try {
                        // Baca file paraf
                        $parafImg = $manager->read($parafPath);

                        // === Scaling otomatis berdasarkan ukuran gambar utama ===
                        $mainW = $img->width();
                        $mainH = $img->height();

                        // Ubah nilai ini untuk kontrol ukuran relatif (contoh: 0.08 = 8% dari lebar gambar)
                        $scale = 0.02;
                        $targetWidth = intval($mainW * $scale);
                        $parafImg = $parafImg->scaleDown(width: $targetWidth);

                        // === Posisi otomatis (kanan bawah, tapi bisa kamu ubah) ===
                        $parafW = $parafImg->width();
                        $parafH = $parafImg->height();

                        // Offset (jarak dari tepi kanan & bawah)
                        $offsetX = 315; // ubah ini untuk geser kiri-kanan
                        $offsetY = 140; // ubah ini untuk geser atas-bawah

                        $x = $mainW - $parafW - $offsetX;
                        $y = $mainH - $parafH - $offsetY;

                        // Tempelkan ke gambar utama
                        $img = $img->place($parafImg, 'top-left', $x, $y);

                        Log::info("✅ Foto paraf disisipkan di posisi ({$x}, {$y}) | path: {$parafPath}");
                    } catch (\Throwable $e) {
                        Log::error('❌ Gagal memproses foto paraf: ' . $e->getMessage());
                    }
                } else {
                    Log::warning('⚠️ File foto paraf tidak ditemukan di folder paraf: ' . json_encode($parafPath));
                }

                // Simpan hasil overlay
                $overlayFilename = 'overlay_' . uniqid() . '.jpg';
                $savePath = $tmpFolder . '/' . $overlayFilename;

                try {
                    $img->save($savePath);
                    $overlayedImages[] = "storage/tmp/{$overlayFilename}";
                    Log::info("Overlay disimpan: {$savePath}");
                } catch (\Throwable $e) {
                    Log::error("Gagal menyimpan overlay ID {$gambar->id}: " . $e->getMessage());
                }
            }
        }

        Log::info('=== END GENERATE OVERLAY ===');
        return $overlayedImages;
    }

    public function exportOverlayPDF($id)
    {
        $workspace = Workspace::with(['customer', 'employee', 'varian', 'workspaceGambar.mdata.engine', 'workspaceGambar.mdata.brand', 'workspaceGambar.mdata.chassis', 'workspaceGambar.mdata.vehicle'])->findOrFail($id);

        $overlayedImages = $this->generateOverlayImages($workspace);

        if (empty($overlayedImages)) {
            return back()->with('error', 'Tidak ada gambar overlay untuk diexport.');
        }

        $gambarFirst = $workspace->workspaceGambar->first();
        $zipName = trim(($gambarFirst->mdata->brand->name ?? '-') . ' ' . ($gambarFirst->mdata->chassis->name ?? '-') . ' ' . ($gambarFirst->mdata->vehicle->name ?? '-'));
        $zipName = preg_replace('/[^A-Za-z0-9_\- ]/', '', $zipName);
        if ($zipName === '' || $zipName === '-') {
            $zipName = "workspace_{$workspace->id}";
        }
        $zipPath = storage_path("app/public/{$zipName}.zip");

        $tempDir = storage_path('app/public/tmp_pdf');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $pdfFiles = [];
        foreach ($workspace->workspaceGambar as $index => $gambar) {
            if (!isset($overlayedImages[$index])) {
                continue;
            }

            // Nomor urut file PDF
            $pageNumber = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
            $pdfPath = $tempDir . "/{$pageNumber}.pdf";

            $pdf = Pdf::loadView('drafter.workspace.overlay_pdf', [
                'workspace' => $workspace,
                'image' => $overlayedImages[$index],
            ])->setPaper('a4', 'landscape');

            $pdf->save($pdfPath);
            $pdfFiles[] = $pdfPath;
        }

        // Buat ZIP
        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($pdfFiles as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function getBrands(Request $request)
    {
        $brands = Mdata::where('engine_id', $request->engine_id)->with('brand')->get()->pluck('brand')->unique('id')->values();

        return response()->json($brands);
    }

    public function getChassiss(Request $request)
    {
        $chassiss = Mdata::where('brand_id', $request->brand_id)->with('chassis')->get()->pluck('chassis')->unique('id')->values();

        return response()->json($chassiss);
    }

    public function getVehicles(Request $request)
    {
        $vehicles = Mdata::where('chassis_id', $request->chassis_id)->with('vehicle')->get()->pluck('vehicle')->unique('id')->values();

        return response()->json($vehicles);
    }

    public function getKeterangans(Request $request)
    {
        $mdataId = $request->mdata_id;

        $mgambars = Mgambar::with('varian')->where('mdata_id', $mdataId)->get();

        $result = $mgambars->map(function ($item) {
            return [
                'id' => $item->id,
                'keterangan' => $item->keterangan,
                'varian_utama' => $item->varian->name_utama ?? $item->keterangan,
                'varian_terurai' => $item->varian->name_terurai ?? $item->keterangan,
                'varian_kontruksi' => $item->varian->name_kontruksi ?? $item->keterangan,
                'varian_optional' => $item->varian->name_optional ?? $item->keterangan,
                'varian_kelistrikan' => $item->varian->name_optional ?? $item->keterangan,
                'varian_optional' => $item->varian->name_optional ?? $item->keterangan,
                'foto_utama' => $item->foto_utama,
                'foto_terurai' => $item->foto_terurai,
                'foto_kontruksi' => $item->foto_kontruksi,
                'foto_optional' => $item->foto_optional ? [['file_name' => $item->foto_optional]] : [],
            ];
        });

        return response()->json($result);
    }

    public function getKeterangansElectricity(Request $request)
    {
        $mdata_id = $request->mdata_id;

        $data = MgambarElectricity::where('mdata_id', $mdata_id)->select('id', 'file_name', 'file_path', 'description')->get();

        return response()->json($data);
    }

    public function getKeterangansdetail(Request $request)
    {
        $mdataId = $request->input('mdata_id');

        $keterangans = MgambarOptional::where('mdata_id', $mdataId)

            ->select('id', 'file_name', 'file_path', 'description')
            ->get();

        return response()->json($keterangans);
    }
}
