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
                {{-- Form diarahkan ke route update dan menggunakan method PUT --}}
                <form method="POST" action="{{ route('update.mgambar', $mgambar->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Data Gambar: {{ $mgambar->varian_body }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        {{-- KOLOM KIRI: DATA UTAMA (Pre-populated) --}}
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

                                        {{-- KOLOM KANAN: UPLOAD GAMBAR 3 SEKAT (Dengan Preview Existing) --}}
                                        <div class="col-sm-6">

                                            {{-- BLOK 1: GAMBAR UTAMA --}}
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label for="foto_utama" class="text-info"><i class="fas fa-image"></i>
                                                    Gambar Utama
                                                    @if ($mgambar->foto_utama)
                                                        <span class="badge badge-info ml-1">TERSEDIA</span>
                                                    @endif
                                                </label>

                                                {{-- Tampilkan gambar yang sudah ada (Current Image Preview) --}}
                                                <div class="current-image-preview mb-2" id="current_preview_utama">
                                                    @if ($mgambar->foto_utama)
                                                        <img src="{{ asset('storage/body/' . $mgambar->foto_utama) }}"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width: 150px; height: auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Gambar saat ini (disimpan)</p>
                                                    @else
                                                        <p class="text-muted small mt-1">Belum ada gambar utama.</p>
                                                    @endif
                                                </div>
                                                {{-- Input tersembunyi untuk menyimpan nama file lama --}}
                                                <input type="hidden" name="old_foto_utama"
                                                    value="{{ $mgambar->foto_utama }}">

                                                <div class="input-group mt-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Pilih file baru (opsional)" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-info mb-0" for="foto_utama">
                                                            Upload Baru
                                                            <input type="file" name="foto_utama" id="foto_utama"
                                                                style="display: none;"
                                                                onchange="updateFileName(this, 'utama')">
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('foto_utama')
                                                    <small class="text-danger d-block">{{ $message }}</small>
                                                @enderror
                                                {{-- Area untuk preview gambar baru yang dipilih --}}
                                                <div class="preview mt-2" id="preview_utama"></div>
                                            </div>

                                            {{-- BLOK 2: GAMBAR TERURAI --}}
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label for="foto_terurai" class="text-warning"><i
                                                        class="fas fa-layer-group"></i> Gambar Terurai
                                                    @if ($mgambar->foto_terurai)
                                                        <span class="badge badge-warning ml-1">TERSEDIA</span>
                                                    @endif
                                                </label>

                                                <div class="current-image-preview mb-2" id="current_preview_terurai">
                                                    @if ($mgambar->foto_terurai)
                                                        {{-- KOREKSI: Menggunakan foto_terurai --}}
                                                        <img src="{{ asset('storage/body/' . $mgambar->foto_terurai) }}"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width: 150px; height: auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Gambar saat ini (disimpan)</p>
                                                    @else
                                                        <p class="text-muted small mt-1">Belum ada gambar terurai.</p>
                                                    @endif
                                                </div>
                                                <input type="hidden" name="old_foto_terurai"
                                                    value="{{ $mgambar->foto_terurai }}">

                                                <div class="input-group mt-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Pilih file baru (opsional)" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-warning mb-0" for="foto_terurai">
                                                            Upload Baru
                                                            <input type="file" name="foto_terurai" id="foto_terurai"
                                                                style="display: none;"
                                                                onchange="updateFileName(this, 'terurai')">
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('foto_terurai')
                                                    <small class="text-danger d-block">{{ $message }}</small>
                                                @enderror
                                                <div class="preview mt-2" id="preview_terurai"></div>
                                            </div>

                                            {{-- BLOK 3: GAMBAR KONTRUKSI --}}
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label for="foto_kontruksi" class="text-primary"><i
                                                        class="fas fa-tools"></i> Gambar Konstruksi
                                                    @if ($mgambar->foto_kontruksi)
                                                        <span class="badge badge-primary ml-1">TERSEDIA</span>
                                                    @endif
                                                </label>

                                                <div class="current-image-preview mb-2" id="current_preview_kontruksi">
                                                    @if ($mgambar->foto_kontruksi)
                                                        {{-- KOREKSI: Menggunakan foto_kontruksi --}}
                                                        <img src="{{ asset('storage/body/' . $mgambar->foto_kontruksi) }}"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width: 150px; height: auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Gambar saat ini (disimpan)</p>
                                                    @else
                                                        <p class="text-muted small mt-1">Belum ada gambar konstruksi.</p>
                                                    @endif
                                                </div>
                                                <input type="hidden" name="old_foto_kontruksi"
                                                    value="{{ $mgambar->foto_kontruksi }}">

                                                <div class="input-group mt-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Pilih file baru (opsional)" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-primary mb-0" for="foto_kontruksi">
                                                            Upload Baru
                                                            <input type="file" name="foto_kontruksi"
                                                                id="foto_kontruksi" style="display: none;"
                                                                onchange="updateFileName(this, 'kontruksi')">
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('foto_kontruksi')
                                                    <small class="text-danger d-block">{{ $message }}</small>
                                                @enderror
                                                <div class="preview mt-2" id="preview_kontruksi"></div>
                                            </div>

                                            {{-- BLOK 4: GAMBAR DETAIL --}}
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label for="foto_optional" class="text-success">
                                                    <i class="fas fa-search-plus"></i> Gambar Detail
                                                    @if ($mgambar->foto_optional)
                                                        <span class="badge badge-success ml-1">TERSEDIA</span>
                                                    @endif
                                                </label>

                                                <div class="current-image-preview mb-2" id="current_preview_detail">
                                                    @if ($mgambar->foto_optional)
                                                        <img src="{{ asset('storage/body/' . $mgambar->foto_optional) }}"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width: 150px; height: auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Gambar saat ini (disimpan)</p>
                                                    @else
                                                        <p class="text-muted small mt-1">Belum ada gambar detail.</p>
                                                    @endif
                                                </div>

                                                {{-- Hidden input untuk simpan nama file lama --}}
                                                <input type="hidden" name="old_foto_optional"
                                                    value="{{ $mgambar->foto_optional }}">

                                                <div class="input-group mt-3">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Pilih file baru (opsional)" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-success mb-0" for="foto_optional">
                                                            Upload Baru
                                                            <input type="file" name="foto_optional" id="foto_optional"
                                                                style="display: none;"
                                                                onchange="updateFileName(this, 'detail')">
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('foto_optional')
                                                    <small class="text-danger d-block">{{ $message }}</small>
                                                @enderror

                                                {{-- Preview gambar baru --}}
                                                <div class="preview mt-2" id="preview_detail"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <a href="{{ route('index.mgambar') }}"
                                        class="btn btn-outline-danger mr-2">Kembali</a>
                                    <input type="submit" value="Update Data Gambar" class="btn btn-outline-success">
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
            // Inisialisasi Select2
            $('.select2').select2()
        });

        // Fungsi untuk menampilkan nama file dan preview
        function updateFileName(input, type) {
            const fileNameInput = $(input).closest('.input-group').find('.file-name-display');
            const currentPreviewContainer = $('#current_preview_' + type); // Kontainer preview gambar lama
            const newPreviewContainer = $('#preview_' + type); // Kontainer preview gambar baru

            // 1. Bersihkan preview gambar baru sebelumnya
            newPreviewContainer.html('');

            if (input.files.length > 0) {
                const file = input.files[0];
                fileNameInput.val(file.name);

                // 2. Sembunyikan gambar yang saat ini tersimpan (agar tidak tumpang tindih dengan preview baru)
                currentPreviewContainer.hide();

                const reader = new FileReader();
                reader.onload = function(e) {
                    // Tampilkan preview gambar baru dengan border hijau
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
                // Jika file dibatalkan/dihapus, reset tampilan file name
                fileNameInput.val('Pilih file baru (opsional)');
                // 3. Tampilkan kembali gambar yang saat ini tersimpan
                currentPreviewContainer.show();
            }
        }
    </script>
@endpush
