<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Admin\Mdata;
use Illuminate\Http\Request;
use App\Models\Admin\Mgambar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MgambarController extends Controller
{
    public function index()
    {
        $mgambars = Mgambar::with('mdata')->paginate(5);

        return view('admin.mgambar.index', [
            'title' => 'Data Gambar',
            'mgambars' => $mgambars,
        ]);
    }

    public function mgambar_add()
    {
        $mdata = Mdata::all();

        $data = [
            'mdatas' => $mdata,
        ];
        return view('admin.mgambar.add_mgambar', $data);
    }

    public function mgambar_edit($id)
    {
        $tbgambar = Mgambar::find($id);

        if (!$tbgambar) {
            return redirect()->route('index.mgambar')->with('error', 'Gambar tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Data Gambar',
            'mgambar' => $tbgambar,
            'mdatas' => Mdata::all(),
        ];

        return view('admin.mgambar.edit_mgambar', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mdata_id' => 'required',
            'keterangan' => 'required',
            'foto_body' => 'nullable|array',
            'foto_body.*' => 'file|mimes:jpg,jpeg,png|max:2000',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan!');
        }

        try {
            $fotoFiles = [];

            if ($request->hasFile('foto_body')) {
                foreach ($request->file('foto_body') as $file) {
                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\_\-\.]/', '_', $file->getClientOriginalName());

                    $file->storeAs('body', $filename, 'public');
                    $fotoFiles[] = $filename;
                }
            }

            Mgambar::create([
            'mdata_id'   => $request->mdata_id,
            'keterangan' => $request->keterangan,
            'foto_body'  => !empty($fotoFiles) ? json_encode($fotoFiles) : null,
            'status'     => 1,
        ]   );

            return redirect()->route('index.mgambar')->with('success', 'Master Gambar berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan: '. $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $mgambar = Mgambar::findOrFail($id);

        // Validasi input
        $request->validate([
            'mdatas'        => 'required|exists:tb_mdata,id',
            'keterangans'   => 'required|string|max:255',
            'foto_body.*'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update relasi dan keterangan
        $mgambar->mdata_id   = $request->mdatas;
        $mgambar->keterangan = $request->keterangans;

        // Ambil file lama dari DB
        $oldFiles = $mgambar->foto_body ? json_decode($mgambar->foto_body, true) : [];

        // Ambil file lama yang masih dipertahankan dari form
        $existingFiles = $request->existing_files ?? [];

        // Hapus file lama yang tidak dipertahankan
        if ($oldFiles) {
            foreach ($oldFiles as $file) {
                if (!in_array($file, $existingFiles) && Storage::disk('public')->exists('body/' . $file)) {
                    Storage::disk('public')->delete('body/' . $file);
                }
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

        // Gabungkan file lama yang masih ada + file baru
        $mgambar->foto_body = json_encode(array_merge($existingFiles, $newFiles));

        $mgambar->save();

        return redirect()->route('index.mgambar')->with('success', 'Data gambar berhasil diperbarui.');
    }
    
    public function action(Request $request, $id)
    {
        $mgambar = Mgambar::findOrFail($id);
        $mgambar->status = $request->status;
        $mgambar->save();

        return response()->json(['success' => true, 'status' => $mgambar->status]);
    }
}
