@extends('drafter.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h4>Tambah Workspace</h4>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form id="form-workspace" method="POST" action="{{ route('store.workspace') }}">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Ambil Gambar</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Kolom 1 -->
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label>Jenis Pengajuan</label>
                                                <select id="submissions" class="form-control select2">
                                                    <option selected disabled>Pilih Jenis Pengajuan</option>
                                                    @foreach ($submissions as $s)
                                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Drafter</label>
                                                <select id="employees" class="form-control select2">
                                                    <option selected disabled>Pilih Drafter</option>
                                                    @foreach ($employees as $e)
                                                        <option value="{{ $e->id }}">{{ $e->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Perusahaan</label>
                                                <select id="customers" class="form-control select2">
                                                    <option selected disabled>Pilih Perusahaan</option>
                                                    @foreach ($customers as $c)
                                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="halaman_gambar">Halaman gambar</label>
                                                <input name="halaman_gambar" id="halaman_gambar" type="text"
                                                    class="form-control" placeholder="Masukan No.Halaman" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="jumlah_gambar">Jumlah gambar</label>
                                                <input name="jumlah_gambar" id="jumlah_gambar" type="text"
                                                    class="form-control" placeholder="Masukan Jumlah Gambar" required>
                                            </div>
                                        </div>

                                        <!-- Kolom 2 -->
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label>Engine</label>
                                                <select id="engines" class="form-control select2">
                                                    <option selected disabled>Pilih Engine</option>
                                                    @foreach ($engines as $en)
                                                        <option value="{{ $en->id }}">{{ $en->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Brand</label>
                                                <select id="brands" class="form-control select2">
                                                    <option selected disabled>Pilih Brand</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Chassis</label>
                                                <select id="chassiss" class="form-control select2">
                                                    <option selected disabled>Pilih Chassis</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Vehicle</label>
                                                <select id="vehicles" class="form-control select2">
                                                    <option selected disabled>Pilih Vehicle</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <select id="keterangans" class="form-control select2">
                                                    <option selected disabled>Pilih Keterangan</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Kolom 3 -->
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label>Varian</label>
                                                <select name="varian_id" id="varians" class="form-control select2">
                                                    <option selected disabled>Pilih Varian</option>
                                                    @foreach ($varians as $s)
                                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Preview Foto</label>
                                                <div class="preview_form_1 border p-2" style="min-height:230px;"></div>
                                            </div>

                                            <button type="button" id="btn-tambah-rincian" class="btn btn-primary mt-2">
                                                Tambah Rincian
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
                                    <button type="button" id="btn-simpan-ws" class="btn btn-success float-right">Simpan
                                        Workspace</button>
                                    <a href="{{ route('index.workspace') }}" class="btn btn-danger">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <!-- Modal Preview -->
    <div class="modal fade" id="modalPreview">
        <div class="modal-dialog modal-dialog-centered modal-lg">
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

            let rincianData = [];
            let counter = 1;

            // Multi-filter cascading
            $('#engines').change(function() {
                let id = $(this).val();
                $.get("{{ route('get.brands') }}", {
                    engine_id: id
                }, function(data) {
                    let html = '<option selected disabled>Pilih Brand</option>';
                    data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                    $('#brands').html(html);
                    $('#chassiss,#vehicles,#keterangans').html(
                        '<option selected disabled>Pilih</option>');
                });
            });

            $('#brands').change(function() {
                let id = $(this).val();
                $.get("{{ route('get.chassiss') }}", {
                    brand_id: id
                }, function(data) {
                    let html = '<option selected disabled>Pilih Chassis</option>';
                    data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                    $('#chassiss').html(html);
                    $('#vehicles,#keterangans').html('<option selected disabled>Pilih</option>');
                });
            });

            $('#chassiss').change(function() {
                let id = $(this).val();
                $.get("{{ route('get.vehicles') }}", {
                    chassis_id: id
                }, function(data) {
                    let html = '<option selected disabled>Pilih Vehicle</option>';
                    data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                    $('#vehicles').html(html);
                    $('#keterangans').html('<option selected disabled>Pilih</option>');
                });
            });

            $('#vehicles').change(function() {
                let id = $(this).val();
                $.get("{{ route('get.keterangans') }}", {
                    vehicle_id: id
                }, function(data) {
                    let html = '<option selected disabled>Pilih Keterangan</option>';
                    data.forEach(d => {
                        html +=
                            `<option value="${d.id}" data-foto='${JSON.stringify(d.foto_body)}'>${d.keterangan}</option>`;
                    });
                    $('#keterangans').html(html);
                });
            });

            // Preview gambar di form utama
            $('#keterangans').change(function() {
                let selected = $(this).find(':selected').data('foto');
                let preview = $('.preview_form_1');
                preview.empty();
                if (selected) {
                    let fotos = (typeof selected === "string") ? JSON.parse(selected) : selected;
                    fotos.forEach(f => {
                        let img = $(
                            `<img src="/storage/body/${f}" class="img-thumbnail m-1 img-fluid" style="cursor:pointer;">`
                        );
                        img.on('click', function() {
                            $('#imgPreviewModal').attr('src', '/storage/body/' + f);
                            let modal = new bootstrap.Modal(document.getElementById(
                                'modalPreview'));
                            modal.show();
                        });
                        preview.append(img);
                    });
                }
            });

            $('#btn-tambah-rincian').click(function() {
                let engine = $('#engines').val(),
                    brand = $('#brands').val(),
                    chassis = $('#chassiss').val(),
                    vehicle = $('#vehicles').val(),
                    keterangan = $('#keterangans').val(),
                    halaman_gambar = $('#halaman_gambar').val(),
                    jumlah_gambar = $('#jumlah_gambar').val(),
                    varian_id = $('#varians').val(),
                    varianText = $('#varians option:selected').text();

                let engineText = $('#engines option:selected').text(),
                    brandText = $('#brands option:selected').text(),
                    chassisText = $('#chassiss option:selected').text(),
                    vehicleText = $('#vehicles option:selected').text(),
                    keteranganText = $('#keterangans option:selected').text(),
                    fotoBody = $('#keterangans option:selected').data('foto');

                if (!engine || !brand || !chassis || !vehicle || !keterangan || !halaman_gambar || !
                    jumlah_gambar || !varian_id) {
                    alert("Lengkapi semua filter!");
                    return;
                }

                rincianData.push({
                    engine,
                    engineText,
                    brand,
                    brandText,
                    chassis,
                    chassisText,
                    vehicle,
                    vehicleText,
                    keterangan,
                    keteranganText,
                    halaman_gambar,
                    jumlah_gambar,
                    varian_id,
                    varianText,
                    fotoBody
                });

                let rowHtml = `<tr data-index="${rincianData.length - 1}">
                    <td>${halaman_gambar}</td>
                    <td>${jumlah_gambar}</td>
                    <td>${engineText}</td>
                    <td>${brandText}</td>
                    <td>${chassisText}</td>
                    <td>${vehicleText}</td>
                    <td>${keteranganText}</td>
                    
                    <td>${varianText}</td>
                    <td>${fotoBody.map(f => 
                        `<img src="/storage/body/${f}" class="img-thumbnail mb-1" style="width:50px;height:50px;cursor:pointer;" data-preview="${f}">`
                    ).join('')}</td>
                    <td><button class="btn btn-danger btn-sm btn-hapus-rincian">Hapus</button></td>
                </tr>`;

                $('#tbl-detail tbody').append(rowHtml);
                $('.preview_form_1').empty();
            });

            // Klik thumbnail di tabel rincian untuk preview modal
            $('#tbl-detail tbody').on('click', 'img[data-preview]', function() {
                let src = $(this).data('preview');
                $('#imgPreviewModal').attr('src', '/storage/body/' + src);
                let modal = new bootstrap.Modal(document.getElementById('modalPreview'));
                modal.show();
            });

            // Hapus rincian
            $(document).on('click', '.btn-hapus-rincian', function() {
                let tr = $(this).closest('tr'),
                    index = tr.data('index');
                rincianData.splice(index, 1);
                tr.remove();
                $('#tbl-detail tbody tr').each(function(i) {
                    $(this).attr('data-index', i);
                    $(this).find('td:first').text(i + 1);
                });
                counter = $('#tbl-detail tbody tr').length + 1;
            });

            // Simpan workspace
            $('#btn-simpan-ws').click(function() {
                let employee_id = $('#employees').val(),
                    customer_id = $('#customers').val(),
                    submission_id = $('#submissions').val(),
                    varian_id = $('#varians').val();

                if (!employee_id || !customer_id || !submission_id || !varian_id || rincianData.length ==
                    0) {
                    alert("Lengkapi data & minimal 1 rincian!");
                    return;
                }

                $.ajax({
                    url: "{{ route('store.workspace') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        employee_id,
                        customer_id,
                        submission_id,
                        varian_id,
                        rincian: rincianData
                    },
                    success: function(res) {
                        if (!res.error) {
                            alert(res.message);
                            rincianData = [];
                            counter = 1;
                            $('#tbl-detail tbody').empty();
                            $('#form-workspace')[0].reset();
                            $('.select2').val(null).trigger('change');
                        } else alert(res.message);
                    },
                    error: function(err) {
                        console.error(err);
                        alert("Terjadi error saat menyimpan workspace. Cek log Laravel!");
                    }
                });
            });
        });
    </script>
@endpush
