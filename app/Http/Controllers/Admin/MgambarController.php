<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Admin\Mdata;
use App\Models\Admin\Mgambar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MgambarController extends Controller
{
    /**
     * Menampilkan daftar semua data gambar.
     */
    public function index()
    { 
        $mgambars = Mgambar::with('mdata')->orderBy('created_at', 'desc')->get(); 

        return view('admin.mgambar.index', [
            'title' => 'Data Gambar',
            'mgambars' => $mgambars,
        ]);
    }

    /**
     * Form tambah data gambar.
     */
    public function mgambar_add()
    {
        $mdatas = Mdata::orderBy('created_at', 'desc')->get();
        return view('admin.mgambar.add_mgambar', compact('mdatas'));
    }

    /**
     * Simpan data baru.
     */
    public function store(Request $request)
    {
        // Hapus Validasi Array dan Deskripsi Optional
        $validator = Validator::make($request->all(), [
            'mdata_id'       => 'required|exists:tb_mdata,id',
            'varian_body'    => 'required|string|max:255',
            'foto_utama'     => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            'foto_terurai'   => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            'foto_kontruksi' => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            'foto_optional'  => 'nullable|image|mimes:jpg,jpeg,png|max:1000', 
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Data gagal disimpan! Pastikan semua sesuai format.');
        }

        try {
            $dataFiles = [];
            $fileFields = ['foto_utama', 'foto_terurai', 'foto_kontruksi', 'foto_optional']; // Tambah foto_optional

            // Simpan file utama, terurai, konstruksi, dan optional (sebagai file tunggal)
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    // Sesuaikan direktori untuk optional jika perlu, di sini saya samakan ke 'body'
                    $directory = 'body'; 
                    
                    // Gunakan direktori berbeda untuk optional jika Anda mau
                    // $directory = ($field == 'foto_optional') ? 'body/optional' : 'body';
                    
                    $filename = time() . '_' . $field . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                    $file->storeAs($directory, $filename, 'public');
                    $dataFiles[$field] = $filename;
                } else {
                    $dataFiles[$field] = null;
                }
            }

            // Simpan data utama ke tabel tb_mgambar
            Mgambar::create([
                'mdata_id'       => $request->mdata_id,
                'keterangan'     => $request->varian_body,
                'foto_utama'     => $dataFiles['foto_utama'],
                'foto_terurai'   => $dataFiles['foto_terurai'],
                'foto_kontruksi' => $dataFiles['foto_kontruksi'],
                'foto_optional'  => $dataFiles['foto_optional'], 
            ]);

            // Catatan: Seluruh logika penyimpanan ke tb_mgambar_optional telah dihapus.

            return redirect()->route('index.mgambar')->with('success', 'Master Gambar berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Data tidak tersimpan: ' . $e->getMessage());
        }
    }


    /**
     * Form copy data.
     */
    public function mgambar_copy($id)
    {
        // Jika model `Mgambar` tidak lagi memiliki relasi optionalImages, hapus with() di sini
        $mgambar = Mgambar::findOrFail($id);
        $mdatas = Mdata::orderBy('created_at', 'desc')->get();

        return view('admin.mgambar.copy_mgambar', compact('mgambar', 'mdatas'));
    }

    /**
     * Form edit data.
     */
    public function mgambar_edit($id)
    {
        // Jika model `Mgambar` tidak lagi memiliki relasi optionalImages, hapus with() di sini
        $mgambar = Mgambar::findOrFail($id);
        $mdatas = Mdata::orderBy('created_at', 'desc')->get();

        return view('admin.mgambar.edit_mgambar', compact('mgambar', 'mdatas'));
    }

    /**
     * Update data gambar.
     */
    public function update(Request $request, $id)
    {
        $mgambar = Mgambar::findOrFail($id);

        // Hapus Validasi Optional Array dan Deskripsi
        $validator = Validator::make($request->all(), [
            'mdata_id'       => 'required|exists:tb_mdata,id',
            'varian_body'    => 'required|string|max:255',
            'foto_utama'     => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            'foto_terurai'   => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            'foto_kontruksi' => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            // Validasi untuk single optional file
            'foto_optional'  => 'nullable|image|mimes:jpg,jpeg,png|max:1000', 
            // 'optional_id.*' => 'nullable|integer|exists:tb_mgambar_optional,id', // Dihapus
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan!');
        }

        try {
            // --- Update file utama/terurai/konstruksi/optional ---
            $fileFields = ['foto_utama', 'foto_terurai', 'foto_kontruksi', 'foto_optional'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $directory = 'body'; 

                    // Hapus file lama jika ada (optional file sekarang diperlakukan sama)
                    if ($mgambar->{$field} && Storage::disk('public')->exists($directory . '/' . $mgambar->{$field})) {
                        Storage::disk('public')->delete($directory . '/' . $mgambar->{$field});
                    }

                    $filename = time() . '_' . $field . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                    $file->storeAs($directory, $filename, 'public');
                    $mgambar->$field = $filename;
                } else {
                    // Jika tidak ada file baru, pastikan file lama tetap ada
                    // Jika Anda ingin user bisa menghapus foto_optional, Anda perlu input hidden atau checkbox
                    // Saat ini, diasumsikan file lama (jika ada) dipertahankan
                    if (!$request->has('old_' . $field) && $field != 'foto_optional') { // Logika old_field di form edit 
                        // Jika tidak ada 'old_field' dan field bukan optional, biarkan nilai di model
                    }
                    
                    // Catatan: Jika Anda perlu menghapus file, Anda harus menyediakan input di form untuk itu.
                }
            }

            $mgambar->mdata_id = $request->mdata_id;
            $mgambar->keterangan = $request->varian_body;
            $mgambar->save();

            // --- Logika Update/Tambah Optional Images (Array) Dihapus ---
            // Jika Anda TIDAK menggunakan tabel optional terpisah lagi, bagian ini harus dihapus total
            // Jika Anda masih menggunakan tabel terpisah, Anda harus merevisinya.

            return redirect()->route('index.mgambar')->with('success', 'Data berhasil diupdate!');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal update: '.$e->getMessage());
        }
    }


    /**
     * Hapus data gambar.
     */
    public function delete($id)
    {
        $mgambar = Mgambar::findOrFail($id);

        // Hapus file utama, terurai, konstruksi, dan optional
        $fileFields = ['foto_utama', 'foto_terurai', 'foto_kontruksi', 'foto_optional'];
        $directory = 'body'; // Lokasi penyimpanan semua file utama

        foreach ($fileFields as $field) {
            if ($mgambar->{$field} && Storage::disk('public')->exists($directory . '/' . $mgambar->{$field})) {
                Storage::disk('public')->delete($directory . '/' . $mgambar->{$field});
            }
        }

        // Catatan: Logika penghapusan array optionalImages dari tabel terpisah telah dihapus

        $mgambar->delete();

        return redirect()->route('index.mgambar')->with('success', 'Data gambar berhasil dihapus.');
    }

}