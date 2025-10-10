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
                            <li class="breadcrumb-item active">Pemeriksa</li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="{{ route('store.pemeriksa') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Pemeriksa</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Nama Pemeriksa</label>
                                                <input name="name" type="text" class="form-control"
                                                    placeholder="Masukan Nama Pemeriksa" required>
                                                <small>{{ $errors->first('name') }}</small>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="foto_paraf">Upload Gambar Paraf</label>
                                                <div class="custom-file">
                                                    <input type="file" name="foto_paraf[]" id="foto_paraf"
                                                        class="custom-file-input" multiple required>
                                                    <label class="custom-file-label" for="foto_paraf">Choose files</label>
                                                </div>
                                                <small>{{ $errors->first('foto_paraf') }}</small>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Preview Gambar</label>
                                                <div class="preview row" id="previews"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer me-2">
                                    <a href="{{ route('index.pemeriksa') }}" class="btn btn-outline-danger">Kembali</a>
                                    <input type="submit" value="Simpan" class="btn btn-outline-success">
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
        $(document).ready(function() {
            if (typeof bsCustomFileInput !== 'undefined') {
                bsCustomFileInput.init();
            }

            // Preview gambar sebelum submit & klik untuk modal
            $('#foto_paraf').on('change', function() {
                $('#previews').html('');
                const files = this.files;
                if (files) {
                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = $('<div class="col-4 mb-2"><img src="' + e.target
                                .result +
                                '" class="img-thumbnail" style="width:100%; cursor:pointer;"></div>'
                            );

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
        });
    </script>
@endpush
