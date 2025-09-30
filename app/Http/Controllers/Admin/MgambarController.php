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
    public function index()
    {
        $mgambars = Mgambar::with('mdata')->orderBy('created_at', 'desc')->get();

        return view('admin.mgambar.index', [
            'title' => 'Data Gambar',
            'mgambars' => $mgambars,
        ]);
    }

    public function mgambar_add()
    {
        $mdatas = Mdata::orderBy('created_at', 'desc')->get();
        return view('admin.mgambar.add_mgambar', compact('mdatas'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mdata_id'   => 'required',
            'keterangan' => 'required|string|max:255',
            'foto_body'  => 'nullable|array',
            'foto_body.*' => 'file|mimes:jpg,jpeg,png|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Data gagal disimpan!');
        }

        try {
            $fotoFiles = [];

            if ($request->hasFile('foto_body')) {
                foreach ($request->file('foto_body') as $file) {
                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                    $file->storeAs('body', $filename, 'public');
                    $fotoFiles[] = $filename;
                }
            }

            Mgambar::create([
                'mdata_id'   => $request->mdata_id,
                'keterangan' => $request->keterangan,
                'foto_body'  => $fotoFiles, // array langsung, Laravel cast ke JSON
                'status'     => 1,
            ]);

            return redirect()->route('index.mgambar')
                ->with('success', 'Master Gambar berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Data tidak tersimpan! Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function mgambar_edit($id)
    {
        $mgambar = Mgambar::findOrFail($id);
        $mdatas = Mdata::orderBy('created_at', 'desc')->get();

        return view('admin.mgambar.edit_mgambar', compact('mgambar', 'mdatas'));
    }

    public function update(Request $request, $id)
    {
        $mgambar = Mgambar::findOrFail($id);

        $request->validate([
            'mdatas'      => 'required|exists:tb_mdata,id',
            'keterangans' => 'required|string|max:255',
            'foto_body.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $mgambar->mdata_id   = $request->mdatas;
        $mgambar->keterangan = $request->keterangans;

        // File lama dari DB sudah array karena $casts
        $oldFiles = $mgambar->foto_body ?? [];

        // File lama yang masih dipertahankan dari form
        $existingFiles = $request->existing_files ?? [];

        // Hapus file lama yang tidak dipertahankan
        foreach ($oldFiles as $file) {
            if (!in_array($file, $existingFiles) && Storage::disk('public')->exists('body/' . $file)) {
                Storage::disk('public')->delete('body/' . $file);
            }
        }

        // Simpan file baru jika ada
        $newFiles = [];
        if ($request->hasFile('foto_body')) {
            foreach ($request->file('foto_body') as $file) {
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                $file->storeAs('body', $filename, 'public');
                $newFiles[] = $filename;
            }
        }

        // Gabungkan file lama yang dipertahankan + file baru
        $mgambar->foto_body = array_merge($existingFiles, $newFiles);

        $mgambar->save();

        return redirect()->route('index.mgambar')
            ->with('success', 'Data gambar berhasil diperbarui.');
    }

    public function action(Request $request, $id)
    {
        $mgambar = Mgambar::findOrFail($id);
        $mgambar->status = $request->status;
        $mgambar->save();

        return response()->json(['success' => true, 'status' => $mgambar->status]);
    }
}
