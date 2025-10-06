@extends('drafter.layouts.app')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <a href="{{ route('index.workspace') }}" class="btn btn-outline-primary"><i
                        class="fa-solid fa-circle-left"></i> Kembali</a>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form id="form-workspace" method="POST" action="{{ route('store.workspace') }}">
                    @csrf
                    <input type="hidden" name="brand_id" id="hidden_brand_id">
                    <input type="hidden" name="chassis_id" id="hidden_chassis_id">
                    <input type="hidden" name="vehicle_id" id="hidden_vehicle_id">
                    <input type="hidden" name="jumlah_gambar" id="hidden_jumlah_gambar" value="0">

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Ambil Gambar</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm text-left">Jumlah Gbr Tu :</label>
                                                <div class="col-sm-9">
                                                    <select name="jumlah_halaman" id="jumlah_halaman"
                                                        class="form-control form-control-sm select2-static" required
                                                        data-placeholder="Jumlah Hal.">
                                                        <option value="1" selected>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Customer :</label>
                                                <div class="col-sm-9">
                                                    <select name="customer_id" id="customers"
                                                        class="form-control form-control-sm select2" required
                                                        data-placeholder="Pilih Perusahaan">
                                                        <option></option>
                                                        @foreach ($customers as $c)
                                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Jenis Pengajuan :</label>
                                                <div class="col-sm-9">
                                                    <select name="submission_id" id="submissions"
                                                        class="form-control form-control-sm select2" style="width: 100%;"
                                                        required data-placeholder="Pilih Pengajuan">
                                                        <option></option>
                                                        @foreach ($submissions as $s)
                                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Diperiksa :</label>
                                                <div class="col-sm-9">
                                                    <select name="employee_id" id="employees"
                                                        class="form-control form-control-sm select2" style="width: 100%;"
                                                        required data-placeholder="Pilih Drafter">
                                                        <option></option>
                                                        @foreach ($employees as $e)
                                                            <option value="{{ $e->id }}">{{ $e->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Type Engine :</label>
                                                <div class="col-sm-9">
                                                    <select name="engine_id" id="engines"
                                                        class="form-control form-control-sm select2" required
                                                        data-placeholder="Pilih Engine">
                                                        <option></option>
                                                        @foreach ($engines as $en)
                                                            <option value="{{ $en->id }}">{{ $en->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Merk :</label>
                                                <div class="col-sm-9">
                                                    <select name="brand_id_display" id="brands"
                                                        class="form-control form-control-sm select2" required disabled
                                                        data-placeholder="Pilih Merk">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Type Chassis :</label>
                                                <div class="col-sm-9">
                                                    <select name="chassis_id_display" id="chassiss"
                                                        class="form-control form-control-sm select2" required disabled
                                                        data-placeholder="Pilih Chassis">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Jenis Kendaraan :</label>
                                                <div class="col-sm-9">
                                                    <select name="vehicle_id_display" id="vehicles"
                                                        class="form-control form-control-sm select2" required disabled
                                                        data-placeholder="Pilih Jenis Kendaraan">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    {{-- Kategori Gambar --}}
                                    @php
                                        // Key (internal name) => ['color' (card-color class), 'display' (for label)]
                                        $kategori = [
                                            'utama' => ['color' => 'info', 'display' => 'Utama'],
                                            'terurai' => ['color' => 'info', 'display' => 'Terurai'],
                                            'kontruksi' => ['color' => 'info', 'display' => 'Konstruksi'],
                                            'detail' => ['color' => 'warning', 'display' => 'Detail'],
                                            'kelistrikan' => ['color' => 'danger', 'display' => 'Kelistrikan'],
                                        ];
                                    @endphp

                                    @foreach ($kategori as $type => $data)
                                        <div class="card card-outline card-{{ $data['color'] }} p-2 mb-3">
                                            {{-- Judul Kartu dihilangkan sesuai permintaan user --}}
                                            <h5 class="card-title"></h5>
                                            <div class="card-body p-0" id="gambar-{{ $type }}-container">
                                                @for ($i = 1; $i <= 4; $i++)
                                                    <div id="{{ $type }}-row-{{ $i }}"
                                                        class="gambar-rincian-row form-row align-items-center p-2"
                                                        style="display: none;">

                                                        <div class="col-md-2">
                                                            {{-- Label di dalam baris tetap ada untuk mengidentifikasi jenis gambar --}}
                                                            <label class="col-form-label-sm font-weight-bold p-0">
                                                                Gambar {{ $data['display'] }} {{ $i }}:
                                                            </label>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select
                                                                name="rincian[{{ $type }}][{{ $i }}][varian_id]"
                                                                class="form-control form-control-sm varian-select select2"
                                                                disabled required data-placeholder="Pilih Varian">
                                                                <option></option>
                                                                @foreach ($varians as $v)
                                                                    <option value="{{ $v->id }}">
                                                                        {{ $v->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <select
                                                                name="rincian[{{ $type }}][{{ $i }}][keterangan]"
                                                                class="form-control form-control-sm gambar-keterangan select2"
                                                                disabled required data-placeholder="Pilih Jenis Body">
                                                                <option></option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-1">
                                                            <input type="text"
                                                                name="rincian[{{ $type }}][{{ $i }}][halaman_gambar]"
                                                                class="form-control form-control-sm halaman-gambar-input"
                                                                required readonly>
                                                        </div>

                                                        <div class="col-md-1">
                                                            <input type="text"
                                                                name="rincian[{{ $type }}][{{ $i }}][total_halaman]"
                                                                class="form-control form-control-sm total-halaman-input"
                                                                required readonly>
                                                        </div>

                                                        <div class="col-md-2 text-right">
                                                            <input type="hidden"
                                                                name="rincian[{{ $type }}][{{ $i }}][jumlah_gambar]"
                                                                class="jumlah-gambar-hidden" value="">
                                                            <button type="button"
                                                                class="btn btn-info btn-sm preview-gambar-btn" disabled><i
                                                                    class="fa fa-image"></i> Preview Gambar</button>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success float-right">Ambil Gambar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    {{-- Modal Preview --}}
    <div class="modal fade" id="modalPreview">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0 text-center" id="imgPreviewModal">
                    {{-- Gambar akan diisi oleh JS --}}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function() {
            // --- Inisialisasi Select2 ---
            $('.select2-static').select2({
                width: '100%',
                minimumResultsForSearch: Infinity,
                allowClear: false
            });
            $('#customers, #submissions, #employees, #engines, #brands, #chassiss, #vehicles, .varian-select, .gambar-keterangan')
                .select2({
                    width: '100%',
                    allowClear: true
                });

            function pad(num, size = 2) {
                return String(num).padStart(size, '0');
            }
            const HANYA_TU_ID = '4';
            let isHanyaTU = false;

            function updatePageNumbers() {
                let jumlahGbrUtama = parseInt($('#jumlah_halaman').val()) || 0;
                let factor = isHanyaTU ? 1 : 3;
                const totalPages = jumlahGbrUtama * factor;
                $('#hidden_jumlah_gambar').val(totalPages);
                let currentPage = 1;
                const isVehicleSelected = $('#vehicles').val();

                for (let i = 1; i <= 4; i++) {
                    let rowUtama = $('#utama-row-' + i);
                    let varianSelectUtama = rowUtama.find('.varian-select');
                    let selectKeteranganUtama = rowUtama.find('.gambar-keterangan');

                    if (i <= jumlahGbrUtama) {
                        rowUtama.show();
                        rowUtama.find('.halaman-gambar-input').val(pad(currentPage++)).prop('readonly', true);
                        rowUtama.find('.total-halaman-input').val(pad(totalPages)).prop('readonly', true);
                        rowUtama.find('.jumlah-gambar-hidden').val(totalPages);
                        varianSelectUtama.prop('disabled', !isVehicleSelected);
                        selectKeteranganUtama.prop('disabled', !isVehicleSelected);
                        rowUtama.find('.preview-gambar-btn').prop('disabled', !selectKeteranganUtama.val());
                    } else {
                        rowUtama.hide();
                        rowUtama.find('input').val('');
                        varianSelectUtama.val(null).prop('disabled', true);
                        selectKeteranganUtama.val(null).prop('disabled', true);
                        rowUtama.find('.preview-gambar-btn').prop('disabled', true);
                    }

                    ['terurai', 'kontruksi'].forEach(type => {
                        let row = $('#' + type + '-row-' + i);
                        let varianSelect = row.find('.varian-select');
                        let selectKeterangan = row.find('.gambar-keterangan');
                        if (isHanyaTU || i > jumlahGbrUtama) {
                            row.hide();
                            row.find('input').val('');
                            varianSelect.val(null).prop('disabled', true);
                            selectKeterangan.val(null).prop('disabled', true);
                            row.find('.preview-gambar-btn').prop('disabled', true);
                            return;
                        }
                        row.show();
                        row.find('.halaman-gambar-input').val(pad(currentPage++)).prop('readonly', true);
                        row.find('.total-halaman-input').val(pad(totalPages)).prop('readonly', true);
                        row.find('.jumlah-gambar-hidden').val(totalPages);
                        varianSelect.val(varianSelectUtama.val()).prop('disabled', true);
                        selectKeterangan.val(selectKeteranganUtama.val()).prop('disabled', true);
                        row.find('.preview-gambar-btn').prop('disabled', !selectKeteranganUtama.val());
                    });
                }
            }

            $('#submissions').change(function() {
                isHanyaTU = $(this).val() === HANYA_TU_ID;
                updatePageNumbers();
            });

            updatePageNumbers();
            $('#jumlah_halaman').on('change', updatePageNumbers);

            // Reset cascading dropdown
            function resetDropdowns(start) {
                if (start <= 1) {
                    $('#brands').html('<option></option>').prop('disabled', true);
                    $('#hidden_brand_id').val('');
                }
                if (start <= 2) {
                    $('#chassiss').html('<option></option>').prop('disabled', true);
                    $('#hidden_chassis_id').val('');
                }
                if (start <= 3) {
                    $('#vehicles').html('<option></option>').prop('disabled', true);
                    $('#hidden_vehicle_id').val('');
                    updatePageNumbers();
                }
            }

            $('#engines').change(function() {
                let id = $(this).val();
                resetDropdowns(1);
                if (!id) return;
                $.get("{{ route('get.brands') }}", {
                    engine_id: id
                }, function(data) {
                    let html = '<option></option>';
                    data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                    $('#brands').html(html).prop('disabled', false);
                });
            });

            $('#brands').change(function() {
                let id = $(this).val();
                $('#hidden_brand_id').val(id);
                resetDropdowns(2);
                if (!id) return;
                $.get("{{ route('get.chassiss') }}", {
                    brand_id: id
                }, function(data) {
                    let html = '<option></option>';
                    data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                    $('#chassiss').html(html).prop('disabled', false);
                });
            });

            $('#chassiss').change(function() {
                let id = $(this).val();
                $('#hidden_chassis_id').val(id);
                resetDropdowns(3);
                if (!id) return;
                $.get("{{ route('get.vehicles') }}", {
                    chassis_id: id
                }, function(data) {
                    let html = '<option></option>';
                    data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                    $('#vehicles').html(html).prop('disabled', false);
                });
            });

            // Update varian_body / keterangan saat vehicle dipilih
            $('#vehicles').change(function() {
                let id = $(this).val();
                $('#hidden_vehicle_id').val(id);
                updatePageNumbers();
                $('.gambar-rincian-row').find('.gambar-keterangan').html('<option></option>').val(null)
                    .trigger('change');
                if (!id) return;
                $.get("{{ route('get.keterangans') }}", {
                    mdata_id: id
                }, function(data) {
                    let html = '<option></option>';
                    data.forEach(d => {
                        let fotoData = {
                            utama: d.foto_utama,
                            terurai: d.foto_terurai,
                            kontruksi: d.foto_kontruksi
                        };
                        html +=
                            `<option value="${d.id}" data-foto='${JSON.stringify(fotoData)}'>${d.varian_body}</option>`;
                    });
                    $('.gambar-rincian-row').find('.gambar-keterangan').each(function() {
                        $(this).html(html);
                    });
                });
            });

            // Sinkronisasi varian-select ke terurai & kontruksi
            $(document).on('change', '.gambar-rincian-row[id^="utama-row-"] .varian-select', function() {
                if (isHanyaTU) return;
                let rowNum = $(this).closest('.gambar-rincian-row').attr('id').split('-')[2];
                $('#terurai-row-' + rowNum).find('.varian-select').val($(this).val());
                $('#kontruksi-row-' + rowNum).find('.varian-select').val($(this).val());
            });

            // Update tombol preview
            $(document).on('change', '.gambar-rincian-row[id^="utama-row-"] .gambar-keterangan', function() {
                let row = $(this).closest('.gambar-rincian-row');
                row.find('.preview-gambar-btn').prop('disabled', !$(this).val());
                if (!isHanyaTU) updatePageNumbers();
            });

            // Preview gambar modal
            $(document).on('click', '.preview-gambar-btn', function() {
                let row = $(this).closest('.gambar-rincian-row');
                let selectedOption = row.find('.gambar-keterangan option:selected');
                let fotoData = selectedOption.data('foto');
                let fotoHtml = '';
                if (fotoData) {
                    for (const key in fotoData) {
                        if (fotoData[key]) {
                            fotoHtml +=
                                `<img src="/storage/${fotoData[key]}" class="img-fluid mb-2" style="max-height:300px;">`;
                        }
                    }
                }
                if (fotoHtml) {
                    $('#imgPreviewModal').html(fotoHtml);
                    $('#modalPreview').modal('show');
                } else {
                    toastr.warning("Tidak ada gambar yang tersedia untuk Jenis Body ini.");
                }
            });

        });
    </script>
@endpush
