<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\Admin\Vehicle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::paginate(5);

        return view('admin.vehicle.index', [
            'title' => 'Data vehicles',
            'vehicles' => $vehicles,
        ]);
    }

    public function vehicle_add()
    {
        return view('admin.vehicle.add_vehicle');
    }

    public function vehicle_edit($id)
    {
        $tbvehicle = Vehicle::find($id);

        if (!$tbvehicle) {
            return redirect()->route('index.vehicle')->with('error', 'Vehicle tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Data Vehicle', 
            'vehicle' => $tbvehicle, 
            'vehicles' => Vehicle::all()];

        return view('admin.vehicle.edit_vehicle', $data);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return redirect()->route('index.vehicle')->with('error', 'Vehicle tidak ditemukan!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $vehicle->name = $request->input('name');
        $vehicle->save();

        return redirect()->route('index.vehicle')->with('success', 'Vehicle berhasil diperbarui!');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan! Periksa input Anda.');
        }
        $input = $request->all();

        try {
            // dd($request->all()); //  cek isi request masuk atau enggak
            Vehicle::create([
                'name' => $input['name'],
            ]);

            return redirect()->route('index.vehicle')->with('success', 'Jenis kendaraan berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan: '. $e->getMessage());
        }
    }

    public function action(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->status = $request->status;
        $vehicle->save();

        return redirect()->route('index.vehicle')->with('success', 'Status vehicle berhasil diubah!');
    }
}
