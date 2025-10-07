<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Varian;
use Illuminate\Http\Request;

class VarianController extends Controller
{
    public function index()
    {
        $varians = Varian::orderBy('created_at', 'desc')->get();

        return view('admin.varian.index', [
            'title' => 'Data varians',
            'varians' => $varians,
        ]);
    }

    public function varian_add()
    {
        return view('admin.varian.add_varian');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name_utama' => 'required|unique:tb_varians,name_utama',
                'name_terurai' => 'required|unique:tb_varians,name_terurai',
                'name_kontruksi' => 'required|unique:tb_varians,name_kontruksi',
            ],
            [
                'name_utama.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
                'name_terurai.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
                'name_kontruksi.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
            ]
        );

        $input = $request->all();
        Varian::create([
            'name_utama' => $input['name_utama'],
            'name_terurai' => $input['name_terurai'],
            'name_kontruksi' => $input['name_kontruksi'],
        ]);

        return redirect()->route('index.varian')->with('success', 'Data berhasil disimpan!');
    }

    public function varian_edit($id)
    {
        $tbvarian = Varian::find($id);

        if (!$tbvarian) {
            return redirect()->route('index.varian')->with('error', 'Varian tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Data Varian',
            'varian' => $tbvarian,
            'varians' => Varian::all()
        ];

        return view('admin.varian.edit_varian', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name_utama' => 'required|unique:tb_varians,name_utama',
                'name_terurai' => 'required|unique:tb_varians,name_terurai',
                'name_kontruksi' => 'required|unique:tb_varians,name_kontruksi',
            ],
            [
                'name_utama.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
                'name_terurai.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
                'name_kontruksi.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
            ]
        );

        $tbvarian = Varian::find($id);
        if (!$tbvarian) {
            return redirect()->route('index.varian')->with('error', 'Varian tidak ditemukan!');
        }

        $input = $request->all();
        $tbvarian->update([
            'name_utama' => $input['name_utama'],
            'name_terurai' => $input['name_terurai'],
            'name_kontruksi' => $input['name_kontruksi'],
        ]);

        return redirect()->route('index.varian')->with('success', 'Data berhasil diupdate!');
    }

    public function delete($id)
    {
        $tbvarian = Varian::find($id);
        if (!$tbvarian) {
            return redirect()->route('index.varian')->with('error', 'Varian tidak ditemukan!');
        }

        $tbvarian->delete();

        return redirect()->route('index.varian')->with('success', 'Data berhasil dihapus!');
    }
}
