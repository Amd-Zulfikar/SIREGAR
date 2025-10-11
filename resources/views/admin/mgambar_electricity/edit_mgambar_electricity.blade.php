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
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="{{ route('update.mgambarelectricity', $mgambarelectricity->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Gambar electricity</h3>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Pilih Data Kendaraan</label>
                                                <select name="mdata_id" class="form-control select2" style="width: 100%;"
                                                    required>
                                                    <option selected disabled>Pilih Data</option>
                                                    @foreach ($mdatas as $mdata)
                                                        <option value="{{ $mdata->id }}"
                                                            {{ $mdata->id == $mgambarelectricity->mdata_id ? 'selected' : '' }}>
                                                            {{ $mdata->engine->name ?? '-' }} -
                                                            {{ $mdata->brand->name ?? '-' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('mdata_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label class="text-info"><i class="fas fa-image"></i> Gambar Lama</label>
                                                <div class="mb-2">
                                                    @if ($mgambarelectricity->file_path && Storage::disk('public')->exists($mgambarelectricity->file_path))
                                                        <img src="{{ Storage::url($mgambarelectricity->file_path) }}"
                                                            alt="Gambar Lama" class="img-thumbnail old-img"
                                                            style="max-width:150px; cursor:pointer;">
                                                    @else
                                                        <span class="text-muted">Tidak ada gambar lama</span>
                                                    @endif
                                                </div>

                                                <label class="text-info"><i class="fas fa-upload"></i> Upload Gambar Baru
                                                    (Opsional)</label>
                                                <div class="input-group mb-2">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Belum ada file dipilih" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-info mb-0">
                                                            Upload Gambar
                                                            <input type="file" name="foto_kelistrikan"
                                                                class="foto_kelistrikan" style="display:none;"
                                                                accept="image/*" onchange="updateFileName(this)">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="preview mt-2"></div>

                                                <label class="mt-2">Deskripsi</label>
                                                <input type="text" name="description"
                                                    class="form-control form-control-sm"
                                                    value="{{ old('description', $mgambarelectricity->description) }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <a href="{{ route('index.mgambarelectricity') }}"
                                        class="btn btn-outline-danger">Kembali</a>
                                    <button type="submit" class="btn btn-outline-success">Update Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Modal Preview -->
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
            $('.select2').select2();

            // Klik gambar lama untuk preview besar
            $(document).on('click', '.old-img', function() {
                $('#imgPreviewModal').attr('src', $(this).attr('src'));
                $('#modalPreview').modal('show');
            });
        });

        // Fungsi preview dan ubah nama file
        function updateFileName(input) {
            const fileNameInput = $(input).closest('.input-group').find('.file-name-display');
            const previewContainer = $(input).closest('.form-group').find('.preview');
            previewContainer.html('');

            if (input.files.length > 0) {
                const file = input.files[0];
                fileNameInput.val(file.name);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = $('<img src="' + e.target.result +
                        '" class="img-thumbnail" style="max-width: 150px; height: auto; cursor:pointer;" alt="Preview Gambar">'
                    );
                    img.on('click', function() {
                        $('#imgPreviewModal').attr('src', e.target.result);
                        $('#modalPreview').modal('show');
                    });
                    previewContainer.append(img);
                }
                reader.readAsDataURL(file);
            } else {
                fileNameInput.val('Belum ada file dipilih');
            }
        }
    </script>
@endpush
