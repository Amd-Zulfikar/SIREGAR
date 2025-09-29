@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account</li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="{{ route('store.account') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Account</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Nama Pengguna</label>
                                                <input name="name" type="text" class="form-control"
                                                    placeholder="Masukan Nama Pengguna" required>
                                                <small>{{ $errors->first('name') }}</small>
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Role</label>
                                                <select name="roles" class="form-control select2" style="width: 100%;">
                                                    <option selected disabled>Pilih Role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                <small>{{ $errors->first('roles') }}</small>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input name="email" type="text" class="form-control"
                                                    placeholder="Masukan Email" required>
                                                <small>{{ $errors->first('email') }}</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Password</label>
                                                <input name="password" type="password" class="form-control"
                                                    placeholder="Masukan Password" required>
                                                <small>{{ $errors->first('password') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer me-2">
                                    <a href="{{ route('index.account') }}" class="btn btn-outline-danger">Kembali</a>
                                    <input type="submit" value="Simpan" class="btn btn-outline-success">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
@endpush
