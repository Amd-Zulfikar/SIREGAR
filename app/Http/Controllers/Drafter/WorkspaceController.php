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

        $electricities = \App\Models\Admin\MgambarElectricity::select('id', 'description', 'file_path')->get();

        return view('drafter.workspace.add_workspace', compact('customers', 'employees', 'pemeriksas', 'submissions', 'varians', 'engines', 'keterangans', 'electricities'));
    }

    public function store(Request $request)
    {
        // Ambil semua rincian
        $rincian = $request->input('rincian', []);

        // Filter: skip yang hide = on & kosong
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

        // Merge kembali ke request
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

        // 3️⃣ Generate nomor transaksi unik
        $todayDate = now()->format('dmy');
        $lastWorkspace = Workspace::whereDate('created_at', now()->toDateString())
            ->orderByDesc('id')
            ->first();

        $nextNumber = $lastWorkspace ? (int) substr($lastWorkspace->no_transaksi, -4) + 1 : 1;
        $noTransaksi = 'RKS-' . $todayDate . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // 4️⃣ Flatten rincian (hanya yang visible)
        $allRincian = [];
        foreach ($request->rincian as $kategori => $items) {
            foreach ($items as $i => $item) {
                if (empty($item['varian_id']) && empty($item['keterangan'])) {
                    continue;
                }

                // ✅ ambil foto dari hidden input (kalau ada)
                $foto = [];
                if (!empty($item['foto'])) {
                    if (is_string($item['foto'])) {
                        // Jika bentuknya string JSON
                        $decoded = json_decode($item['foto'], true);
                        $foto = is_array($decoded) ? $decoded : [];
                    } elseif (is_array($item['foto'])) {
                        // Jika sudah array langsung pakai
                        $foto = $item['foto'];
                    }
                }

                $allRincian[] = [
                    'kategori' => $kategori,
                    'varian_id' => $item['varian_id'] ?? null,
                    'keterangan' => $item['keterangan'] ?? null,
                    'halaman_gambar' => $item['halaman_gambar'] ?? null,
                    'jumlah_gambar' => $item['jumlah_gambar'] ?? 1,
                    'foto' => $foto, // ✅ simpan sementara untuk dimasukkan ke DB
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
                'keterangan' => $row['keterangan'],
                'halaman_gambar' => $row['halaman_gambar'],
                'jumlah_gambar' => $row['jumlah_gambar'],
                // ✅ simpan path foto hasil preview
                'foto_body' => json_encode($row['foto'] ?? []),
            ]);
        }

        // 7️⃣ Redirect sukses
        return redirect()->route('index.workspace')->with('success', 'Workspace berhasil disimpan!');
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
            // 🔥 Coba generate overlay
            $overlayedImages = $this->generateOverlayImages($workspace);

            if (empty($overlayedImages)) {
                Log::warning('Overlay gagal dibuat, tampilkan gambar asli sebagai fallback.');

                $overlayedImages = $workspace->workspaceGambar
                    ->flatMap(function ($gambar) {
                        $fotos = is_string($gambar->foto_body) ? json_decode($gambar->foto_body, true) : $gambar->foto_body;

                        return collect($fotos)->map(fn($f) => $f['file_path'] ?? null)->filter()->values();
                    })
                    ->toArray();
            }

            return view('drafter.workspace.overlay_preview', [
                'workspace' => $workspace,
                'images' => $overlayedImages,
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal generate overlay: ' . $e->getMessage());

            // fallback ke gambar asli
            $images = [];
            foreach ($workspace->workspaceGambar as $gambar) {
                $fotos = $gambar->foto_body;
                if (is_string($fotos)) {
                    $fotos = json_decode($fotos, true);
                }
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

    private function generateOverlayImages($workspace)
    {
        // 🔹 Gunakan driver GD langsung
        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        $overlayedImages = [];

        Log::info('=== GENERATE OVERLAY DIMULAI ===');
        Log::info('Workspace ID: ' . $workspace->id);
        Log::info('Customer: ' . ($workspace->customer->name ?? 'null'));
        Log::info('Employee: ' . ($workspace->employee->name ?? 'null'));
        Log::info('Jumlah workspaceGambar: ' . count($workspace->workspaceGambar));

        $fontPath = public_path('fonts/arial.ttf');
        $useFontFile = file_exists($fontPath);
        Log::info('Font ditemukan: ' . ($useFontFile ? 'YA' : 'TIDAK') . ' | Path: ' . $fontPath);

        // Pastikan folder tmp ada
        $tmpFolder = storage_path('app/public/tmp');
        if (!file_exists($tmpFolder)) {
            mkdir($tmpFolder, 0777, true);
            Log::info('Folder tmp dibuat: ' . $tmpFolder);
        }

        foreach ($workspace->workspaceGambar as $gambar) {
            Log::info('--- MULAI WORKSPACE GAMBAR ID: ' . $gambar->id . ' ---');
            $fotos = $gambar->foto_body;
            if (is_string($fotos)) {
                $fotos = json_decode($fotos, true);
            }
            if (!is_array($fotos) || empty($fotos)) {
                Log::warning('Tidak ada foto untuk gambar ID: ' . $gambar->id);
                continue;
            }

            foreach ($fotos as $foto) {
                $filePath = null;
                if (is_array($foto) && isset($foto['file_path'])) {
                    $filePath = $foto['file_path'];
                } elseif (is_string($foto)) {
                    $filePath = $foto;
                } else {
                    Log::warning('Format foto tidak dikenali untuk gambar ID: ' . $gambar->id);
                    continue;
                }

                $filePath = str_replace(['\\', 'storage/'], '/', $filePath);
                $path = storage_path('app/public/' . ltrim($filePath, '/'));

                if (!file_exists($path)) {
                    Log::error('File foto tidak ditemukan: ' . $path);
                    continue;
                }

                // 🔹 Baca gambar
                try {
                    $img = $manager->read($path);
                    Log::info('Gambar dibaca sukses: ' . $path);
                } catch (\Throwable $e) {
                    Log::error('Gagal membaca gambar: ' . $e->getMessage());
                    continue;
                }

                $imgW = $img->width();
                $imgH = $img->height();

                // Scaling posisi
                $scaleX = $imgW / 1087;
                $scaleY = $imgH / 768;
                $map = fn($x, $y) => [max(0, min(intval($x * $scaleX), $imgW - 10)), max(0, min(intval($y * $scaleY), $imgH - 10))];

                // Helper font styling
                $applyFont = function ($font, $size, $color = '#ff0000') use ($useFontFile, $fontPath) {
                    if ($useFontFile) {
                        $font->file($fontPath);
                    }
                    $font->size($size);
                    $font->color($color);
                };

                $halaman = $gambar->halaman_gambar ? str_pad($gambar->halaman_gambar, 2, '0', STR_PAD_LEFT) : '-';
                $jumlah = $workspace->jumlah_gambar ? str_pad($workspace->jumlah_gambar, 2, '0', STR_PAD_LEFT) : '-';
                $halamanJumlah = "{$halaman} / {$jumlah}";

                // Text overlay
                $overlays = [
                    [
                        'text' => $workspace->customer->name ?? '-',
                        'x' => 875,
                        'y' => 720,
                        'size_percent' => 0.007,
                        'align' => 'center',
                    ],
                    [
                        'text' => $workspace->customer->direktur ?? '-',
                        'x' => 831,
                        'y' => 663,
                        'size_percent' => 0.006,
                    ],
                    [
                        'text' => optional($gambar->varianModel)->name ?? '-',
                        'x' => 918,
                        'y' => 675,
                        'size_percent' => 0.009,
                        'align' => 'center',
                    ],
                    [
                        'text' => $workspace->employee->name ?? '-',
                        'x' => 831,
                        'y' => 644,
                        'size_percent' => 0.006,
                    ],
                    [
                        'text' => $workspace->pemeriksa->name ?? '-',
                        'x' => 831,
                        'y' => 653,
                        'size_percent' => 0.006,
                    ],
                    [
                        'text' => $workspace->created_at->format('d/m/y'),
                        'x' => 905,
                        'y' => 644,
                        'size_percent' => 0.006,
                        'align' => 'center',
                    ],

                    [
                        'text' => $workspace->created_at->format('d/m/y'),
                        'x' => 905,
                        'y' => 654,
                        'size_percent' => 0.006,
                        'align' => 'center',
                    ],

                    [
                        'text' => $workspace->created_at->format('d/m/y'),
                        'x' => 905,
                        'y' => 664,
                        'size_percent' => 0.006,
                        'align' => 'center',
                    ],

                    [
                        'text' => $halaman,
                        'x' => 1015,
                        'y' => 715,
                        'size_percent' => 0.011,
                        'align' => 'center',
                    ],

                    [
                        'text' => $halamanJumlah,
                        'x' => 1025,
                        'y' => 729,
                        'size_percent' => 0.007,
                        'align' => 'center',
                    ],
                ];

                foreach ($overlays as $o) {
                    [$x, $y] = $map($o['x'], $o['y']);
                    $fontSize = intval($imgW * $o['size_percent']);
                    $text = trim($o['text'] ?? '-');
                    if ($text === '') {
                        $text = '-';
                    }

                    try {
                        $img->text($text, $x, $y, function ($font) use ($applyFont, $fontSize, $o, $text) {
                            $color = $text === '-' ? '#888888' : '#000000';
                            $applyFont($font, $fontSize, $color);
                            $font->align($o['align'] ?? 'left');
                            $font->valign('middle');
                        });
                    } catch (\Throwable $e) {
                        Log::error('Gagal menulis text overlay: ' . $e->getMessage());
                    }
                }

                // Paraf drafter
                $fotoParaf = $workspace->employee->foto_paraf ?? null;
                if ($fotoParaf) {
                    if (\Illuminate\Support\Str::startsWith($fotoParaf, '[')) {
                        $decoded = json_decode($fotoParaf, true);
                        if (is_array($decoded) && count($decoded) > 0) {
                            $fotoParaf = $decoded[0];
                        }
                    }

                    $parafPath = storage_path('app/public/paraf/' . ltrim($fotoParaf, '/'));
                    if (file_exists($parafPath)) {
                        try {
                            $parafImg = $manager->read($parafPath)->resize(intval($imgW * 0.02), intval($imgH * 0.02));
                            [$px, $py] = $map(873, 640);
                            $img->place($parafImg, 'top-left', $px, $py);
                        } catch (\Throwable $e) {
                            Log::error('Paraf drafter gagal: ' . $e->getMessage());
                        }
                    }
                }

                // Paraf customer
                $fotoParaf = $workspace->customer->foto_paraf ?? null;
                if ($fotoParaf) {
                    if (\Illuminate\Support\Str::startsWith($fotoParaf, '[')) {
                        $decoded = json_decode($fotoParaf, true);
                        if (is_array($decoded) && count($decoded) > 0) {
                            $fotoParaf = $decoded[0];
                        }
                    }

                    $parafPath = storage_path('app/public/paraf/' . ltrim($fotoParaf, '/'));
                    if (file_exists($parafPath)) {
                        try {
                            $parafImg = $manager->read($parafPath)->resize(intval($imgW * 0.02), intval($imgH * 0.02));
                            [$px, $py] = $map(870, 655);
                            $img->place($parafImg, 'top-left', $px, $py);
                        } catch (\Throwable $e) {
                            Log::error('Paraf drafter gagal: ' . $e->getMessage());
                        }
                    }
                }

                // Paraf Pemeriksa
                $fotoParaf = $workspace->pemeriksa->foto_paraf ?? null;
                if ($fotoParaf) {
                    if (\Illuminate\Support\Str::startsWith($fotoParaf, '[')) {
                        $decoded = json_decode($fotoParaf, true);
                        if (is_array($decoded) && count($decoded) > 0) {
                            $fotoParaf = $decoded[0];
                        }
                    }

                    $parafPath = storage_path('app/public/paraf/' . ltrim($fotoParaf, '/'));
                    if (file_exists($parafPath)) {
                        try {
                            $parafImg = $manager->read($parafPath)->resize(intval($imgW * 0.02), intval($imgH * 0.02));
                            [$px, $py] = $map(873, 648);
                            $img->place($parafImg, 'top-left', $px, $py);
                        } catch (\Throwable $e) {
                            Log::error('Paraf drafter gagal: ' . $e->getMessage());
                        }
                    }
                }

                // Simpan overlay
                $filename = 'overlay_' . uniqid() . '.jpg';
                $savePath = $tmpFolder . '/' . $filename;

                // Pastikan folder ada
                $dir = dirname($savePath);
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                try {
                    $img->save($savePath);
                    Log::info('Disimpan ke: ' . $savePath);
                    $overlayedImages[] = "storage/tmp/{$filename}";
                } catch (\Throwable $e) {
                    Log::error('Gagal menyimpan overlay: ' . $e->getMessage());
                }
            }
        }

        Log::info('=== SELESAI GENERATE OVERLAY ===');
        return $overlayedImages;
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
