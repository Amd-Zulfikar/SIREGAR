<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::orderBy('created_at', 'desc')->get();

        return view('admin.submission.index', [
            'title' => 'Data submissions',
            'submissions' => $submissions,
        ]);
    }

    public function submission_add()
    {
        return view('admin.submission.add_submission');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:tb_submissions,name',
            ],
            [
                'name.unique' => 'Pengajuan sudah ada, silahkan gunakan nama lain!',
            ]
        );

        $input = $request->all();
        Submission::create([
            'name' => $input['name'],
        ]);

        return redirect()->route('index.submission')->with('success', 'Data berhasil disimpan!');
    }

    public function submission_edit($id)
    {
        $tbsubmission = Submission::find($id);

        if (!$tbsubmission) {
            return redirect()->route('index.submission')->with('error', 'Submission tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Data Submission',
            'submission' => $tbsubmission,
            'submissions' => Submission::all()
        ];

        return view('admin.submission.edit_submission', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|unique:tb_submissions,name',
            ],
            [
                'name.unique' => 'Pengajuan sudah ada, silahkan gunakan nama lain!',
            ]
        );

        $tbsubmission = Submission::find($id);
        if (!$tbsubmission) {
            return redirect()->route('index.submission')->with('error', 'Jenis Pengajuan tidak ditemukan!');
        }

        $input = $request->all();
        $tbsubmission->update([
            'name' => $input['name'],
        ]);

        return redirect()->route('index.submission')->with('success', 'Data berhasil diupdate!');
    }

    public function delete($id)
    {
        $tbsubmission = Submission::find($id);
        if (!$tbsubmission) {
            return redirect()->route('index.submission')->with('error', 'Submission tidak ditemukan!');
        }

        $tbsubmission->delete();

        return redirect()->route('index.submission')->with('success', 'Data berhasil dihapus!');
    }
}
