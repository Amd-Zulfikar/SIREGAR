<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(5);

        return view('admin.role.index', [
            'title' => 'Data Roles',
            'roles' => $roles,
        ]);
    }

    // public function view () {

    //     try {
    //         $data = Role::paginate(5);
    //         return $data;
    //     }
    //     catch(Exception $e){
    //       dd($e->getMessage());
    //     }
    // }

    public function role_add()
    {
        return view('admin.role.add_role');
    }

    public function role_edit($id)
    {
        $tbrole = Role::find($id);

        if (!$tbrole) {
            return redirect()->route('index.role')->with('error', 'Role tidak ditemukan!');
        }

        $data = ['title' => 'Edit Data Role', 'role' => $tbrole, 'roles' => Role::all()];

        return view('admin.role.edit_role', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan! Periksa input Anda.');
        }
        $input = $request->all();

        try {
            // dd($request->all()); //  cek isi request masuk atau enggak
            Role::create([
                'name' => $input['name'],
                'keterangan' => $input['keterangan'],
            ]);

            return redirect()->route('index.role')->with('success', 'Role berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan.');
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            session()->flash('message', $validator->messages()->first());

            return back()->withInput();
        }
        $input = $request->all();

        try {
            $role = Role::findOrFail($id);
            $role->update([
                'name' => $input['name'],
                'keterangan' => $input['keterangan'],
            ]);

            return redirect()->route('index.role')->with('success', 'Role berhasil diupdate!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan.');
        }
    }
}
