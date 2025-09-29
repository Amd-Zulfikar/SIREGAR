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
                            <li class="breadcrumb-item active">Transaksi</li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="{{ route('store.transaction') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Input Data Order</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Nama Perusahaan</label>
                                                <select id="customer_id" class="form-control select2">
                                                    <option selected disabled>Pilih Perusahaan</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Jenis Pengajuan</label>
                                                <input name="submission_id" type="text" class="form-control"
                                                    placeholder="Pengajuan" required>
                                                <small>{{ $errors->first('submission_id') }}</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Prioritas</label>
                                                <input name="prioritas" type="text" class="form-control"
                                                    placeholder="prioritas" required>
                                                <small>{{ $errors->first('prioritas') }}</small>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">


                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer me-2">
                                        <a href="{{ route('index.transaction') }}" class="btn btn-danger">Kembali</a>
                                        <input type="submit" value="Simpan" class="btn btn-success">
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
            $('.select2').select2()
        });

        if (typeof bsCustomFileInput !== 'undefined') {
            bsCustomFileInput.init();
        }
    </script>
@endpush
