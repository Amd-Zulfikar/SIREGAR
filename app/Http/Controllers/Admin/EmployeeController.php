<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\Admin\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index() {
        $employees = Employee::paginate(5);
        
        return view('admin.employee.index', [
            'title' => 'Data Employees',
            'employees' => $employees,
        ]);
    }

    public function employee_add() {
        return view('admin.employee.add_employee');
    }

    public function employee_edit($id) {
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
            'contact'=> 'nullable|string|max:50',
            'foto_paraf'=> 'nullable|array',
            'foto_paraf.*'=> 'file|mimes:jpg,jpeg,png|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Data gagal disimpan!');
        }

        try {
            $fotoFiles = [];

            if ($request->hasFile('foto_paraf')) {
                foreach ($request->file('foto_paraf') as $file) {
                    $filename = time().'_'.preg_replace('/[^A-Za-z0-9\_\-\.]/', '_', $file->getClientOriginalName());

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
        } catch(Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan.');
        }
    }

    public function action(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = $request->status;
        $employee->save();

        return response()->json(['success' => true, 'status' => $employee->status]);
    }

    public function update(Request $request, string $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'contact'=> 'required',
        ]);

        if ($validator->fails()) {
            session()->flash('message', $validator->messages()->first());
            return back()->withInput();
        }

        try {
            $employee = Employee::findOrFail($id);
            $employee->update([
                'name' => $request->name,
                'contact' => $request->contact,
            ]);

            return redirect()->route('index.employee')->with('success', 'Employee berhasil diupdate!');
        } catch(Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan.');
        }
    }
}
