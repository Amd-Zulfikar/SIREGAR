<?php

namespace App\Http\Controllers\Drafter;


use App\Models\Admin\Brand;
use App\Models\Admin\Mdata;
use Illuminate\Support\Str;
use App\Models\Admin\Engine;
use App\Models\Admin\Varian;
use Illuminate\Http\Request;
use App\Models\Admin\Chassis;
use App\Models\Admin\Mgambar;
use App\Models\Admin\Vehicle;
use App\Models\Admin\Customer;
use App\Models\Admin\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Admin\Submission;
use App\Models\Drafter\Workspace;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;

class WorkspaceController extends Controller
{
    // List workspace
    public function index()
    {
        $workspaces = Workspace::with([
            'workspaceGambar.engineModel',
            'workspaceGambar.brandModel',
            'workspaceGambar.chassisModel',
            'workspaceGambar.vehicleModel',
            'submission'
        ])->paginate(10);

        return view('drafter.workspace.index', compact('workspaces'));
    }

    // Add workspace form
    public function workspace_add()
    {
        $customers   = Customer::all();
        $employees = Employee::active()->get();
        $submissions = Submission::all();
        $varians = Varian::all();
        $engines     = Engine::all();

        return view('drafter.workspace.add_workspace', compact(
            'customers',
            'employees',
            'submissions',
            'varians',
            'engines'
        ));
    }

    // Store workspace
    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id'   => 'required|exists:tb_employees,id',
                'customer_id'   => 'required|exists:tb_customers,id',
                'submission_id' => 'required|exists:tb_submissions,id',
                'varian_id'     => 'required|exists:tb_varians,id',
                'rincian'       => 'required|array|min:1',
            ]);

            // ambil tanggal sekarang
            $todayDate = now()->format('dmy'); // contoh: 24/09/2025

            // cari transaksi terakhir di hari ini
            $lastWorkspace = Workspace::whereDate('created_at', now()->toDateString())
                ->orderBy('id', 'desc')
                ->first();

            // tentuin nomor urut
            $nextNumber = 1;
            if ($lastWorkspace) {
                // ambil 4 digit terakhir dari no_transaksi
                $lastNo = (int) substr($lastWorkspace->no_transaksi, -4);
                $nextNumber = $lastNo + 1;
            }

            // format nomor transaksi
            $noTransaksi = 'RKS-' . $todayDate . '' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // debug log (bisa dihapus setelah ok)
            Log::info('Rincian diterima', ['rincian' => $request->input('rincian')]);

            $workspace = Workspace::create([
                'employee_id'   => $request->employee_id,
                'customer_id'   => $request->customer_id,
                'submission_id' => $request->submission_id,
                'varian_id'     => $request->varian_id,
                'jumlah_gambar' => $request->jumlah_gambar,
                'no_transaksi'  => $noTransaksi,
            ]);

            $rincian = $request->input('rincian', []);

            foreach ($rincian as $index => $row) {
                // Pastikan row adalah array (jika datang sebagai object dari JS)
                $row = (array) $row;

                // Jika ingin validasi per-row, bisa cek di sini
                if (empty($row['engine']) || empty($row['brand']) || empty($row['chassis']) || empty($row['vehicle']) || empty($row['keterangan'])) {
                    Log::warning("Skipping rincian index {$index} karena data kurang", $row);
                    continue; // atau kembalikan error jika wajib
                }

                $workspace->workspaceGambar()->create([
                    'engine'     => $row['engine'],
                    'brand'      => $row['brand'],
                    'chassis'    => $row['chassis'],
                    'vehicle'    => $row['vehicle'],
                    'keterangan' => $row['keterangan'],
                    'varian_id'  => $row['varian_id'],
                    'halaman_gambar' => $row['halaman_gambar'] ?? null,
                    'jumlah_gambar'  => $row['jumlah_gambar'] ?? 0,
                    'foto_body'  => json_encode($row['fotoBody'] ?? $row['foto_body'] ?? []),
                ]);
            }

            return response()->json([
                'error' => false,
                'message' => 'Workspace berhasil disimpan!',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan workspace: ' . $e->getMessage());
        }
    }

    public function workspace_edit($id)
    {
        $workspace = Workspace::with(['workspaceGambar.engineModel', 'workspaceGambar.brandModel', 'workspaceGambar.chassisModel', 'workspaceGambar.vehicleModel'])->findOrFail($id);

        $employees = Employee::active()->get();
        $customers = Customer::all();
        $submissions = Submission::all();
        $engines = Engine::all();
        $varians = Varian::all();

        $rincianJs = $workspace->workspaceGambar->map(function ($g) use ($workspace) {
            $keteranganText = $g->keterangan;
            if (is_numeric($g->keterangan)) {
                $m = Mgambar::find($g->keterangan);
                if ($m) $keteranganText = $m->keterangan;
            }

            return [
                'engine'        => $g->engine,
                'engineText'    => optional($g->engineModel)->name ?? '',
                'brand'         => $g->brand,
                'brandText'     => optional($g->brandModel)->name ?? '',
                'chassis'       => $g->chassis,
                'chassisText'   => optional($g->chassisModel)->name ?? '',
                'vehicle'       => $g->vehicle,
                'vehicleText'   => optional($g->vehicleModel)->name ?? '',
                'keterangan'    => $g->keterangan,
                'keteranganText' => $keteranganText,
                'halaman_gambar' => $g->halaman_gambar,
                'jumlah_gambar' => $g->jumlah_gambar,

                // Workspace-level (supaya bisa dipakai saat checkbox dipilih)
                'submission_id' => $workspace->submission_id ?? null,
                'employee_id'   => $workspace->employee_id ?? null,
                'customer_id'   => $workspace->customer_id ?? null,
                'varian_id'     => $g->varian_id,
                'varianText'    => optional($g->varian)->name ?? '-',

                // Foto
                'fotoBody'      => is_string($g->foto_body)
                    ? json_decode($g->foto_body, true) ?? []
                    : ($g->foto_body ?? []),
            ];
        })->toArray();

        return view('drafter.workspace.edit_workspace', compact(
            'workspace',
            'employees',
            'customers',
            'submissions',
            'engines',
            'varians',
            'rincianJs'
        ));
    }


    public function update(Request $request, $id)
    {
        $workspace = Workspace::findOrFail($id);

        // === Update data utama ===
        $workspace->employee_id   = $request->employee_id   ?? $workspace->employee_id;
        $workspace->customer_id   = $request->customer_id   ?? $workspace->customer_id;
        $workspace->submission_id = $request->submission_id ?? $workspace->submission_id;
        $workspace->varian_id     = $request->varian_id     ?? $workspace->varian_id;

        // === Ambil data rincian dari request ===
        $rincians = $request->rincian ?? [];

        // === Hapus semua rincian lama (replace full) ===
        $workspace->workspaceGambar()->delete();

        // === Simpan rincian baru ===
        foreach ($rincians as $r) {
            $workspace->workspaceGambar()->create([
                'halaman_gambar' => $r['halaman_gambar'] ?? null,
                'jumlah_gambar'  => isset($r['jumlah_gambar']) ? (int) $r['jumlah_gambar'] : 0, // tetap per baris
                'engine'         => $r['engine'] ?? null,
                'brand'          => $r['brand'] ?? null,
                'chassis'        => $r['chassis'] ?? null,
                'vehicle'        => $r['vehicle'] ?? null,
                'varian_id'      => $r['varian_id'] ?? null,
                'keterangan'     => $r['keterangan'] ?? null,
                'foto_body'      => json_encode($r['fotoBody'] ?? []),
            ]);
        }

        // === Hitung ulang total jumlah gambar workspace ===
        $workspace->jumlah_gambar = collect($rincians)
            ->sum(fn($r) => isset($r['jumlah_gambar']) ? (int) $r['jumlah_gambar'] : 0);

        $workspace->save();

        return response()->json([
            'error' => false,
            'message' => 'Workspace berhasil diperbarui',
            'total_gambar' => $workspace->jumlah_gambar
        ]);
    }


    // Preview overlay
    public function previewOverlay($id)
    {
        $workspace = Workspace::with(['customer', 'employee', 'varian', 'workspaceGambar'])
            ->findOrFail($id);

        $overlayedImages = $this->generateOverlayImages($workspace);

        return view('drafter.workspace.overlay_preview', [
            'workspace' => $workspace,
            'images' => $overlayedImages,
        ]);
    }

    // Export overlay ke PDF (satu gambar = satu PDF, lalu zip)
    public function exportOverlayPDF($id)
    {
        $workspace = Workspace::with([
            'customer',
            'employee',
            'varian',
            'workspaceGambar.mdata.engine',
            'workspaceGambar.mdata.brand',
            'workspaceGambar.mdata.chassis',
            'workspaceGambar.mdata.vehicle'
        ])->findOrFail($id);

        $overlayedImages = $this->generateOverlayImages($workspace);

        if (empty($overlayedImages)) {
            return back()->with('error', 'Tidak ada gambar overlay untuk diexport.');
        }

        // Nama ZIP berdasarkan workspaceGambar pertama
        $gambarFirst = $workspace->workspaceGambar->first();
        $zipName = trim(
            ($gambarFirst->mdata->brand->name ?? '-') . ' ' .
                ($gambarFirst->mdata->chassis->name ?? '-') . ' ' .
                ($gambarFirst->mdata->vehicle->name ?? '-')
        );
        $zipName = preg_replace('/[^A-Za-z0-9_\- ]/', '', $zipName); // bersihkan
        if ($zipName === '' || $zipName === '-') {
            $zipName = "workspace_{$workspace->id}";
        }
        $zipPath = storage_path("app/public/{$zipName}.zip");

        // Temp folder untuk PDF
        $tempDir = storage_path('app/public/tmp_pdf');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $pdfFiles = [];
        foreach ($workspace->workspaceGambar as $index => $gambar) {
            if (!isset($overlayedImages[$index])) continue;

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
                $zip->addFile($file, basename($file)); // pakai 01.pdf, 02.pdf, dst
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    private function generateOverlayImages($workspace)
    {
        $overlayedImages = [];

        // pastikan tmp folder ada
        if (!\Illuminate\Support\Facades\Storage::exists('public/tmp')) {
            \Illuminate\Support\Facades\Storage::makeDirectory('public/tmp');
        }

        $managerGd = new ImageManager(new GdDriver());

        $managerIm = null;
        try {
            $managerIm = new ImageManager(new ImagickDriver());
        } catch (\Throwable $e) {
            Log::info('Imagick not available: ' . $e->getMessage());
        }

        $fontPath = public_path('fonts/arial.ttf');
        $useFontFile = file_exists($fontPath);

        foreach ($workspace->workspaceGambar as $gambar) {
            $fotos = json_decode($gambar->foto_body, true);
            if (!$fotos) continue;

            foreach ($fotos as $foto) {
                $relative = (strpos($foto, 'body/') === 0) ? $foto : 'body/' . ltrim($foto, '/');
                $path = storage_path("app/public/{$relative}");
                if (!file_exists($path)) continue;

                $img = null;
                try {
                    $img = $managerGd->read($path);
                } catch (\Throwable $e) {
                    if ($managerIm) {
                        try {
                            $img = $managerIm->read($path);
                        } catch (\Throwable $e2) {
                            continue;
                        }
                    }
                }

                if ($img === null) continue;

                $imgW = $img->width();
                $imgH = $img->height();

                // scaling posisi
                $scaleX = $imgW / 1087;
                $scaleY = $imgH / 768;
                $map = function ($x, $y) use ($scaleX, $scaleY) {
                    return [intval($x * $scaleX), intval($y * $scaleY)];
                };

                // helper apply font
                $applyFont = function ($font, $size) use ($useFontFile, $fontPath) {
                    if ($useFontFile) {
                        $font->filename($fontPath);
                    }
                    $font->size($size);
                    $font->color('#000000');
                };

                // =======================
                // Build halaman / jumlah
                // =======================
                $halaman = $gambar->halaman_gambar ? str_pad($gambar->halaman_gambar, 2, '0', STR_PAD_LEFT) : '-';
                $jumlah  = $workspace->jumlah_gambar ? str_pad($workspace->jumlah_gambar, 2, '0', STR_PAD_LEFT) : '-';
                $halamanJumlah = "{$halaman} / {$jumlah}";

                // =======================
                // Mapping posisi overlay
                // =======================
                $overlays = [
                    [
                        'text' => $workspace->customer->name ?? '-',
                        'x' => 875,
                        'y' => 720,
                        'size_percent' => 0.009,
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
                        'size_percent' => 0.007,
                        'align' => 'center',
                    ],
                    [
                        'text' => $workspace->employee->name ?? '-',
                        'x' => 831,
                        'y' => 644,
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
                        'y' => 653,
                        'size_percent' => 0.006,
                        'align' => 'center',
                    ],
                    [
                        'text' => $workspace->created_at->format('d/m/y'),
                        'x' => 905,
                        'y' => 663,
                        'size_percent' => 0.006,
                        'align' => 'center',
                    ],
                    // halaman gambar asli (opsional ditampilkan)
                    [
                        'text' => $halaman,
                        'x' => 1015,
                        'y' => 715,
                        'size_percent' => 0.010,
                        'align' => 'center',
                    ],
                    // gabungan "halaman / jumlah"
                    [
                        'text' => $halamanJumlah,
                        'x'    => 1025,
                        'y'    => 729,
                        'size_percent' => 0.006,
                        'align' => 'center',
                    ],
                ];

                foreach ($overlays as $o) {
                    [$x, $y] = $map($o['x'], $o['y']);

                    $fontSize = isset($o['size_percent'])
                        ? intval($imgW * $o['size_percent'])
                        : ($o['size'] ?? 16);

                    $img->text($o['text'], $x, $y, function ($font) use ($applyFont, $o, $fontSize) {
                        $applyFont($font, $fontSize);
                        $font->align($o['align'] ?? 'left');
                        $font->valign('middle');
                    });
                }

                // =======================
                // Paraf Drafter
                // =======================
                $fotoParaf = $workspace->employee->foto_paraf ?? null;
                if ($fotoParaf) {
                    if (Str::startsWith($fotoParaf, '[')) {
                        $decoded = json_decode($fotoParaf, true);
                        if (is_array($decoded) && count($decoded) > 0) $fotoParaf = $decoded[0];
                    }

                    $parafPath = storage_path('app/public/paraf/' . ltrim($fotoParaf, '/'));
                    if (file_exists($parafPath)) {
                        try {
                            $parafImg = $managerGd->read($parafPath)
                                ->resize(intval($imgW * 0.02), intval($imgH * 0.02));
                            [$px, $py] = $map(868, 640);
                            $img->place($parafImg, 'top-left', $px, $py);
                        } catch (\Throwable $e) {
                            Log::error('Paraf drafter read failed: ' . $e->getMessage());
                        }
                    }
                }

                // =======================
                // Paraf Customer
                // =======================
                $fotoParaf = $workspace->customer->foto_paraf ?? null;
                if ($fotoParaf) {
                    if (Str::startsWith($fotoParaf, '[')) {
                        $decoded = json_decode($fotoParaf, true);
                        if (is_array($decoded) && count($decoded) > 0) $fotoParaf = $decoded[0];
                    }

                    $parafPath = storage_path('app/public/paraf/' . ltrim($fotoParaf, '/'));
                    if (file_exists($parafPath)) {
                        try {
                            $parafImg = $managerGd->read($parafPath)
                                ->resize(intval($imgW * 0.02), intval($imgH * 0.02));
                            [$px, $py] = $map(868, 659);
                            $img->place($parafImg, 'top-left', $px, $py);
                        } catch (\Throwable $e) {
                            Log::error('Paraf customer read failed: ' . $e->getMessage());
                        }
                    }
                }

                // simpan hasil
                $filename = 'overlay_' . uniqid() . '.jpg';
                $savePath = storage_path("app/public/tmp/{$filename}");
                $img->save($savePath);

                if (file_exists($savePath)) {
                    $overlayedImages[] = "storage/tmp/{$filename}";
                }
            }
        }

        return $overlayedImages;
    }











    // AJAX get brands by engine
    public function getBrands(Request $request)
    {
        $brands = Mdata::where('engine_id', $request->engine_id)
            ->with('brand')
            ->get()
            ->pluck('brand')
            ->unique('id')
            ->values();

        return response()->json($brands);
    }

    // AJAX get chassiss by brand
    public function getChassiss(Request $request)
    {
        $chassiss = Mdata::where('brand_id', $request->brand_id)
            ->with('chassis')
            ->get()
            ->pluck('chassis')
            ->unique('id')
            ->values();

        return response()->json($chassiss);
    }

    // AJAX get vehicles by chassis
    public function getVehicles(Request $request)
    {
        $vehicles = Mdata::where('chassis_id', $request->chassis_id)
            ->with('vehicle')
            ->get()
            ->pluck('vehicle')
            ->unique('id')
            ->values();

        return response()->json($vehicles);
    }

    // AJAX get keterangans by vehicle
    public function getKeterangans(Request $request)
    {
        $mgambars = Mgambar::whereHas('mdata', function ($q) use ($request) {
            $q->where('vehicle_id', $request->vehicle_id);
        })->get(['id', 'keterangan', 'foto_body']);

        // Cast sudah otomatis, cukup pastikan foto_body array
        $mgambars->transform(function ($item) {
            if (!is_array($item->foto_body)) {
                $item->foto_body = $item->foto_body ? [$item->foto_body] : [];
            }
            return $item;
        });

        return response()->json($mgambars);
    }
}
