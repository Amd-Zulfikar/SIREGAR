<?php

namespace App\Http\Controllers\Drafter;

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

    public function workspace_show($id)
    {
        $workspace = Workspace::with([
            'customer',
            'employee',
            'submission',
            'workspaceGambar.mdata.engine',
            'workspaceGambar.mdata.brand',
            'workspaceGambar.mdata.chassis',
            'workspaceGambar.mdata.vehicle'
        ])->findOrFail($id);

        return view('drafter.workspace.show_workspace', compact('workspace'));
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
