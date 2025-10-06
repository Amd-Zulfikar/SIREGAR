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

    public function workspace_add()
    {
        $customers   = Customer::active()->orderBy('name', 'asc')->get();
        $employees = Employee::active()->orderBy('name', 'asc')->get();
        $submissions = Submission::orderBy('name', 'asc')->get();
        $varians = Varian::orderBy('name', 'asc')->get();
        $engines     = Engine::orderBy('name', 'asc')->get();

        return view('drafter.workspace.add_workspace', compact(
            'customers',
            'employees',
            'submissions',
            'varians',
            'engines'
        ));
    }

    

    // public function store(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'employee_id'   => 'required|exists:tb_employees,id',
    //             'customer_id'   => 'required|exists:tb_customers,id',
    //             'submission_id' => 'required|exists:tb_submissions,id',
    //             'varian_id'     => 'required|exists:tb_varians,id',
    //             'rincian'       => 'required|array|min:1',
    //         ]);

    //         // ambil tanggal sekarang
    //         $todayDate = now()->format('dmy');

    //         // cari transaksi terakhir di hari ini
    //         $lastWorkspace = Workspace::whereDate('created_at', now()->toDateString())
    //             ->orderBy('id', 'desc')
    //             ->first();

    //         // tentuin nomor urut
    //         $nextNumber = 1;
    //         if ($lastWorkspace) {
    //             $lastNo = (int) substr($lastWorkspace->no_transaksi, -4);
    //             $nextNumber = $lastNo + 1;
    //         }

    //         // format nomor transaksi
    //         $noTransaksi = 'RKS-' . $todayDate . '' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

    //         $workspace = Workspace::create([
    //             'employee_id'   => $request->employee_id,
    //             'customer_id'   => $request->customer_id,
    //             'submission_id' => $request->submission_id,
    //             'varian_id'     => $request->varian_id,
    //             'jumlah_gambar' => $request->jumlah_gambar,
    //             'no_transaksi'  => $noTransaksi,
    //         ]);

    //         $rincian = $request->input('rincian', []);

    //         foreach ($rincian as $index => $row) {

    //             $row = (array) $row;

    //             if (empty($row['engine']) || empty($row['brand']) || empty($row['chassis']) || empty($row['vehicle']) || empty($row['keterangan'])) {
    //                 Log::warning("Skipping rincian index {$index} karena data kurang", $row);
    //                 continue;
    //             }

    //             $workspace->workspaceGambar()->create([
    //                 'engine'     => $row['engine'],
    //                 'brand'      => $row['brand'],
    //                 'chassis'    => $row['chassis'],
    //                 'vehicle'    => $row['vehicle'],
    //                 'keterangan' => $row['keterangan'],
    //                 'varian_id'  => $row['varian_id'],
    //                 'halaman_gambar' => $row['halaman_gambar'] ?? null,
    //                 'jumlah_gambar'  => $row['jumlah_gambar'] ?? 0,
    //                 'foto_body'  => json_encode($row['fotoBody'] ?? $row['foto_body'] ?? []),
    //             ]);
    //         }

    //         return response()->json([
    //             'error' => false,
    //             'message' => 'Workspace berhasil disimpan!',
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
    //         return redirect()->back()
    //             ->with('error', 'Terjadi kesalahan saat menyimpan workspace: ' . $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        try {
            // Validasi data header yang wajib
            $request->validate([
                'employee_id'       => 'required|exists:tb_employees,id',
                'customer_id'       => 'required|exists:tb_customers,id',
                'submission_id'     => 'required|exists:tb_submissions,id',
                'engine_id'         => 'required', 
                'brand_id'          => 'required', 
                'chassis_id'        => 'required', 
                'jumlah_gambar_total' => 'required|numeric|min:1|max:4', // Validasi baru
                'rincian'           => 'required|array', 
            ]);
            
            // --- Logika Nomor Transaksi (Tetap sama) ---
            // ... (kode untuk membuat $noTransaksi) ...
            $todayDate = now()->format('dmy');
            $lastWorkspace = Workspace::whereDate('created_at', now()->toDateString())
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = 1;
            if ($lastWorkspace) {
                $lastNo = (int) substr($lastWorkspace->no_transaksi, -4);
                $nextNumber = $lastNo + 1;
            }
            $noTransaksi = 'RKS-' . $todayDate . '' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            // ------------------------------------------

            // Ambil dan ratakan semua rincian dari form
            $rincianGroups = $request->input('rincian', []);
            
            $allRincian = [];
            foreach ($rincianGroups as $group) {
                if (is_array($group)) {
                    foreach ($group as $rincianItem) {
                        $allRincian[] = $rincianItem;
                    }
                }
            }
            
            // Filter rincian yang benar-benar terisi (punya keterangan_id dan varian_id)
            $validRincian = collect($allRincian)->filter(function($r) {
                return !empty($r['keterangan_id']) && !empty($r['varian_id']);
            });

            if ($validRincian->isEmpty()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Minimal satu baris rincian gambar harus diisi.'
                ], 422);
            }
            
            // Total gambar = Jumlah baris rincian valid (dikalikan 1 per baris)
            // Karena setiap baris dianggap 1 gambar (Utama 1, Terurai 1, Konstruksi 1)
            $totalGambar = $validRincian->count(); 

            // Buat Workspace utama
            $workspace = Workspace::create([
                'employee_id'   => $request->employee_id,
                'customer_id'   => $request->customer_id,
                'submission_id' => $request->submission_id,
                'varian_id'     => $validRincian->first()['varian_id'] ?? null, 
                'jumlah_gambar' => $totalGambar, // Menggunakan total baris yang valid
                'no_transaksi'  => $noTransaksi,
                'engine_id'     => $request->engine_id,
                'brand_id'      => $request->brand_id,
                'chassis_id'    => $request->chassis_id,
            ]);

            // Simpan setiap baris rincian yang valid ke WorkspaceGambar
            foreach ($validRincian as $row) {
                $workspace->workspaceGambar()->create([
                    'engine'         => $request->engine_id,
                    'brand'          => $request->brand_id,
                    'chassis'        => $request->chassis_id,
                    'vehicle'        => $request->vehicle_id, 
                    
                    // Data dari Rincian
                    'keterangan'     => $row['keterangan_id'], 
                    'varian_id'      => $row['varian_id'],
                    'halaman_gambar' => $row['halaman_gambar'] ?? null,
                    'jumlah_gambar'  => 1, // SET JML GAMBAR MENJADI 1 PER BARIS AKTIF
                    'foto_body'      => json_encode([]), 
                ]);
            }

            return response()->json([
                'error' => false,
                'message' => 'Workspace berhasil disimpan!',
            ]);
        } catch (\Exception $e) {
            // ... (Logika error) ...
        }
    }


    public function workspace_edit($id)
    {
        $workspace = Workspace::with(['workspaceGambar.engineModel', 'workspaceGambar.brandModel', 'workspaceGambar.chassisModel', 'workspaceGambar.vehicleModel'])->findOrFail($id);

        $employees = Employee::active()->orderBy('name', 'asc')->get();
        $customers = Customer::active()->orderBy('name', 'asc')->get();
        $submissions = Submission::orderBy('name', 'asc')->get();
        $engines = Engine::orderBy('name', 'asc')->get();
        $varians = Varian::orderBy('name', 'asc')->get();

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

                'submission_id' => $workspace->submission_id ?? null,
                'employee_id'   => $workspace->employee_id ?? null,
                'customer_id'   => $workspace->customer_id ?? null,
                'varian_id'     => $g->varian_id,
                'varianText'    => optional($g->varian)->name ?? '-',

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

        $workspace->employee_id   = $request->employee_id   ?? $workspace->employee_id;
        $workspace->customer_id   = $request->customer_id   ?? $workspace->customer_id;
        $workspace->submission_id = $request->submission_id ?? $workspace->submission_id;
        $workspace->varian_id     = $request->varian_id     ?? $workspace->varian_id;

        $rincians = $request->rincian ?? [];

        $workspace->workspaceGambar()->delete();

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

        $gambarFirst = $workspace->workspaceGambar->first();
        $zipName = trim(
            ($gambarFirst->mdata->brand->name ?? '-') . ' ' .
                ($gambarFirst->mdata->chassis->name ?? '-') . ' ' .
                ($gambarFirst->mdata->vehicle->name ?? '-')
        );
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
                $zip->addFile($file, basename($file));
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


                $halaman = $gambar->halaman_gambar ? str_pad($gambar->halaman_gambar, 2, '0', STR_PAD_LEFT) : '-';
                $jumlah  = $workspace->jumlah_gambar ? str_pad($workspace->jumlah_gambar, 2, '0', STR_PAD_LEFT) : '-';
                $halamanJumlah = "{$halaman} / {$jumlah}";


                // Mapping posisi overlay
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
                    [
                        'text' => $halaman,
                        'x' => 1015,
                        'y' => 715,
                        'size_percent' => 0.010,
                        'align' => 'center',
                    ],
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

                // Paraf Drafter
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

                // Paraf Customer
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

    public function getKeterangans(Request $request)
    {
        $mdata_id = $request->mdata_id;
        if (!$mdata_id) {
            return response()->json([], 400); // Bad request
        }

        $keterangans = Keterangan::where('mdata_id', $mdata_id)->get(['id', 'varian_body', 'foto_utama', 'foto_terurai', 'foto_kontruksi']);
        return response()->json($keterangans);
    }





}
