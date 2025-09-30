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
                            <li class="breadcrumb-item active">Master Data</li>
                            <li class="breadcrumb-item active">Edit</li>
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
                                    <h3 class="card-title">Edit Data</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Pilih Engine</label>
                                                <select name="engines" id="engines" class="form-control select2"
                                                    style="width: 100%;">
                                                    <option selected disabled>Pilih Engine</option>
                                                    @foreach ($engines as $engine)
                                                        <option value="{{ $engine->id }}"
                                                            {{ $mdata->engine_id == $engine->id ? 'selected' : '' }}>
                                                            {{ $engine->name }}</option>
                                                    @endforeach
                                                </select>
                                                <small>{{ $errors->first('engines') }}</small>
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Merk</label>
                                                <select name="brands" id="brands" class="form-control select2"
                                                    style="width: 100%;">
                                                    <option selected disabled>Pilih Merk</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}"
                                                            {{ $mdata->brand_id == $brand->id ? 'selected' : '' }}>
                                                            {{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                                <small>{{ $errors->first('brands') }}</small>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label>Pilih Chassis</label>
                                                <select name="chassiss" id="chassiss" class="form-control select2"
                                                    style="width: 100%;">
                                                    <option selected disabled>Pilih Chassis</option>
                                                    @foreach ($chassiss as $chassis)
                                                        <option value="{{ $chassis->id }}"
                                                            {{ $mdata->chassis_id == $chassis->id ? 'selected' : '' }}>
                                                            {{ $chassis->name }}</option>
                                                    @endforeach
                                                </select>
                                                <small>{{ $errors->first('chassiss') }}</small>
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Jenis Kendaraan</label>
                                                <select name="vehicles" id="vehicles" class="form-control select2"
                                                    style="width: 100%;">
                                                    <option selected disabled>Pilih Jenis Kendaraan</option>
                                                    @foreach ($vehicles as $vehicle)
                                                        <option value="{{ $vehicle->id }}"
                                                            {{ $mdata->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                                            {{ $vehicle->name }}</option>
                                                    @endforeach
                                                </select>
                                                <small>{{ $errors->first('vehicles') }}</small>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer me-2">
                                    <a href="{{ route('index.mdata') }}" class="btn btn-outline-danger">Kembali</a>
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
