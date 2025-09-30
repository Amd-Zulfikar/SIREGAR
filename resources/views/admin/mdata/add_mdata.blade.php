@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Master Data</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Master Data</li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="{{ route('store.mdata') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Data</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Pilih Engine</label>
                                                <select name="engines"
                                                    class="form-control select2 @error('engines') is-invalid @enderror"
                                                    style="width: 100%;">
                                                    <option selected disabled>Pilih Engine</option>
                                                    @foreach ($engines as $engine)
                                                        <option value="{{ $engine->id }}">{{ $engine->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('engines')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Merk</label>
                                                <select name="brands"
                                                    class="form-control select2 @error('brands') is-invalid @enderror"
                                                    style="width: 100%;">
                                                    <option selected disabled>Pilih Merk</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('brands')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Pilih Chassis</label>
                                                    <select name="chassiss"
                                                        class="form-control select2 @error('chassiss') is-invalid @enderror"
                                                        style="width: 100%;">
                                                        <option selected disabled>Pilih Chassis</option>
                                                        @foreach ($chassiss as $chassis)
                                                            <option value="{{ $chassis->id }}">{{ $chassis->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('chassiss')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Pilih Jenis Kendaraan</label>
                                                    <select name="vehicles"
                                                        class="form-control select2 @error('vehicles') is-invalid @enderror"
                                                        style="width: 100%;">
                                                        <option selected disabled>Pilih Jenis Kendaraan</option>
                                                        @foreach ($vehicles as $vehicle)
                                                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('vehicles')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer me-2">
                                    <a href="{{ route('index.mdata') }}" class="btn btn-outline-danger mr-2">Kembali</a>
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

        // Toastr untuk flash session
        var successMessage = "{{ session('success') ?? '' }}";
        var errorMessage = "{{ session('error') ?? '' }}";

        if (successMessage) toastr.success(successMessage);
        if (errorMessage) toastr.error(errorMessage);
    </script>
@endpush
