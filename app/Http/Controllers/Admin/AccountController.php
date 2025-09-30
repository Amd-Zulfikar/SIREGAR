<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Models\Admin\Account;
use App\Models\Admin\Customer;
use App\Models\Admin\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = User::orderBy('id', 'DESC')->get();

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
            'roles' => Role::all(),
        ];

        return view('admin.account.edit_account', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'roles' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8',
            ],
            [
                'email.unique' => 'Email sudah ada, silahkan gunakan email lain!',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan!');
        }

        $input = $request->all();
        try {
            User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'role_id' => $input['roles'],
                'status'   => 1, // default aktif
            ]);

            return redirect()->route('index.account')->with('success', 'Account berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users,email,' . $id,
                'roles'    => 'required|exists:tb_roles,id',
                'password' => 'nullable|string|min:8',
            ],
            [
                'email.unique' => 'Email sudah ada, silahkan gunakan email lain!',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::findOrFail($id);

            $data = [
                'name'    => $request->name,
                'email'   => $request->email,
                'role_id' => $request->roles,
            ];

            // Update password hanya jika diisi
            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('index.account')->with('success', 'Account berhasil diperbarui!');
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
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
