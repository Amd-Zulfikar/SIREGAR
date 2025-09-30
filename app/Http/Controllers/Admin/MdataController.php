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
        $engine = Engine::orderBy('created_at', 'desc')->get();
        $brand = Brand::orderBy('created_at', 'desc')->get();
        $chassis = Chassis::orderBy('created_at', 'desc')->get();
        $vehicle = Vehicle::orderBy('created_at', 'desc')->get();

        $data = [
            'engines' => $engine,
            'brands' => $brand,
            'chassiss' => $chassis,
            'vehicles' => $vehicle,
        ];
        return view('admin.mdata.add_mdata', $data);
    }

    public function mdata_copy($id)
    {
        $mdata = Mdata::findOrFail($id);
        $engine = Engine::orderBy('created_at', 'desc')->get();
        $brand = Brand::orderBy('created_at', 'desc')->get();
        $chassis = Chassis::orderBy('created_at', 'desc')->get();
        $vehicle = Vehicle::orderBy('created_at', 'desc')->get();

        $data = [
            'mdata' => $mdata,
            'engines' => $engine,
            'brands' => $brand,
            'chassiss' => $chassis,
            'vehicles' => $vehicle,
        ];
        return view('admin.mdata.copy_mdata', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        // 1. Validasi Dasar (Pastikan semua ID terisi)
        // Gunakan nama input sesuai di Blade: engines, brands, chassiss, vehicles
        $validator = Validator::make($input, [
            'engines' => 'required',
            'brands' => 'required',
            'chassiss' => 'required',
            'vehicles' => 'required',
        ]);

        if ($validator->fails()) {
            // Mengembalikan error validation standar jika ada select box yang kosong
            return redirect()->back()->withErrors($validator)->withInput()
                ->with('error', 'Semua pilihan (Engine, Merk, Chassis, Kendaraan) harus diisi!');
        }

        // 2. Pengecekan Duplikasi Berdasarkan Kombinasi 4 Kolom
        // Pengecekan ini memanfaatkan perbaikan Unique Index Komposit yang sudah kita jalankan
        $isDuplicate = Mdata::where('engine_id', $input['engines'])
            ->where('brand_id', $input['brands'])
            ->where('chassis_id', $input['chassiss'])
            ->where('vehicle_id', $input['vehicles'])
            ->exists();

        if ($isDuplicate) {
            // Jika duplikat, kembalikan dengan pesan 'error' spesifik untuk Toastr
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan! Kombinasi Master Data ini sudah terdaftar (Duplikat).');
        }

        // 3. Simpan Data jika tidak duplikat
        try {
            Mdata::create([
                'engine_id' => $input['engines'],
                'brand_id' => $input['brands'],
                'chassis_id' => $input['chassiss'],
                'vehicle_id' => $input['vehicles'],
            ]);

            // Jika sukses, kembalikan dengan pesan 'success' untuk Toastr
            return redirect()->route('index.mdata')->with('success', 'Master data berhasil ditambahkan!');
        } catch (Exception $e) {
            // Ini untuk menangani error sistem lain (misalnya koneksi database)
            return redirect()->back()->withInput()
                ->with('error', 'Data tidak tersimpan! Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function mdata_edit($id)
    {
        $mdata = Mdata::findOrFail($id);
        $engine = Engine::orderBy('created_at', 'desc')->get();
        $brand = Brand::orderBy('created_at', 'desc')->get();
        $chassis = Chassis::orderBy('created_at', 'desc')->get();
        $vehicle = Vehicle::orderBy('created_at', 'desc')->get();

        $data = [
            'mdata' => $mdata,
            'engines' => $engine,
            'brands' => $brand,
            'chassiss' => $chassis,
            'vehicles' => $vehicle,
        ];
        return view('admin.mdata.edit_mdata', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'engines'    => 'required|exists:tb_engines,id',
            'brands'    => 'required|exists:tb_brands,id',
            'chassiss'    => 'required|exists:tb_chassiss,id',
            'vehicles'    => 'required|exists:tb_vehicles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan!');
        }

        $input = $request->all();

        // Pengecekan Duplikasi saat Update
        // Pastikan kombinasi 4 ID ini belum ada di data lain, kecuali data yang sedang di-edit ($id)
        $isDuplicate = Mdata::where('engine_id', $input['engines'])
            ->where('brand_id', $input['brands'])
            ->where('chassis_id', $input['chassiss'])
            ->where('vehicle_id', $input['vehicles'])
            ->where('id', '!=', $id) // Kecualikan ID yang sedang diperbarui
            ->exists();

        if ($isDuplicate) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal diperbarui! Kombinasi Master Data ini sudah terdaftar pada entri lain (Duplikat).');
        }

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

    public function delete($id)
    {
        try {
            $mdata = Mdata::findOrFail($id);
            $mdata->delete();

            return redirect()->route('index.mdata')->with('success', 'Master data berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak terhapus! Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
