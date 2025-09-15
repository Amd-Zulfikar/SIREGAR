<?php

namespace App\Http\Controllers\Drafter;

use App\Models\Admin\Varian;
use Illuminate\Http\Request;
use App\Models\Admin\Mgambar;
use App\Models\Admin\Customer;
use App\Models\Admin\Employee;
use App\Models\Admin\Submission;
use App\Models\Drafter\Workspace;
use App\Http\Controllers\Controller;

class WorkspaceController extends Controller
{
    public function index()
    {
        // Ambil semua workspace beserta relasi customer, employee, submission
        $workspaces = Workspace::with(['customer', 'employee', 'submission'])->paginate(10);

        // Kirim data ke view index.blade.php
        return view('drafter.workspace.index', compact('workspaces'));
    }

    public function workspace_add()
    {
        $customer = Customer::all();
        $employee = Employee::all();
        $submission = Submission::all();
        $varian = Varian::all();
        $mgambar = Mgambar::all();

        $data = [
            'customers' => $customer,
            'employees' => $employee,
            'submissions' => $submission,
            'varians' => $varian,
            'mgambars' => $mgambar,
        ];
        return view('drafter.workspace.add_workspace', $data);
    }

    public function workspace_edit($id)
    {
        $workspace = Workspace::with('workspaceGambar.mgambar')->findOrFail($id);

        $customers = Customer::all();
        $employees = Employee::all();
        $submissions = Submission::all();
        $mgambars = Mgambar::all();
        $varians = Varian::all();

        // Kirim data ke view edit.blade.php
        return view('drafter.workspace.edit_workspace', compact('workspace', 'customers', 'employees', 'submissions', 'mgambars', 'varians'));
    }

    public function workspace_show($id)
    {
        $workspace = Workspace::with(['customer', 'employee', 'submission', 'workspaceGambar.mgambar'])->findOrFail($id);

        // Kirim data ke view show.blade.php
        return view('drafter.workspace.show', compact('workspace'));
    }

    public function store(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'no_transaksi'  => 'required|unique:workspaces,no_transaksi',
            'customer_id'   => 'required|exists:customers,id',
            'employee_id'   => 'required|exists:employees,id',
            'submission_id' => 'required|exists:submissions,id',
        ]);

        // Simpan ke database
        Workspace::create($validated);

        // Redirect ke list workspace dengan pesan sukses
        return redirect()->route('index.workspace')
            ->with('success', 'Workspace berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // nanti implement logic:
        // update workspace
        // tambah/hapus gambar (workspace_gambar)
    }

    public function select_upload($id)
    {
        $mgambars = Mgambar::where('id', $id)->get();

        // return JSON untuk AJAX
        return response()->json([
            'error' => false,
            'data' => $mgambars
        ]);
    }

    public function export($id)
    {
        $workspace = Workspace::with(['customer', 'employee', 'submission', 'workspaceGambar.mgambar'])->findOrFail($id);

        // nanti implement logic:
        // - ambil semua foto_body (mgambar)
        // - timpa text overlay sesuai koordinat
        // - generate PDF / JPG per gambar atau seluruh workspace
    }
}
