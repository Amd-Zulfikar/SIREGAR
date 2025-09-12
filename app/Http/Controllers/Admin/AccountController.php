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
        return view('backend.users.add_user', $data);
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
            'role_id' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan!');
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('index.customer')->with('success', 'Customer berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan.');
        }
    }
}
