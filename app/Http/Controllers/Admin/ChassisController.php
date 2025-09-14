<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\Admin\Chassis;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChassisController extends Controller
{
    public function index()
    {
        $chassiss = Chassis::paginate(5);

        return view('admin.chassis.index', [
            'title' => 'Data chassiss',
            'chassiss' => $chassiss,
        ]);
    }

    public function chassis_add()
    {
        $data = [
            'title' => 'Tambah Data Chassis', 
            'chassiss' => Chassis::all()];

        return view('admin.chassis.add_chassis', $data);
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
            Chassis::create([
                'name' => $input['name'],
            ]);

            return redirect()->route('index.chassis')->with('success', 'Chassis berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan: '. $e->getMessage());
        }
    }

    public function chassis_edit($id)
    {
        $chassis = Chassis::find($id);
        if (!$chassis) {
            return redirect()->route('index.chassis')->with('error', 'Chassis tidak ditemukan!');
        }

        return view('admin.chassis.edit_chassis', [
            'title' => 'Edit Data Chassis',
            'chassis' => $chassis,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal diupdate! Periksa input Anda.');
        }

        $tbchassis = Chassis::find($id);
        if (!$tbchassis) {
            return redirect()->route('index.chassis')->with('error', 'Chassis tidak ditemukan!');
        }

        $input = $request->all();
        try {
            // dd($request->all()); //  cek isi request masuk atau enggak
            $tbchassis->update([
                'name' => $input['name'],
            ]);

            return redirect()->route('index.chassis')->with('success', 'Chassis berhasil diupdate!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak terupdate! Terjadi kesalahan: '. $e->getMessage());
        }
    }

    public function action(Request $request, $id)
    {
        $chassis = Chassis::findOrFail($id);
        $chassis->status = $request->status;
        $chassis->save();

        return redirect()->route('index.chassis')->with('success', 'Status chassis berhasil diubah!');
    }
}
