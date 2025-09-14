<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate(5);

        return view('admin.employee.index', [
            'title' => 'Data Employees',
            'employees' => $employees,
        ]);
    }

    public function employee_add()
    {
        return view('admin.employee.add_employee');
    }

    public function employee_edit($id)
    {
        $tbemployee = Employee::find($id);

        if (!$tbemployee) {
            return redirect()->route('index.employee')->with('error', 'Employee tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Data Employee',
            'employee' => $tbemployee,
            'employees' => Employee::all(),
        ];

        return view('admin.employee.edit_employee', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:50',
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

            Employee::create([
                'name' => $request->name,
                'contact' => $request->contact,
                'foto_paraf' => $fotoFiles ? json_encode($fotoFiles) : null,
                'status' => 1,
            ]);

            return redirect()->route('index.employee')->with('success', 'Pegawai berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan: '. $e->getMessage());
        }
    }

    public function action(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = $request->status;
        $employee->save();

        return response()->json(['success' => true, 'status' => $employee->status]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'foto_paraf.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data
        $employee->name = $request->name;
        $employee->contact = $request->contact;

        // Ambil file lama dari DB
        $oldFiles = $employee->foto_paraf ? json_decode($employee->foto_paraf, true) : [];

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
        $employee->foto_paraf = json_encode(array_merge($existingFiles, $newFiles));

        $employee->save();

        return redirect()->route('index.employee')->with('success', 'Data pegawai berhasil diupdate.');
    }
}
