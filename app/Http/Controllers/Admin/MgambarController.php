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
            $fileFields = ['foto_utama', 'foto_terurai', 'foto_kontruksi', 'foto_optional'];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = time() . '_' . $field . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                    $file->storeAs('body', $filename, 'public');
                    $dataFiles[$field] = $filename;
                } else {
                    $dataFiles[$field] = null;
                }
            }

            Mgambar::create([
                'mdata_id'       => $request->mdata_id,
                'keterangan'     => $request->varian_body,
                'foto_utama'     => $dataFiles['foto_utama'],
                'foto_terurai'   => $dataFiles['foto_terurai'],
                'foto_kontruksi' => $dataFiles['foto_kontruksi'],
                'foto_optional'  => $dataFiles['foto_optional'],
            ]);

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
        $mgambar = Mgambar::findOrFail($id);
        $mdatas = Mdata::orderBy('created_at', 'desc')->get();

        return view('admin.mgambar.copy_mgambar', compact('mgambar', 'mdatas'));
    }

    /**
     * Form edit data.
     */
    public function mgambar_edit($id)
    {
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

        $validator = Validator::make($request->all(), [
            'mdata_id'       => 'required|exists:tb_mdata,id',
            'varian_body'    => 'required|string|max:255',
            'foto_utama'     => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            'foto_terurai'   => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            'foto_kontruksi' => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            'foto_optional'  => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal diperbarui!');
        }

        try {
            $mgambar->mdata_id   = $request->mdata_id;
            $mgambar->keterangan = $request->varian_body;

            $fileFields = ['foto_utama', 'foto_terurai', 'foto_kontruksi', 'foto_optional'];

            foreach ($fileFields as $field) {
                $oldFile = $mgambar->{$field};

                if ($request->hasFile($field)) {
                    if ($oldFile && Storage::disk('public')->exists('body/' . $oldFile)) {
                        Storage::disk('public')->delete('body/' . $oldFile);
                    }
                    $file = $request->file($field);
                    $filename = time() . '_' . $field . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                    $file->storeAs('body', $filename, 'public');
                    $mgambar->{$field} = $filename;
                } elseif ($request->input('clear_' . $field) == '1') {
                    if ($oldFile && Storage::disk('public')->exists('body/' . $oldFile)) {
                        Storage::disk('public')->delete('body/' . $oldFile);
                    }
                    $mgambar->{$field} = null;
                }
            }

            $mgambar->save();

            return redirect()->route('index.mgambar')->with('success', 'Data gambar berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Update gagal: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data gambar.
     */
    public function delete($id)
    {
        $mgambar = Mgambar::findOrFail($id);

        $fileFields = ['foto_utama', 'foto_terurai', 'foto_kontruksi', 'foto_optional'];

        foreach ($fileFields as $field) {
            if ($mgambar->{$field} && Storage::disk('public')->exists('body/' . $mgambar->{$field})) {
                Storage::disk('public')->delete('body/' . $mgambar->{$field});
            }
        }

        $mgambar->delete();

        return redirect()->route('index.mgambar')->with('success', 'Data gambar berhasil dihapus.');
    }
}
