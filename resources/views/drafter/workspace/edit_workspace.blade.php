@extends('drafter.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <a href="{{ route('index.workspace') }}" class="btn btn-outline-primary">KEMBALI</a>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form id="form-edit-workspace" method="POST" action="{{ route('update.workspace', $workspace->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Workspace</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Kolom 1 -->
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label>Jenis Pengajuan</label>
                                                <select id="submissions" class="form-control select2">
                                                    <option value="" disabled selected>Pilih Jenis Pengajuan</option>
                                                    @foreach ($submissions as $s)
                                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Drafter</label>
                                                <select id="employees" class="form-control select2">
                                                    <option value="" disabled selected>Pilih Drafter</option>
                                                    @foreach ($employees as $e)
                                                        <option value="{{ $e->id }}">{{ $e->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Perusahaan</label>
                                                <select id="customers" class="form-control select2">
                                                    <option value="" disabled selected>Pilih Perusahaan</option>
                                                    @foreach ($customers as $c)
                                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>No. Halaman</label>
                                                <input id="halaman_gambar" type="text" class="form-control"
                                                    placeholder="Masukan No.Halaman">
                                            </div>

                                            <div class="form-group">
                                                <label>Jumlah Gambar</label>
                                                <input id="jumlah_gambar" type="text" class="form-control"
                                                    placeholder="Masukan Jumlah Gambar">
                                            </div>
                                        </div>

                                        <!-- Kolom 2 -->
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label>Engine</label>
                                                <select id="engines" class="form-control select2">
                                                    <option value="" disabled selected>Pilih Engine</option>
                                                    @foreach ($engines as $en)
                                                        <option value="{{ $en->id }}">{{ $en->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Brand</label>
                                                <select id="brands" class="form-control select2">
                                                    <option value="" disabled selected>Pilih Brand</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Chassis</label>
                                                <select id="chassiss" class="form-control select2">
                                                    <option value="" disabled selected>Pilih Chassis</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Vehicle</label>
                                                <select id="vehicles" class="form-control select2">
                                                    <option value="" disabled selected>Pilih Vehicle</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <select id="keterangans" class="form-control select2">
                                                    <option value="" disabled selected>Pilih Keterangan</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Kolom 3 -->
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label>Varian</label>
                                                <select id="varians" class="form-control select2">
                                                    <option value="" disabled selected>Pilih Varian</option>
                                                    @foreach ($varians as $v)
                                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Preview Foto (klik thumbnail untuk preview)</label>
                                                <div class="preview_form_1 border p-2" style="min-height:240px;"></div>
                                            </div>

                                            <button type="button" id="btn-tambah-rincian"
                                                class="btn btn-outline-primary">Tambah Data
                                            </button>
                                            <button type="button" id="btn-update-rincian"
                                                class="btn btn-outline-warning">Update
                                                Rincian
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rincian Data -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Rincian Data</h3>
                                </div>
                                <div class="card-body">
                                    <table id="tbl-detail" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Pilih</th>
                                                <th>No Halaman</th>
                                                <th>Jumlah Gambar</th>
                                                <th>Engine</th>
                                                <th>Brand</th>
                                                <th>Chassis</th>
                                                <th>Vehicle</th>
                                                <th>Keterangan</th>
                                                <th>Varian</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <br>
                                    <button type="button" id="btn-update-ws" class="btn btn-success float-right">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <!-- Modal Preview -->
    <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 text-center">
                    <img src="" id="imgPreviewModal" class="img-fluid" alt="Preview">
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
            $('.select2').select2({
                width: '100%'
            });

            let rincianData = @json($rincianJs ?? []);
            let jumlahGambarWorkspace = {{ $workspace->jumlah_gambar ?? 0 }};

            // Render tabel rincian
            function renderTable() {
                const tbody = $('#tbl-detail tbody');
                tbody.empty();

                if (!Array.isArray(rincianData) || rincianData.length === 0) {
                    tbody.append('<tr><td colspan="10" class="text-center">Belum ada rincian data</td></tr>');
                    return;
                }

                rincianData.forEach((r, idx) => {
                    const fotos = Array.isArray(r.fotoBody) ? r.fotoBody : [];
                    const thumbs = fotos.map(f => {
                        const src = '/storage/body/' + f;
                        return `<img src="${src}" data-preview="${src}" class="img-thumbnail mb-1" style="width:50px;height:50px;cursor:pointer;" />`;
                    }).join('');

                    tbody.append(`
                    <tr data-index="${idx}">
                        <td><input type="checkbox" class="select-rincian"></td>
                        <td>${r.halaman_gambar || '-'}</td>
                        <td>${r.jumlah_gambar !== undefined && r.jumlah_gambar !== null ? String(r.jumlah_gambar).padStart(2, '0') : '-'}</td>
                        <td>${r.engineText || '-'}</td>
                        <td>${r.brandText || '-'}</td>
                        <td>${r.chassisText || '-'}</td>
                        <td>${r.vehicleText || '-'}</td>
                        <td>${r.keteranganText || '-'}</td>
                        <td>${r.varianText || '-'}</td>
                        <td>${thumbs}</td>
                        <td><button class="btn btn-danger btn-sm btn-hapus-rincian">Hapus</button></td>
                    </tr>
                `);
                });
            }

            // Modal Preview Gambar
            $(document).on('click', '#tbl-detail img[data-preview], .preview_form_1 img[data-preview]', function(
                e) {
                e.preventDefault();
                const src = $(this).data('preview') || $(this).attr('src');
                if (!src) return;
                $('#imgPreviewModal').attr('src', src);
                $('#modalPreview').modal('show');
            });

            $('#modalPreview').on('hidden.bs.modal', function() {
                $('#imgPreviewModal').attr('src', '');
                if (document.activeElement) document.activeElement.blur();
            });

            // Reset form rincian
            function resetForm() {
                $('#halaman_gambar,#jumlah_gambar').val('');
                $('#engines,#brands,#chassiss,#vehicles,#keterangans,#varians').val(null).trigger('change');
                $('#submissions,#employees,#customers').val(null).trigger('change');
                $('.preview_form_1').empty();
                $('#imgPreviewModal').attr('src', '');
            }

            // Populate dropdown helper
            function populateDropdown(id, data, placeholder, selected = null) {
                let html = `<option value="" disabled selected>${placeholder}</option>`;
                data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                $(id).html(html);
                if (selected) $(id).val(selected).trigger('change');
            }

            // Cascade dropdown otomatis untuk edit (populate dari data)
            async function populateCascading(r) {
                if (!r || !r.engine) {
                    $('#brands,#chassiss,#vehicles,#keterangans').val(null).trigger('change');
                    $('.preview_form_1').empty();
                    return;
                }

                $('#engines').val(r.engine).trigger('change');

                await $.get("{{ route('get.brands') }}", {
                        engine_id: r.engine
                    })
                    .done(res => populateDropdown('#brands', res, 'Pilih Brand', r.brand));

                await $.get("{{ route('get.chassiss') }}", {
                        brand_id: r.brand
                    })
                    .done(res => populateDropdown('#chassiss', res, 'Pilih Chassis', r.chassis));

                await $.get("{{ route('get.vehicles') }}", {
                        chassis_id: r.chassis
                    })
                    .done(res => populateDropdown('#vehicles', res, 'Pilih Vehicle', r.vehicle));

                await $.get("{{ route('get.keterangans') }}", {
                        vehicle_id: r.vehicle
                    })
                    .done(res => {
                        let html = `<option value="" disabled selected>Pilih Keterangan</option>`;
                        res.forEach(k => {
                            html +=
                                `<option value="${k.id}" data-foto='${JSON.stringify(k.foto_body)}'>${k.keterangan}</option>`;
                        });
                        $('#keterangans').html(html).val(r.keterangan).trigger('change');

                        const preview = $('.preview_form_1').empty();
                        (r.fotoBody || []).forEach(f => {
                            const src = '/storage/body/' + f;
                            preview.append(
                                `<img src="${src}" data-preview="${src}" class="img-thumbnail m-1 img-fluid" style="cursor:pointer;">`
                            );
                        });
                    });
            }

            // Event handler cascade dropdown tambah/update rincian
            $('#engines').on('change', function() {
                let engine_id = $(this).val();
                if (!engine_id) return;
                $.get("{{ route('get.brands') }}", {
                        engine_id
                    })
                    .done(res => populateDropdown('#brands', res, 'Pilih Brand'));
            });

            $('#brands').on('change', function() {
                let brand_id = $(this).val();
                if (!brand_id) return;
                $.get("{{ route('get.chassiss') }}", {
                        brand_id
                    })
                    .done(res => populateDropdown('#chassiss', res, 'Pilih Chassis'));
            });

            $('#chassiss').on('change', function() {
                let chassis_id = $(this).val();
                if (!chassis_id) return;
                $.get("{{ route('get.vehicles') }}", {
                        chassis_id
                    })
                    .done(res => populateDropdown('#vehicles', res, 'Pilih Vehicle'));
            });

            $('#vehicles').on('change', function() {
                let vehicle_id = $(this).val();
                if (!vehicle_id) return;
                $.get("{{ route('get.keterangans') }}", {
                        vehicle_id
                    })
                    .done(res => {
                        let html = `<option value="" disabled selected>Pilih Keterangan</option>`;
                        res.forEach(k => {
                            html +=
                                `<option value="${k.id}" data-foto='${JSON.stringify(k.foto_body)}'>${k.keterangan}</option>`;
                        });
                        $('#keterangans').html(html);
                    });
            });

            $('#keterangans').on('change', function() {
                const fotos = $('#keterangans option:selected').data('foto') || [];
                const preview = $('.preview_form_1').empty();
                fotos.forEach(f => {
                    const src = '/storage/body/' + f;
                    preview.append(
                        `<img src="${src}" data-preview="${src}" class="img-thumbnail m-1 img-fluid" style="cursor:pointer;">`
                    );
                });
            });

            // Checkbox pilih rincian
            $(document).on('change', '.select-rincian', async function() {
                $('#tbl-detail .select-rincian').not(this).prop('checked', false);
                const idx = $(this).closest('tr').data('index');
                if (this.checked && typeof idx !== 'undefined') {
                    const r = rincianData[idx];

                    $('#halaman_gambar').val(r.halaman_gambar || '');
                    let jml = r.jumlah_gambar !== undefined && r.jumlah_gambar !== null ?
                        String(r.jumlah_gambar).padStart(2, '0') :
                        '';
                    $('#jumlah_gambar').val(jml);
                    $('#submissions').val(r.submission_id || '').trigger('change');
                    $('#employees').val(r.employee_id || '').trigger('change');
                    $('#customers').val(r.customer_id || '').trigger('change');
                    $('#varians').val(r.varian_id || '').trigger('change');

                    await populateCascading(r);
                } else {
                    resetForm();
                }
            });

            // Tambah rincian baru
            $('#btn-tambah-rincian').click(function() {
                let engine = $('#engines').val(),
                    brand = $('#brands').val(),
                    chassis = $('#chassiss').val(),
                    vehicle = $('#vehicles').val(),
                    keterangan = $('#keterangans').val(),
                    halaman_gambar = $('#halaman_gambar').val(),
                    jumlah_gambar = $('#jumlah_gambar').val();

                if (!engine || !brand || !chassis || !vehicle || !keterangan) {
                    alert("Lengkapi semua data rincian!");
                    return;
                }

                rincianData.push({
                    engine,
                    engineText: $('#engines option:selected').text(),
                    brand,
                    brandText: $('#brands option:selected').text(),
                    chassis,
                    chassisText: $('#chassiss option:selected').text(),
                    vehicle,
                    vehicleText: $('#vehicles option:selected').text(),
                    keterangan,
                    keteranganText: $('#keterangans option:selected').text(),
                    halaman_gambar,
                    jumlah_gambar: parseInt(jumlah_gambar) || 0, // pastikan integer
                    fotoBody: $('#keterangans option:selected').data('foto') || [],
                    submission_id: $('#submissions').val(),
                    employee_id: $('#employees').val(),
                    customer_id: $('#customers').val(),
                    varian_id: $('#varians').val(),
                    varianText: $('#varians option:selected').text() || '-',
                });

                renderTable();
                resetForm();
            });

            // Update rincian
            $('#btn-update-rincian').click(function() {
                const idx = $('#tbl-detail .select-rincian:checked').closest('tr').data('index');
                if (typeof idx === 'undefined') {
                    alert("Pilih rincian yang mau diupdate dulu!");
                    return;
                }

                rincianData[idx] = {
                    engine: $('#engines').val(),
                    engineText: $('#engines option:selected').text(),
                    brand: $('#brands').val(),
                    brandText: $('#brands option:selected').text(),
                    chassis: $('#chassiss').val(),
                    chassisText: $('#chassiss option:selected').text(),
                    vehicle: $('#vehicles').val(),
                    vehicleText: $('#vehicles option:selected').text(),
                    keterangan: $('#keterangans').val(),
                    keteranganText: $('#keterangans option:selected').text(),
                    halaman_gambar: $('#halaman_gambar').val(),
                    jumlah_gambar: parseInt($('#jumlah_gambar').val()) || 0, // pastikan integer
                    fotoBody: $('#keterangans option:selected').data('foto') || [],
                    submission_id: $('#submissions').val(),
                    employee_id: $('#employees').val(),
                    customer_id: $('#customers').val(),
                    varian_id: $('#varians').val(),
                    varianText: $('#varians option:selected').text() || '-',
                };

                renderTable();
                resetForm();
            });

            // Hapus rincian
            $(document).on('click', '.btn-hapus-rincian', function() {
                const idx = $(this).closest('tr').data('index');
                if (typeof idx !== 'undefined') {
                    rincianData.splice(idx, 1);
                    renderTable();
                    resetForm();
                }
            });

            // Submit update workspace
            $('#btn-update-ws').click(function() {
                const payload = {
                    employee_id: $('#employees').val(),
                    customer_id: $('#customers').val(),
                    submission_id: $('#submissions').val(),
                    varian_id: $('#varians').val(),
                    rincian: rincianData,
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    url: "{{ route('update.workspace', $workspace->id) }}",
                    type: "PUT",
                    data: payload,
                    success: function(res) {
                        if (!res.error) {
                            alert(res.message);
                            window.location.href = "{{ route('index.workspace') }}";
                        } else {
                            alert(res.message || 'Gagal update workspace');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert("Terjadi error saat update.");
                    }
                });
            });

            // Init
            renderTable();
            resetForm();
        });
    </script>
@endpush
