<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Varian;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

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
                'name_utama' => [
                    'nullable',
                    Rule::unique('tb_varians', 'name_utama')->whereNotNull('name_utama'),
                ],
                'name_terurai' => [
                    'nullable',
                    Rule::unique('tb_varians', 'name_terurai')->whereNotNull('name_terurai'),
                ],
                'name_kontruksi' => [
                    'nullable',
                    Rule::unique('tb_varians', 'name_kontruksi')->whereNotNull('name_kontruksi'),
                ],
                'name_optional' => [
                    'nullable',
                    Rule::unique('tb_varians', 'name_optional')->whereNotNull('name_optional'),
                ],
            ],
            [
                'name_utama.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
                'name_terurai.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
                'name_kontruksi.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
                'name_optional.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
            ]
        );

        Varian::create([
            'name_utama' => $request->name_utama ?: null,
            'name_terurai' => $request->name_terurai ?: null,
            'name_kontruksi' => $request->name_kontruksi ?: null,
            'name_optional' => $request->name_optional ?: null,
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
                'name_optional' => 'required|unique:tb_varians,name_optional',
            ],
            [
                'name_utama.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
                'name_terurai.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
                'name_kontruksi.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
                'name_optional.unique' => 'Varian sudah ada, silahkan gunakan nama lain!',
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
            'name_optional' => $input['name_optional'],
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
