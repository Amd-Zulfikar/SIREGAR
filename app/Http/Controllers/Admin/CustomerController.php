<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\Admin\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->get();

        return view('admin.customer.index', [
            'title' => 'Data customers',
            'customers' => $customers,
        ]);
    }

    public function customer_add()
    {
        return view('admin.customer.add_customer');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'direktur' => 'required|string|max:255',
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

            Customer::create([
                'name' => $request->name,
                'direktur' => $request->direktur,
                'foto_paraf' => $fotoFiles ? json_encode($fotoFiles) : null,
                'status' => 1,
            ]);

            return redirect()->route('index.customer')->with('success', 'Customer berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function customer_edit($id)
    {
        $tbcustomer = Customer::find($id);

        if (!$tbcustomer) {
            return redirect()->route('index.customer')->with('error', 'Customer tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Data Customer',
            'customer' => $tbcustomer,
            'customers' => Customer::all(),
        ];

        return view('admin.customer.edit_customer', $data);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'direktur' => 'required|string|max:255',
            'foto_paraf.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data
        $customer->name = $request->name;
        $customer->direktur = $request->direktur;

        // Ambil file lama dari DB
        $oldFiles = $customer->foto_paraf ? json_decode($customer->foto_paraf, true) : [];

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
        $customer->foto_paraf = json_encode(array_merge($existingFiles, $newFiles));

        $customer->save();

        return redirect()->route('index.customer')->with('success', 'Data pegawai berhasil diupdate.');
    }

    public function action(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->status = $request->status;
        $customer->save();

        return response()->json(['success' => true, 'status' => $customer->status]);
    }

    public function delete($id)
    {
        $customer = Customer::findOrFail($id);

        // Hapus file foto_paraf dari storage
        if ($customer->foto_paraf) {
            $fotoFiles = json_decode($customer->foto_paraf, true);
            foreach ($fotoFiles as $file) {
                if (Storage::disk('public')->exists('paraf/' . $file)) {
                    Storage::disk('public')->delete('paraf/' . $file);
                }
            }
        }

        $customer->delete();

        return redirect()->route('index.customer')->with('success', 'Customer berhasil dihapus!');
    }
}
