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
                {{-- Form diarahkan ke store (update) --}}
                <form method="POST" action="{{ route('store.mgambar') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Data Gambar: {{ $mgambar->varian_body }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        {{-- KOLOM KIRI --}}
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Pilih Data Kendaraan</label>
                                                <select name="mdata_id"
                                                    class="form-control select2 @error('mdata_id') is-invalid @enderror"
                                                    style="width: 100%;" required>
                                                    <option disabled>Pilih Data</option>
                                                    @foreach ($mdatas as $mdata)
                                                        <option value="{{ $mdata->id }}"
                                                            {{ old('mdata_id', $mgambar->mdata_id) == $mdata->id ? 'selected' : '' }}>
                                                            {{ $mdata->engine->name ?? '-' }} -
                                                            {{ $mdata->brand->name ?? '-' }} -
                                                            {{ $mdata->chassis->name ?? '-' }} -
                                                            {{ $mdata->vehicle->name ?? '-' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('mdata_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Varian Body / Keterangan</label>
                                                <input name="varian_body" type="text"
                                                    class="form-control @error('varian_body') is-invalid @enderror"
                                                    value="{{ old('varian_body', $mgambar->keterangan) }}"
                                                    placeholder="Contoh: BOX SLIDING / DROP SIDE 5 WAY" required>
                                                @error('varian_body')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- KOLOM KANAN --}}
                                        <div class="col-sm-6">

                                            {{-- GAMBAR UTAMA --}}
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label class="text-info"><i class="fas fa-image"></i>

                                                    Gambar Utama

                                                </label>
                                                @if ($mgambar->foto_utama)
                                                    <div class="current-image-preview mb-2" id="current_preview_utama">
                                                        <img src="{{ asset('storage/body/' . $mgambar->foto_utama) }}"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width:150px; height:auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Preview gambar lama (harus upload
                                                            ulang)</p>
                                                    </div>
                                                @else
                                                    <p class="text-muted small mt-1">Belum ada gambar utama.</p>
                                                @endif
                                                <div class="input-group mt-2">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Pilih file baru (opsional)" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-info mb-0">
                                                            Upload Baru
                                                            <input type="file" name="foto_utama" style="display:none;"
                                                                onchange="updateFileName(this,'utama')">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="preview mt-2" id="preview_utama"></div>
                                            </div>

                                            {{-- GAMBAR TERURAI --}}
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label class="text-warning"><i class="fas fa-layer-group"></i> Gambar
                                                    Terurai
                                                </label>
                                                @if ($mgambar->foto_terurai)
                                                    <div class="current-image-preview mb-2" id="current_preview_terurai">
                                                        <img src="{{ asset('storage/body/' . $mgambar->foto_terurai) }}"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width:150px; height:auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Preview gambar lama (harus upload
                                                            ulang)</p>
                                                    </div>
                                                @else
                                                    <p class="text-muted small mt-1">Belum ada gambar terurai.</p>
                                                @endif
                                                <div class="input-group mt-2">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Pilih file baru (opsional)" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-warning mb-0">
                                                            Upload Baru
                                                            <input type="file" name="foto_terurai" style="display:none;"
                                                                onchange="updateFileName(this,'terurai')">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="preview mt-2" id="preview_terurai"></div>
                                            </div>

                                            {{-- GAMBAR KONTRUKSI --}}
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label class="text-primary"><i class="fas fa-tools"></i>

                                                    Gambar Konstruksi

                                                </label>
                                                @if ($mgambar->foto_kontruksi)
                                                    <div class="current-image-preview mb-2" id="current_preview_kontruksi">
                                                        <img src="{{ asset('storage/body/' . $mgambar->foto_kontruksi) }}"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width:150px; height:auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Preview gambar lama (harus upload
                                                            ulang)</p>
                                                    </div>
                                                @else
                                                    <p class="text-muted small mt-1">Belum ada gambar konstruksi.</p>
                                                @endif
                                                <div class="input-group mt-2">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Pilih file baru (opsional)" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-primary mb-0">
                                                            Upload Baru
                                                            <input type="file" name="foto_kontruksi"
                                                                style="display:none;"
                                                                onchange="updateFileName(this,'kontruksi')">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="preview mt-2" id="preview_kontruksi"></div>
                                            </div>

                                            {{-- GAMBAR OPTIONAL (Copas, preview gambar lama) --}}
                                            <div class="form-group border p-3 rounded mb-3"
                                                style="background-color: #f7f9fc;">
                                                <label class="text-secondary"><i class="fas fa-plus-circle"></i> Gambar
                                                    Optional</label>

                                                {{-- Preview gambar lama --}}
                                                @if ($mgambar->foto_optional)
                                                    <div class="current-image-preview mb-2" id="current_preview_optional">
                                                        <img src="{{ asset('storage/body/' . $mgambar->foto_optional) }}"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width:150px; height:auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Preview gambar lama (harus upload
                                                            ulang)</p>
                                                    </div>
                                                @else
                                                    <p class="text-muted small mt-1">Belum ada gambar optional.</p>
                                                @endif

                                                {{-- Upload file baru --}}
                                                <div class="input-group mt-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Pilih file baru (opsional)" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-secondary mb-0">
                                                            Upload Baru
                                                            <input type="file" name="foto_optional" id="foto_optional"
                                                                style="display:none;" accept="image/*"
                                                                onchange="updateFileName(this, 'optional')">
                                                        </label>
                                                    </div>
                                                </div>

                                                {{-- Preview file baru --}}
                                                <div class="preview mt-2" id="preview_optional"></div>
                                            </div>



                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer me-2">
                                    <a href="{{ route('index.mgambar') }}" class="btn btn-outline-danger">Kembali</a>
                                    <input type="submit" value="Update Data Gambar" class="btn btn-outline-success">
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
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-dismiss="modal">Tutup</button>
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
        });

        function updateFileName(input, type) {
            const fileNameInput = $(input).closest('.input-group').find('.file-name-display');
            const previewContainer = $('#preview_' + type);
            previewContainer.html('');
            if (input.files.length > 0) {
                const file = input.files[0];
                fileNameInput.val(file.name);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = $('<img src="' + e.target.result +
                        '" class="img-thumbnail border border-success" style="max-width:150px; height:auto; cursor:pointer;">' +
                        '<p class="text-success small mt-1">Preview Gambar BARU</p>');
                    img.on('click', function() {
                        $('#imgPreviewModal').attr('src', e.target.result);
                        $('#modalPreview').modal('show');
                    });
                    previewContainer.append(img);
                }
                reader.readAsDataURL(file);
            } else {
                fileNameInput.val('Pilih file baru (opsional)');
                previewContainer.html('');
            }
        }

        // Optional Images JS
        $(function() {
            $(document).on('change', '.foto-optional-input', function() {
                const container = $(this).closest('.optional-block');
                const previewContainer = container.find('.preview');
                const fileNameInput = $(this).closest('.input-group').find('.file-name-display');

                previewContainer.html('');
                if (this.files.length > 0) {
                    const file = this.files[0];
                    fileNameInput.val(file.name);

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = $('<img src="' + e.target.result +
                            '" class="img-thumbnail" style="max-width:150px; cursor:pointer;">');
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
            });
        });
    </script>
@endpush
