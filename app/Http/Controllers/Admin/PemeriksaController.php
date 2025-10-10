<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\Admin\Pemeriksa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PemeriksaController extends Controller
{
    public function index()
    {
        $pemeriksas = Pemeriksa::orderBy('created_at', 'desc')->get();

        return view('admin.pemeriksa.index', [
            'title' => 'Data pemeriksas',
            'pemeriksas' => $pemeriksas,
        ]);
    }

    public function pemeriksa_add()
    {
        return view('admin.pemeriksa.add_pemeriksa');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'foto_paraf' => 'nullable|array',
            'foto_paraf.*' => 'file|mimes:jpg,jpeg,png|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan!');
        }

        try {
            $fotoFiles = [];

            if ($request->hasFile('foto_paraf')) {
                foreach ($request->file('foto_paraf') as $file) {
                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\_\-\.]/', '_', $file->getClientOriginalName());

                    $file->storeAs('paraf', $filename, 'public');
                    $fotoFiles[] = $filename;
                }
            }

            Pemeriksa::create([
                'name' => $request->name,
                'foto_paraf' => $fotoFiles ? json_encode($fotoFiles) : null,
            ]);

            return redirect()->route('index.pemeriksa')->with('success', 'Pemeriksa berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pemeriksa_edit($id)
    {
        $tbpemeriksa = Pemeriksa::find($id);

        if (!$tbpemeriksa) {
            return redirect()->route('index.pemeriksa')->with('error', 'Pemeriksa tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Data Pemeriksa',
            'pemeriksa' => $tbpemeriksa,
            'pemeriksas' => Pemeriksa::all(),
        ];

        return view('admin.pemeriksa.edit_pemeriksa', $data);
    }

    public function update(Request $request, $id)
    {
        $pemeriksa = Pemeriksa::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'foto_paraf.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data
        $pemeriksa->name = $request->name;
        $pemeriksa->contact = $request->contact;

        // Ambil file lama dari DB
        $oldFiles = $pemeriksa->foto_paraf ? json_decode($pemeriksa->foto_paraf, true) : [];

        // Ambil file lama yang masih ada setelah submit form
        $existingFiles = $request->existing_files ?? [];

        // Hapus file lama yang sudah dihapus di form
        if ($oldFiles) {
            foreach ($oldFiles as $file) {
                if (!in_array($file, $existingFiles) && Storage::disk('public')->exists('paraf/' . $file)) {
                    Storage::disk('public')->delete('paraf/' . $file);
                }
            }
        }

        // Simpan file baru jika ada
        $newFiles = [];
        if ($request->hasFile('foto_paraf')) {
            foreach ($request->file('foto_paraf') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('paraf', $filename, 'public');
                $newFiles[] = $filename;
            }
        }

        // Gabungkan file lama yang masih ada + file baru
        $pemeriksa->foto_paraf = json_encode(array_merge($existingFiles, $newFiles));

        $pemeriksa->save();

        return redirect()->route('index.pemeriksa')->with('success', 'Data pegawai berhasil diupdate.');
    }

    public function delete($id)
    {
        $pemeriksa = Pemeriksa::findOrFail($id);

        // Hapus file foto_paraf dari storage
        if ($pemeriksa->foto_paraf) {
            $fotoFiles = json_decode($pemeriksa->foto_paraf, true);
            foreach ($fotoFiles as $file) {
                if (Storage::disk('public')->exists('paraf/' . $file)) {
                    Storage::disk('public')->delete('paraf/' . $file);
                }
            }
        }

        $pemeriksa->delete();

        return redirect()->route('index.pemeriksa')->with('success', 'Data pegawai berhasil dihapus.');
    }
}
