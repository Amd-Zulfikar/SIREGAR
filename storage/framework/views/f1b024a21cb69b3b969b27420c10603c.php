<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <a href="<?php echo e(route('index.workspace')); ?>" class="btn btn-outline-primary"><i
                        class="fa-solid fa-circle-left"></i> Kembali</a>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form id="form-workspace" method="POST" action="<?php echo e(route('store.workspace')); ?>">
                    <?php echo csrf_field(); ?>
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
                                                    <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Drafter</label>
                                                <select id="employees" class="form-control select2">
                                                    <option selected disabled>Pilih Drafter</option>
                                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($e->id); ?>"><?php echo e($e->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Perusahaan</label>
                                                <select id="customers" class="form-control select2">
                                                    <option selected disabled>Pilih Perusahaan</option>
                                                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="halaman_gambar">Halaman gambar</label>
                                                <input name="rincian[0][halaman_gambar]" id="halaman_gambar" type="text"
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
                                                    <?php $__currentLoopData = $engines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $en): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($en->id); ?>"><?php echo e($en->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                    <?php $__currentLoopData = $varians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Preview Foto</label>
                                                <div class="preview_form_1 border p-2" style="min-height:243px;"></div>
                                            </div>

                                            <button type="button" id="btn-tambah-rincian" class="btn btn-outline-primary">
                                                <i class="fa-solid fa-folder-plus"></i>
                                                Tambah Data
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
                                                <th>Jenis Body</th>
                                                <th>Varian</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <br>
                                    <button type="button" id="btn-simpan-ws" class="btn btn-success float-right">Ambil
                                        Gambar</button>

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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
                $.get("<?php echo e(route('get.brands')); ?>", {
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
                $.get("<?php echo e(route('get.chassiss')); ?>", {
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
                $.get("<?php echo e(route('get.vehicles')); ?>", {
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
                $.get("<?php echo e(route('get.keterangans')); ?>", {
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
                    alert("Lengkapi semua data!");
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
                    varian_id = $('#varians').val(),
                    jumlah_gambar = $('#jumlah_gambar').val();

                if (!employee_id || !customer_id || !submission_id || !varian_id || rincianData.length ==
                    0) {
                    alert("Lengkapi data & minimal 1 rincian!");
                    return;
                }

                $.ajax({
                    url: "<?php echo e(route('store.workspace')); ?>",
                    method: "POST",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        employee_id,
                        customer_id,
                        submission_id,
                        varian_id,
                        jumlah_gambar,
                        rincian: rincianData
                    },
                    success: function(res) {
                        if (!res.error) {
                            // Tampilkan toastr dulu
                            toastr.success(res.message);

                            // Redirect ke index workspace setelah 1 detik
                            setTimeout(function() {
                                window.location.href =
                                    "<?php echo e(route('index.workspace')); ?>";
                            }, 1000); // 1000ms = 1 detik delay supaya toastr kelihatan
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function(err) {
                        console.error(err);
                        toastr.error(
                            "Terjadi error saat menyimpan workspace. Cek log Laravel!");
                    }
                });
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('drafter.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CODING\REKAYASA\SIREGAR\resources\views\drafter\workspace\add_workspace.blade.php ENDPATH**/ ?>