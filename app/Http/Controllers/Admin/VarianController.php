<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Varian;
use Illuminate\Http\Request;

class VarianController extends Controller
{
    public function index()
    {
        $varians = Varian::paginate(5);

        return view('admin.varian.index', [
            'title' => 'Data varians',
            'varians' => $varians,
        ]);
    }

    public function varian_add()
    {
        return view('admin.varian.add_varian');
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $input = $request->all();
        Varian::create([
            'name' => $input['name'],
        ]);

        return redirect()->route('index.varian')->with('success', 'Data berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $tbvarian = Varian::find($id);
        if (!$tbvarian) {
            return redirect()->route('index.varian')->with('error', 'Varian tidak ditemukan!');
        }

        $input = $request->all();
        $tbvarian->update([
            'name' => $input['name'],
        ]);

        return redirect()->route('index.varian')->with('success', 'Data berhasil diupdate!');
    }
}
