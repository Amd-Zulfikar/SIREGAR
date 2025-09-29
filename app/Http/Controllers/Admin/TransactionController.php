<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Admin\Chassis;
use App\Models\Admin\Vehicle;
use App\Models\Admin\Customer;
use App\Models\Admin\Employee;
use App\Models\Admin\Submission;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->get();

        return view('admin.transaction.index', [
            'title' => 'Data transactions',
            'transactions' => $transactions,
        ]);
    }

    public function transaction_add()
    {
        $customers   = Customer::all();
        $chassis     = Chassis::all();
        $vehicles    = Vehicle::all();
        $employees   = Employee::all();
        $submissions = Submission::all();

        return view('admin.transaction.add_transaction', compact(
            'customers',
            'chassis',
            'vehicles',
            'employees',
            'submissions'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'        => 'required|exists:tb_customers,id',
            'nomor_kementrian'   => 'required|string|max:255',
            'status_kementrian'  => 'required|string|max:255',
            'status_internal'    => 'required|string|max:255',
            'prioritas'          => 'required|string|max:255',
            'chassis_id'         => 'required|exists:tb_chassis,id',
            'vehicle_id'         => 'required|exists:tb_vehicle,id',
            'drafter_id'         => 'nullable|exists:tb_employees,id',
            'checker_id'         => 'nullable|exists:tb_employees,id',
            'submission_id'      => 'required|exists:tb_submissions,id',
        ]);

        // Generate order number format RKS-dmyxxxx
        $todayDate = now()->format('dmy');
        $last = Transaction::orderBy('id', 'desc')->first();
        $nextId = $last ? $last->id + 1 : 1;
        $orderNo = 'RKS-' . $todayDate . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        Transaction::create([
            'order_no'         => $orderNo,
            'customer_id'      => $request->customer_id,
            'nomor_kementrian' => $request->nomor_kementrian,
            'status_kementrian' => $request->status_kementrian,
            'status_internal'  => $request->status_internal,
            'prioritas'        => $request->prioritas,
            'chassis_id'       => $request->chassis_id,
            'vehicle_id'       => $request->vehicle_id,
            'drafter_id'       => $request->drafter_id,
            'checker_id'       => $request->checker_id,
            'submission_id'    => $request->submission_id,
        ]);

        return redirect()->route('index.transaction')->with('success', 'Transaksi berhasil ditambahkan!');
    }
}
