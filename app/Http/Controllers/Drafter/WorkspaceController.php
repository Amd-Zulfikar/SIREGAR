<?php

namespace App\Http\Controllers\Drafter;


use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Admin\Brand;
use App\Models\Admin\Mdata;
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

class WorkspaceController extends Controller
{
    // List workspace
    public function index()
    {
        $workspaces = Workspace::with([
            'workspaceGambar.mdata.engine',
            'workspaceGambar.mdata.brand',
            'workspaceGambar.mdata.chassis',
            'workspaceGambar.mdata.vehicle',
        ])->paginate(10);

        return view('drafter.workspace.index', compact('workspaces'));
    }

    // Add workspace form
    public function workspace_add()
    {
        $customers   = Customer::all();
        $employees   = Employee::all();
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

    // Preview overlay
    public function previewOverlay($id)
    {
        $workspace = Workspace::with(['customer', 'employee', 'varian', 'workspaceGambar'])->findOrFail($id);

        $images = $this->generateOverlayImages($workspace);

        return view('drafter.workspace.overlay_preview', compact('workspace', 'images'));
    }

    // Export overlay ke PDF
    public function exportOverlayPDF($id)
    {
        $workspace = Workspace::with(['customer', 'employee', 'varian', 'workspaceGambar'])->findOrFail($id);

        $overlayedImages = $this->generateOverlayImages($workspace);

        $pdf = Pdf::loadView('drafter.workspace.overlay_pdf', [
            'workspace' => $workspace,
            'overlayedImages' => $overlayedImages,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("workspace_overlay_{$workspace->id}.pdf");
    }

    // Generate overlay images
    private function generateOverlayImages($workspace)
    {
        $overlayedImages = [];

        foreach ($workspace->workspaceGambar as $gambar) {
            $fotos = json_decode($gambar->foto_body, true);
            if (!$fotos) continue;

            foreach ($fotos as $foto) {
                $path = storage_path("app/public/{$foto}");
                if (!file_exists($path)) continue;

                $img = Image::make($path);

                $scaleX = $img->width() / 1087;
                $scaleY = $img->height() / 768;
                $fontSize = 18 * (($scaleX + $scaleY) / 2);

                // Overlay teks
                $img->text($workspace->customer->name, 50 * $scaleX, 50 * $scaleY, function ($font) use ($fontSize) {
                    $font->file(public_path('fonts/arial.ttf'));
                    $font->size($fontSize);
                    $font->color('#000');
                });

                $img->text($workspace->varian->name, 50 * $scaleX, 100 * $scaleY, function ($font) use ($fontSize) {
                    $font->file(public_path('fonts/arial.ttf'));
                    $font->size($fontSize);
                    $font->color('#000');
                });

                $img->text($workspace->employee->name, 50 * $scaleX, 150 * $scaleY, function ($font) use ($fontSize) {
                    $font->file(public_path('fonts/arial.ttf'));
                    $font->size($fontSize);
                    $font->color('#000');
                });

                $img->text($workspace->customer->direktur, 50 * $scaleX, 200 * $scaleY, function ($font) use ($fontSize) {
                    $font->file(public_path('fonts/arial.ttf'));
                    $font->size($fontSize);
                    $font->color('#000');
                });

                $img->text($workspace->created_at->format('d-m-Y'), 50 * $scaleX, 250 * $scaleY, function ($font) use ($fontSize) {
                    $font->file(public_path('fonts/arial.ttf'));
                    $font->size($fontSize);
                    $font->color('#000');
                });

                // Paraf Drafter
                if ($workspace->employee->foto_paraf) {
                    $paraf = Image::make(storage_path("app/public/{$workspace->employee->foto_paraf}"))->resize(80, 80);
                    $img->insert($paraf, 'top-left', 300 * $scaleX, 150 * $scaleY);
                }

                // Paraf Disetujui
                if ($workspace->customer->foto_paraf) {
                    $parafCust = Image::make(storage_path("app/public/{$workspace->customer->foto_paraf}"))->resize(80, 80);
                    $img->insert($parafCust, 'top-left', 300 * $scaleX, 200 * $scaleY);
                }

                // Simpan sementara
                $filename = 'overlay_' . uniqid() . '.png';
                $savePath = storage_path("app/public/tmp/{$filename}");
                $img->save($savePath);

                if (file_exists($savePath)) {
                    $overlayedImages[] = $savePath;
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

        $mgambars->transform(function ($item) {
            $fotos = json_decode($item->foto_body, true);
            if (!$fotos) $fotos = [$item->foto_body];
            $item->foto_body = $fotos;
            return $item;
        });

        return response()->json($mgambars);
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

            // debug log (bisa dihapus setelah ok)
            Log::info('Rincian diterima', ['rincian' => $request->input('rincian')]);

            $workspace = Workspace::create([
                'employee_id'   => $request->employee_id,
                'customer_id'   => $request->customer_id,
                'submission_id' => $request->submission_id,
                'varian_id'     => $request->varian_id,
                'no_transaksi'  => 'TRX-' . time()
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
                    'foto_body'  => json_encode($row['fotoBody'] ?? $row['foto_body'] ?? []),
                ]);
            }

            return response()->json(['error' => false, 'message' => 'Workspace berhasil disimpan!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
