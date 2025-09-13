<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Models\Admin\Account;
use App\Models\Admin\Employee;
use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = User::paginate(5);

        return view('admin.account.index', [
            'title' => 'Data accounts',
            'accounts' => $accounts,
        ]);
    }

    public function account_add()
    {
        $role = Role::all();
        $data = [
            'roles' => $role,
        ];
        return view('admin.account.add_account', $data);
    }

    public function account_edit($id)
    {
        $tbaccount = User::find($id);

        if (!$tbaccount) {
            return redirect()->route('index.account')->with('error', 'Account tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Data Account',
            'account' => $tbaccount,
            'accounts' => User::all(),
        ];

        return view('admin.account.edit_account', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'roles' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan!');
        }

        $input = $request->all();
        try {
            $insert = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'role_id' => $input['roles'],
            ]);

            return redirect()->route('index.account')->with('success', 'Account berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan.');
        }
    }



    public function action(Request $request, $id)
    {
        $account = User::findOrFail($id);

        // Validasi agar hanya 0/1 yang bisa masuk
        $status = $request->status == 1 ? 1 : 0;

        $account->status = $status;
        $account->save();

        return response()->json([
            'success' => true,
            'status'  => $account->status,
            'message' => $status ? 'Akun diaktifkan' : 'Akun dinonaktifkan'
        ]);
    }
}
