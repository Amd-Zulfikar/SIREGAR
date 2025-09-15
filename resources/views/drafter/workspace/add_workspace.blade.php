@extends('drafter.layouts.app')

@section('content')
    <div class="container">
        <h4 class="mb-4">Tambah Workspace</h4>

        {{-- Form tambah workspace --}}
        <form action="{{ route('store.workspace') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Pilih Customer --}}
            <div class="mb-3">
                <label for="customer_id" class="form-label">Customer</label>
                <select name="customer_id" id="customer_id" class="form-control" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Drafter --}}
            <div class="mb-3">
                <label for="employee_id" class="form-label">Drafter</label>
                <select name="employee_id" id="employee_id" class="form-control" required>
                    <option value="">-- Pilih Drafter --</option>
                    @foreach ($employees as $e)
                        <option value="{{ $e->id }}">{{ $e->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Submission --}}
            <div class="mb-3">
                <label for="" class="form-label">Submission</label>
                <select name="submission" id="submission" class="form-control">
                    <option value="">-- Pilih Submission --</option>
                    @foreach ($submissions as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Varians (Judul Gambar) --}}
            <div class="mb-3">
                <label for="varian_id" class="form-label">Judul Gambar</label>
                <select name="varian_id" id="varian_id" class="form-control">
                    <option value="">-- Pilih Judul Gambar --</option>
                    @foreach ($varians as $v)
                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Nomor Gambar --}}
            <div class="mb-3">
                <label for="no_gambar" class="form-label">Nomor Gambar</label>
                <input type="text" name="no_gambar" id="no_gambar" class="form-control" placeholder="Contoh: 01"
                    required>
            </div>

            {{-- Jumlah Gambar --}}
            <div class="mb-3">
                <label for="jumlah_gambar" class="form-label">Jumlah Gambar</label>
                <input type="number" name="jumlah_gambar" id="jumlah_gambar" class="form-control" placeholder="Contoh: 5"
                    required>
            </div>

            {{-- Upload Foto Body --}}
            <div class="mb-3">
                <label for="foto_body" class="form-label">Upload Foto Body</label>
                <input type="file" name="foto_body[]" id="foto_body" class="form-control" multiple required>
                <small class="text-muted">Bisa upload lebih dari 1 gambar</small>
            </div>

            {{-- Tombol --}}
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('index.workspace') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
