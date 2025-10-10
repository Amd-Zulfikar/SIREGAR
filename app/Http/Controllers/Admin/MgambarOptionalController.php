<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Mdata;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\MgambarOptional;
use Illuminate\Support\Facades\Storage;

class MgambarOptionalController extends Controller
{
    public function index () {
        $mgambaroptionals = MgambarOptional::with('mdata')->orderBy('created_at', 'desc')->get();

        return view ('admin.mgambar_optional.index', [
            'title' => 'Data Gambar',
            'mgambaroptionals' => $mgambaroptionals,
        ]);
    }

    public function mgambaroptional_add (){
        $mdatas = Mdata::orderBy('created_at', 'desc')->get();
        return view('admin.mgambar_optional.add_mgambar_optional', compact('mdatas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mdata_id' => 'required|exists:tb_mdata,id',
            'foto_detail.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'description.*' => 'required|string',
        ]);

        if ($request->hasFile('foto_detail')) {
            foreach ($request->file('foto_detail') as $index => $file) {
                // Hilangkan spasi dan buat nama unik
                $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

                // Simpan file ke storage/app/public/body/detail
                $path = $file->storeAs('body/detail', $fileName, 'public');

                // Simpan ke database
                MgambarOptional::create([
                    'mdata_id'    => $request->mdata_id,
                    'file_name'   => $fileName,
                    'file_path'   => $path,
                    'description' => $request->description[$index],
                ]);
            }
        }

        return redirect()->route('index.mgambaroptional')->with('success', 'Gambar berhasil ditambahkan!');
    }

    public function mgambaroptional_edit($id)
    {
        $mgambaroptional = MgambarOptional::findOrFail($id);
        $mdatas = Mdata::orderBy('created_at', 'desc')->get();

        return view('admin.mgambar_optional.edit_mgambar_optional', compact('mgambaroptional', 'mdatas'));
    }

    public function update(Request $request, $id)
    {
        $mgambaroptional = MgambarOptional::findOrFail($id);

        $request->validate([
            'mdata_id' => 'required|exists:tb_mdata,id',
            'description' => 'required|string',
            'foto_detail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'mdata_id' => $request->mdata_id,
            'description' => $request->description,
        ];

        if ($request->hasFile('foto_detail')) {
            if ($mgambaroptional->file_path && Storage::disk('public')->exists($mgambaroptional->file_path)) {
                Storage::disk('public')->delete($mgambaroptional->file_path);
            }

            $path = $request->file('foto_detail')->store('body/detail', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $request->file('foto_detail')->getClientOriginalName();
        }

        $mgambaroptional->update($data);

        return redirect()->route('index.mgambaroptional')->with('success', 'Data berhasil diperbarui!');
    }

    public function delete($id)
    {
        try {
            // Cari data berdasarkan ID
            $mgambaroptional = MgambarOptional::findOrFail($id);

            // Hapus file fisiknya jika ada
            if ($mgambaroptional->file_path && Storage::disk('public')->exists($mgambaroptional->file_path)) {
                Storage::disk('public')->delete($mgambaroptional->file_path);
            }

            // Hapus data dari database
            $mgambaroptional->delete();

            return redirect()->route('index.mgambaroptional')->with('success', 'Data gambar berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('index.mgambaroptional')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}
