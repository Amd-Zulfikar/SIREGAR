<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Admin\Brand;
use App\Models\Admin\Mdata;
use App\Models\Admin\Engine;
use Illuminate\Http\Request;
use App\Models\Admin\Chassis;
use App\Models\Admin\Vehicle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MdataController extends Controller
{
    public function index()
    {
        $mdatas = Mdata::with(['engine', 'brand', 'chassis', 'vehicle'])->orderBy('created_at', 'desc')->get();

        return view('admin.mdata.index', [
            'title' => 'Data mdatas',
            'mdatas' => $mdatas,
        ]);
    }

    public function mdata_add()
    {
        $engine = Engine::active()->get();
        $brand = Brand::all();
        $chassis = Chassis::all();
        $vehicle = Vehicle::all();

        $data = [
            'engines' => $engine,
            'brands' => $brand,
            'chassiss' => $chassis,
            'vehicles' => $vehicle,
        ];
        return view('admin.mdata.add_mdata', $data);
    }

    public function mdata_edit($id)
    {
        $mdata = Mdata::findOrFail($id);
        $engine = Engine::active()->get();
        $brand = Brand::all();
        $chassis = Chassis::all();
        $vehicle = Vehicle::all();

        $data = [
            'mdata' => $mdata,
            'engines' => $engine,
            'brands' => $brand,
            'chassiss' => $chassis,
            'vehicles' => $vehicle,
        ];
        return view('admin.mdata.edit_mdata', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'engines' => 'required',
            'brands' => 'required',
            'chassiss' => 'required',
            'vehicles' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan!');
        }

        $input = $request->all();
        try {
            Mdata::create([
                'engine_id' => $input['engines'],
                'brand_id' => $input['brands'],
                'chassis_id' => $input['chassiss'],
                'vehicle_id' => $input['vehicles'],
                'status'   => 1, // default aktif
            ]);

            return redirect()->route('index.mdata')->with('success', 'Master data berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'engines'    => 'required|exists:tb_engines,name',
            'brands'    => 'required|exists:tb_brands,name',
            'chassiss'    => 'required|exists:tb_chassiss,name',
            'vehicles'    => 'required|exists:tb_vehicles,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan!');
        }

        $input = $request->all();
        try {
            $mdata = Mdata::findOrFail($id);

            $data = [
                'engine_id' => $input['engines'],
                'brand_id' => $input['brands'],
                'chassis_id' => $input['chassiss'],
                'vehicle_id' => $input['vehicles'],
            ];

            $mdata->update($data);

            return redirect()->route('index.mdata')->with('success', 'Master data berhasil diperbarui!');
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function action(Request $request, $id)
    {
        $mdata = Mdata::findOrFail($id);
        $mdata->status = $request->status;
        $mdata->save();

        return response()->json(['success' => true, 'status' => $mdata->status]);
    }
}
