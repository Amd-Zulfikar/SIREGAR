<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Mdata;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\MgambarElectricity;

class MgambarElectricityController extends Controller
{
     public function index () {
        $mgambarelectricitys = MgambarElectricity::with('mdata')->orderBy('created_at', 'desc')->get();

        return view ('admin.mgambar_electricity.index', [
            'title' => 'Data Gambar',
            'mgambarelectricitys' => $mgambarelectricitys,
        ]);
    }

    public function mgambarelectricity_add (){
        $mdatas = Mdata::orderBy('created_at', 'desc')->get();
        return view('admin.mgambar_electricity.add_mgambar_electricity', compact('mdatas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mdata_id' => 'required|exists:tb_mdata,id',
            'foto_kelistrikan.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'description.*' => 'required|string',
        ]);

        if ($request->hasFile('foto_kelistrikan')) {
            foreach ($request->file('foto_kelistrikan') as $index => $file) {
                // Hilangkan spasi dan buat nama unik
                $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

                // Simpan file ke storage/app/public/body/electricity
                $path = $file->storeAs('body/electricity', $fileName, 'public');

                // Simpan ke database
                MgambarElectricity::create([
                    'mdata_id'    => $request->mdata_id,
                    'file_name'   => $fileName,
                    'file_path'   => $path,
                    'description' => $request->description[$index],
                ]);
            }
        }

        return redirect()->route('index.mgambarelectricity')->with('success', 'Gambar berhasil ditambahkan!');
    }

    public function mgambarelectricity_edit($id)
    {
        $mgambarelectricity = MgambarElectricity::findOrFail($id);
        $mdatas = Mdata::orderBy('created_at', 'desc')->get();

        return view('admin.mgambar_electricity.edit_mgambar_electricity', compact('mgambarelectricity', 'mdatas'));
    }

    public function update(Request $request, $id)
    {
        $mgambarelectricity = MgambarElectricity::findOrFail($id);

        $request->validate([
            'mdata_id' => 'required|exists:tb_mdata,id',
            'description' => 'required|string',
            'foto_kelistrikan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'mdata_id' => $request->mdata_id,
            'description' => $request->description,
        ];

        if ($request->hasFile('foto_kelistrikan')) {
            if ($mgambarelectricity->file_path && Storage::disk('public')->exists($mgambarelectricity->file_path)) {
                Storage::disk('public')->delete($mgambarelectricity->file_path);
            }

            $path = $request->file('foto_kelistrikan')->store('body/kelistrikan', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $request->file('foto_kelistrikan')->getClientOriginalName();
        }

        $mgambarelectricity->update($data);

        return redirect()->route('index.mgambarelectricity')->with('success', 'Data berhasil diperbarui!');
    }

    public function delete($id)
    {
        try {
            // Cari data berdasarkan ID
            $mgambarelectricity = MgambarElectricity::findOrFail($id);

            // Hapus file fisiknya jika ada
            if ($mgambarelectricity->file_path && Storage::disk('public')->exists($mgambarelectricity->file_path)) {
                Storage::disk('public')->delete($mgambarelectricity->file_path);
            }

            // Hapus data dari database
            $mgambarelectricity->delete();

            return redirect()->route('index.mgambarelectricity')->with('success', 'Data gambar berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('index.mgambarelectricity')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}
