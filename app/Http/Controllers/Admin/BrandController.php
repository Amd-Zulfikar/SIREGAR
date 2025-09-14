<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::paginate(5);

        return view('admin.brand.index', [
            'title' => 'Data brands',
            'brands' => $brands,
        ]);
    }

    public function brand_add()
    {
        return view('admin.brand.add_brand');
    }

    public function brand_edit($id)
    {
        $tbbrand = Brand::find($id);

        if (!$tbbrand) {
            return redirect()->route('index.brand')->with('error', 'Brand tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Data Brand', 
            'brand' => $tbbrand, 
            'brands' => Brand::all()];

        return view('admin.brand.edit_brand', $data);
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
            Brand::create([
                'name' => $input['name'],
            ]);

            return redirect()->route('index.brand')->with('success', 'Brand berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan: '. $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal diupdate! Periksa input Anda.');
        }

        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->route('index.brand')->with('error', 'Brand tidak ditemukan!');
        }

        $input = $request->all();
        try {
            $brand->update([
                'name' => $input['name'],
            ]);

            return redirect()->route('index.brand')->with('success', 'Brand berhasil diupdate!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak terupdate! Terjadi kesalahan: '. $e->getMessage());
        }
    }

    public function action(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->status = $request->status;
        $brand->save();

        return redirect()->route('index.brand')->with('success', 'Status brand berhasil diubah!');
    }
}
