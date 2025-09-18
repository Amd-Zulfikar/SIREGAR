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
                            <li class="breadcrumb-item active">Master Gambar</li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="{{ route('store.mgambar') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Gambar</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Pilih Data</label>
                                                <select name="mdata_id" class="form-control select2" style="width: 100%;"
                                                    required>
                                                    <option selected disabled>Pilih Data</option>
                                                    @foreach ($mdatas as $mdata)
                                                        <option value="{{ $mdata->id }}">
                                                            {{ $mdata->engine->name ?? '-' }} -
                                                            {{ $mdata->brand->name ?? '-' }} -
                                                            {{ $mdata->chassis->name ?? '-' }} -
                                                            {{ $mdata->vehicle->name ?? '-' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger">{{ $errors->first('mdata_id') }}</small>
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Body</label>
                                                <input name="keterangan" type="text" class="form-control"
                                                    placeholder="Contoh: TAMPAK UTAMA (BOX SLIDING)" required>
                                                <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Upload Foto Body</label>
                                                <div class="custom-file">
                                                    <input type="file" name="foto_body[]" id="foto_body"
                                                        class="custom-file-input" multiple>
                                                    <label class="custom-file-label" for="foto_body">Choose files</label>
                                                </div>
                                                <small class="text-danger">{{ $errors->first('foto_body') }}</small>
                                            </div>

                                            <div class="form-group">
                                                <label>Preview Gambar</label>
                                                <div class="preview row" id="previews"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer me-2">
                                    <a href="{{ route('index.mgambar') }}" class="btn btn-danger">Kembali</a>
                                    <input type="submit" value="Simpan" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Modal Preview Gambar -->
                <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <img src="" id="imgPreviewModal" class="img-fluid w-100">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

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

        // Preview gambar sebelum submit & klik untuk modal
        $('#foto_body').on('change', function() {
            $('#previews').html('');
            const files = this.files;
            if (files) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = $('<div class="col-4 mb-2"><img src="' + e.target.result +
                            '" class="img-thumbnail" style="width:100%; cursor:pointer;"></div>');
                        img.find('img').on('click', function() {
                            $('#imgPreviewModal').attr('src', e.target.result);
                            $('#modalPreview').modal('show');
                        });
                        $('#previews').append(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>
@endpush
