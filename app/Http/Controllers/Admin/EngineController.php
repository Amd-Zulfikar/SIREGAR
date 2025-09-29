<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Admin\Engine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EngineController extends Controller
{
    public function index()
    {
        $engines = Engine::orderBy('created_at', 'desc')->get();

        return view('admin.engine.index', [
            'title' => 'Data engines',
            'engines' => $engines,
        ]);
    }

    public function engine_add()
    {
        return view('admin.engine.add_engine');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan! Periksa input Anda.');
        }

        $input = $request->all();
        try {
            // dd($request->all()); //  cek isi request masuk atau enggak
            Engine::create([
                'name' => $input['name'],
            ]);

            return redirect()->route('index.engine')->with('success', 'Engine berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak tersimpan! Terjadi kesalahan: '. $e->getMessage());
        }
    }

    public function engine_edit($id)
    {
        $tbengine = Engine::find($id);

        if (!$tbengine) {
            return redirect()->route('index.engine')->with('error', 'Engine tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Data Engine', 
            'engine' => $tbengine, 
            'engines' => Engine::all()];

        return view('admin.engine.edit_engine', $data);
    }
 
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data gagal disimpan! Periksa input Anda.');
        }

        $engine = Engine::find($id);
        if (!$engine) {
            return redirect()->route('index.engine')->with('error', 'Engine tidak ditemukan!');
        }

        $input = $request->all();
        try {
            // dd($request->all()); //  cek isi request masuk atau enggak
            $engine->update([
                'name' => $input['name'],
            ]);

            return redirect()->route('index.engine')->with('success', 'Engine berhasil diupdate!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak terupdate! Terjadi kesalahan: '. $e->getMessage());
        }
    }

    public function delete($id)
    {
        $engine = Engine::find($id);

        if (!$engine) {
            return redirect()->route('index.engine')->with('error', 'Engine tidak ditemukan!');
        }

        try {
            $engine->delete();
            return redirect()->route('index.engine')->with('success', 'Engine berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->route('index.engine')->with('error', 'Data tidak terhapus! Terjadi kesalahan: '. $e->getMessage());
        }
    }
    
}
