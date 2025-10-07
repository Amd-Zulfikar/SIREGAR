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
                            <li class="breadcrumb-item active">Copy</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                {{-- Form diarahkan ke store (copy data lama sebagai data baru) --}}
                <form method="POST" action="{{ route('store.mgambar') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="is_copy" value="1">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Salin Data Gambar:
                                        {{ $mgambar->varian_body ?? $mgambar->keterangan }}</h3>
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

                                            {{-- 1. GAMBAR UTAMA --}}
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label class="text-info"><i class="fas fa-image"></i> Gambar Utama
                                                    @if ($mgambar->foto_utama)
                                                        <span class="badge badge-info ml-1">TERSEDIA</span>
                                                    @endif
                                                </label>

                                                @if ($mgambar->foto_utama)
                                                    <img src="{{ asset('storage/body/' . $mgambar->foto_utama) }}"
                                                        class="img-thumbnail border border-secondary mb-2"
                                                        style="max-width: 150px; cursor:pointer;"
                                                        onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
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
                                                            <input type="file" name="foto_utama" style="display: none;"
                                                                onchange="updateFileName(this, 'utama')">
                                                        </label>
                                                    </div>
                                                </div>
                                                <p class="text-danger small mt-1">* Gambar lama tidak akan tersimpan,
                                                    silakan upload gambar baru.</p>
                                                <div class="preview mt-2" id="preview_utama"></div>
                                            </div>

                                            {{-- 2. GAMBAR TERURAI --}}
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label class="text-warning"><i class="fas fa-layer-group"></i> Gambar
                                                    Terurai
                                                    @if ($mgambar->foto_terurai)
                                                        <span class="badge badge-warning ml-1">TERSEDIA</span>
                                                    @endif
                                                </label>

                                                @if ($mgambar->foto_terurai)
                                                    <img src="{{ asset('storage/body/' . $mgambar->foto_terurai) }}"
                                                        class="img-thumbnail border border-secondary mb-2"
                                                        style="max-width: 150px; cursor:pointer;"
                                                        onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
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
                                                            <input type="file" name="foto_terurai" style="display: none;"
                                                                onchange="updateFileName(this, 'terurai')">
                                                        </label>
                                                    </div>
                                                </div>
                                                <p class="text-danger small mt-1">* Gambar lama tidak akan tersimpan,
                                                    silakan upload gambar baru.</p>
                                                <div class="preview mt-2" id="preview_terurai"></div>
                                            </div>

                                            {{-- 3. GAMBAR KONSTRUKSI --}}
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label class="text-primary"><i class="fas fa-tools"></i> Gambar Konstruksi
                                                    @if ($mgambar->foto_kontruksi)
                                                        <span class="badge badge-primary ml-1">TERSEDIA</span>
                                                    @endif
                                                </label>

                                                @if ($mgambar->foto_kontruksi)
                                                    <img src="{{ asset('storage/body/' . $mgambar->foto_kontruksi) }}"
                                                        class="img-thumbnail border border-secondary mb-2"
                                                        style="max-width: 150px; cursor:pointer;"
                                                        onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
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
                                                                style="display: none;"
                                                                onchange="updateFileName(this, 'kontruksi')">
                                                        </label>
                                                    </div>
                                                </div>
                                                <p class="text-danger small mt-1">* Gambar lama tidak akan tersimpan,
                                                    silakan upload gambar baru.</p>
                                                <div class="preview mt-2" id="preview_kontruksi"></div>
                                            </div>

                                            {{-- 4. GAMBAR DETAIL --}}
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label class="text-success"><i class="fas fa-search-plus"></i> Gambar
                                                    Detail
                                                    @if ($mgambar->foto_optional)
                                                        <span class="badge badge-success ml-1">TERSEDIA</span>
                                                    @endif
                                                </label>

                                                @if ($mgambar->foto_optional)
                                                    <img src="{{ asset('storage/body/' . $mgambar->foto_optional) }}"
                                                        class="img-thumbnail border border-secondary mb-2"
                                                        style="max-width: 150px; cursor:pointer;"
                                                        onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                @else
                                                    <p class="text-muted small mt-1">Belum ada gambar detail.</p>
                                                @endif

                                                <div class="input-group mt-2">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Pilih file baru (opsional)" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-success mb-0">
                                                            Upload Baru
                                                            <input type="file" name="foto_optional"
                                                                style="display: none;"
                                                                onchange="updateFileName(this, 'detail')">
                                                        </label>
                                                    </div>
                                                </div>
                                                <p class="text-danger small mt-1">* Gambar lama tidak akan tersimpan,
                                                    silakan upload gambar baru.</p>
                                                <div class="preview mt-2" id="preview_detail"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-end">
                                    <a href="{{ route('index.mgambar') }}"
                                        class="btn btn-outline-danger mr-2">Kembali</a>
                                    <input type="submit" value="Copy & Paste Data Gambar"
                                        class="btn btn-outline-success">
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
            $('.select2').select2()
        });

        function updateFileName(input, type) {
            const fileNameInput = $(input).closest('.input-group').find('.file-name-display');
            const newPreviewContainer = $('#preview_' + type);
            newPreviewContainer.html('');

            if (input.files.length > 0) {
                const file = input.files[0];
                fileNameInput.val(file.name);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = $('<img src="' + e.target.result +
                        '" class="img-thumbnail border border-success" style="max-width: 150px; height: auto; cursor:pointer;">' +
                        '<p class="text-success small mt-1">Preview Gambar BARU</p>');

                    img.on('click', function() {
                        $('#imgPreviewModal').attr('src', e.target.result);
                        $('#modalPreview').modal('show');
                    });

                    newPreviewContainer.append(img);
                }
                reader.readAsDataURL(file);
            } else {
                fileNameInput.val('Pilih file baru (opsional)');
                newPreviewContainer.html('');
            }
        }
    </script>
@endpush
