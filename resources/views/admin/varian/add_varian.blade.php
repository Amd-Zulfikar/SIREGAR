@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <!-- <h1>General Form</h1> -->
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Jenis Varian</li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="{{ route('store.varian') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Jenis Varian</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Nama Tampak Utama</label>
                                                <input name="name_utama" type="text" class="form-control"
                                                    placeholder="Contoh: Gambar Tampak Utama Standar">
                                                <small>{{ $errors->first('name_utama') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Nama Tampak Terurai</label>
                                                <input name="name_terurai" type="text" class="form-control"
                                                    placeholder="Contoh: Gambar Tampak Terurai Standar">
                                                <small>{{ $errors->first('name_terurai') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Nama Tampak Kontruksi</label>
                                                <input name="name_kontruksi" type="text" class="form-control"
                                                    placeholder="Contoh: Gambar Detail Kontruksi Standar">
                                                <small>{{ $errors->first('name_kontruksi') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Nama Tampak Optional/Detail</label>
                                                <input name="name_optional" type="text" class="form-control"
                                                    placeholder="Contoh: Gambar Detail Pengikat">
                                                <small>{{ $errors->first('name_optional') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer me-2">
                                    <a href="{{ route('index.varian') }}" class="btn btn-outline-danger">Kembali</a>
                                    <input type="Submit" value="Simpan" class="btn btn-outline-success ">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
    </div>
@endsection
