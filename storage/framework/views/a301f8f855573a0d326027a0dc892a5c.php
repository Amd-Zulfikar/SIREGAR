<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <a href="<?php echo e(route('index.workspace')); ?>" class="btn btn-outline-primary">
                    <i class="fa-solid fa-circle-left"></i> Kembali
                </a>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form id="form-workspace" method="POST" action="<?php echo e(route('store.workspace')); ?>">
                    <?php echo csrf_field(); ?>
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
                                                <label class="col-sm-3 col-form-label-sm">Jumlah Gbr Tu :</label>
                                                <div class="col-sm-9">
                                                    <select name="jumlah_halaman" id="jumlah_halaman"
                                                        class="form-control form-control-sm select2-static" required
                                                        data-placeholder="Pilih Jumlah">
                                                        <option value="" selected disabled></option>
                                                        <?php for($i = 1; $i <= 4; $i++): ?>
                                                            <option value="<?php echo e($i); ?>">
                                                                <?php echo e($i); ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Customer :</label>
                                                <div class="col-sm-9">
                                                    <select name="customer_id" id="customers"
                                                        class="form-control form-control-sm select2" required
                                                        data-placeholder="Pilih Customer">
                                                        <option value="" selected disabled></option>
                                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Jenis Pengajuan :</label>
                                                <div class="col-sm-9">
                                                    <select name="submission_id" id="submissions"
                                                        class="form-control form-control-sm select2" required
                                                        data-placeholder="Pilih Jenis Pengajuan">
                                                        <option value="" selected disabled></option>
                                                        <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Diperiksa :</label>
                                                <div class="col-sm-9">
                                                    <select name="checked_by" id="people"
                                                        class="form-control form-control-sm select2" required
                                                        data-placeholder="Pilih Karyawan atau Customer">

                                                        <option value="" selected disabled></option>

                                                        <?php $__currentLoopData = $people; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($p['id']); ?>">


                                                                [<?php echo e($p['type']); ?>] <?php echo e($p['name']); ?>



                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                                                        data-placeholder="Pilih Type Engine">
                                                        <option value="" selected disabled></option>
                                                        <?php $__currentLoopData = $engines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $en): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($en->id); ?>"><?php echo e($en->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Merk :</label>
                                                <div class="col-sm-9">
                                                    <select name="brand_id_display" id="brands"
                                                        class="form-control form-control-sm select2" required disabled
                                                        data-placeholder="Pilih Merk">
                                                        <option value="" selected disabled></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Type Chassis :</label>
                                                <div class="col-sm-9">
                                                    <select name="chassis_id_display" id="chassiss"
                                                        class="form-control form-control-sm select2" required disabled
                                                        data-placeholder="Pilih Type Chassis">
                                                        <option value="" selected disabled></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Jenis Kendaraan :</label>
                                                <div class="col-sm-9">
                                                    <select name="vehicle_id_display" id="vehicles"
                                                        class="form-control form-control-sm select2" required disabled
                                                        data-placeholder="Pilih Jenis Kendaraan">
                                                        <option value="" selected disabled></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    
                                    <?php
                                        $kategori = [
                                            'utama' => ['color' => 'info', 'display' => 'Utama'],
                                            'terurai' => ['color' => 'info', 'display' => 'Terurai'],
                                            'kontruksi' => ['color' => 'info', 'display' => 'Konstruksi'],
                                            'detail' => ['color' => 'warning', 'display' => 'Detail'],
                                            'kelistrikan' => ['color' => 'danger', 'display' => 'Kelistrikan'],
                                        ];
                                    ?>

                                    <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card card-outline card-<?php echo e($data['color']); ?> p-2 mb-3">
                                            <div class="card-body p-0" id="gambar-<?php echo e($type); ?>-container">
                                                <?php for($i = 1; $i <= 4; $i++): ?>
                                                    <div id="<?php echo e($type); ?>-row-<?php echo e($i); ?>"
                                                        class="gambar-rincian-row form-row align-items-center p-2"
                                                        style="display:none;">
                                                        <div class="col-md-2">
                                                            <label class="col-form-label-sm font-weight-bold p-0">Gambar
                                                                <?php echo e($data['display']); ?> <?php echo e($i); ?>:</label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select
                                                                name="rincian[<?php echo e($type); ?>][<?php echo e($i); ?>][varian_id]"
                                                                class="form-control form-control-sm varian-select select2"
                                                                disabled required data-placeholder="Pilih Varian">
                                                                <option value="" selected disabled></option>
                                                                <?php $__currentLoopData = $varians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($v->id); ?>">
                                                                        <?php echo e($v->name_utama); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select
                                                                name="rincian[<?php echo e($type); ?>][<?php echo e($i); ?>][keterangan]"
                                                                class="form-control form-control-sm gambar-keterangan select2"
                                                                disabled required data-placeholder="Pilih Keterangan">
                                                                <option value="" selected disabled></option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="text"
                                                                name="rincian[<?php echo e($type); ?>][<?php echo e($i); ?>][halaman_gambar]"
                                                                class="form-control form-control-sm halaman-gambar-input"
                                                                readonly>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="text"
                                                                name="rincian[<?php echo e($type); ?>][<?php echo e($i); ?>][total_halaman]"
                                                                class="form-control form-control-sm total-halaman-input"
                                                                readonly>
                                                        </div>
                                                        <div class="col-md-2 text-right">
                                                            <input type="hidden"
                                                                name="rincian[<?php echo e($type); ?>][<?php echo e($i); ?>][jumlah_gambar]"
                                                                class="jumlah-gambar-hidden" value="">
                                                            
                                                            <button type="button"
                                                                class="btn btn-info btn-sm preview-gambar-btn" disabled><i
                                                                    class="fa fa-image"></i> Preview</button>
                                                        </div>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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

    
    <div class="modal fade" id="modalPreview">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0 text-center" id="imgPreviewModal"></div>
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
            // --- Fungsi pad number ---
            function pad(num, size = 2) {
                return String(num).padStart(size, '0');
            }

            const HANYA_TU_ID = '4';
            let isHanyaTU = false;

            // --- Inisialisasi Select2 ---
            function initSelect2(selector) {
                $(selector).select2({
                    width: '100%',
                    placeholder: function() {
                        return $(this).data('placeholder');
                    },
                    allowClear: true
                });
            }

            initSelect2(
                '#customers, #submissions, #people, #engines, #brands, #chassiss, #vehicles, .varian-select, .gambar-keterangan'
            );
            initSelect2('.select2-static');

            // --- Reset Cascading Dropdowns ---
            function resetDropdowns(start) {
                if (start <= 0) $('#people').val(null).trigger('change.select2');
                if (start <= 1) {
                    $('#brands').val(null).html('<option value="" selected disabled>Pilih Merk</option>').prop(
                        'disabled', true).trigger('change.select2');
                    $('#hidden_brand_id').val('');
                }
                if (start <= 2) {
                    $('#chassiss').val(null).html('<option value="" selected disabled>Pilih Type Chassis</option>')
                        .prop('disabled', true).trigger('change.select2');
                    $('#hidden_chassis_id').val('');
                }
                if (start <= 3) {
                    $('#vehicles').val(null).html(
                        '<option value="" selected disabled>Pilih Jenis Kendaraan</option>').prop('disabled',
                        true).trigger('change.select2');
                    $('#hidden_vehicle_id').val('');
                    $('.gambar-rincian-row .gambar-keterangan').val(null).trigger('change');
                    updatePageNumbers();
                }
            }

            resetDropdowns(0);

            // --- Update Nomor Halaman ---
            function updatePageNumbers() {
                let jumlahGbrUtama = parseInt($('#jumlah_halaman').val()) || 0;
                let factor = isHanyaTU ? 1 : 3;
                const totalPages = jumlahGbrUtama * factor;
                $('#hidden_jumlah_gambar').val(totalPages);
                let currentPage = 1;
                const isVehicleSelected = $('#vehicles').val();

                const allCategories = ['utama', 'terurai', 'kontruksi', 'detail', 'kelistrikan'];

                // Reset semua baris
                allCategories.forEach(type => {
                    for (let i = 1; i <= 4; i++) {
                        let row = $('#' + type + '-row-' + i);
                        row.hide();
                        row.find('input').val('');
                        row.find('.varian-select').val(null).trigger('change.select2').prop('disabled',
                            type !== 'utama');
                        row.find('.gambar-keterangan').val(null).trigger('change.select2').prop('disabled',
                            type !== 'utama');
                        row.find('.preview-gambar-btn').prop('disabled', true);
                    }
                });

                // 1. Baris Utama
                for (let i = 1; i <= jumlahGbrUtama; i++) {
                    let rowUtama = $('#utama-row-' + i);
                    let varianSelectUtama = rowUtama.find('.varian-select');
                    let selectKeteranganUtama = rowUtama.find('.gambar-keterangan');
                    let keteranganVal = selectKeteranganUtama.val();

                    rowUtama.show();
                    rowUtama.find('.halaman-gambar-input').val(pad(currentPage++)).prop('readonly', true);
                    rowUtama.find('.total-halaman-input').val(pad(totalPages)).prop('readonly', true);
                    rowUtama.find('.jumlah-gambar-hidden').val(totalPages);
                    varianSelectUtama.prop('disabled', !isVehicleSelected);
                    selectKeteranganUtama.prop('disabled', !isVehicleSelected);
                    rowUtama.find('.preview-gambar-btn').prop('disabled', !keteranganVal);
                }

                // 2. Baris Terurai & Konstruksi (selalu disabled)
                ['terurai', 'kontruksi'].forEach(type => {
                    for (let i = 1; i <= jumlahGbrUtama; i++) {
                        let row = $('#' + type + '-row-' + i);
                        let rowUtama = $('#utama-row-' + i);

                        let varianSelect = row.find('.varian-select');
                        let selectKeterangan = row.find('.gambar-keterangan');
                        let selectedVarian = rowUtama.find('.varian-select').val();
                        let keteranganVal = rowUtama.find('.gambar-keterangan').val();

                        row.show();
                        row.find('.halaman-gambar-input').val(pad(currentPage++)).prop('readonly', true);
                        row.find('.total-halaman-input').val(pad(totalPages)).prop('readonly', true);
                        row.find('.jumlah-gambar-hidden').val(totalPages);

                        varianSelect.val(selectedVarian).trigger('change.select2').prop('disabled', true);
                        selectKeterangan.val(keteranganVal).trigger('change.select2').prop('disabled',
                            true);
                        row.find('.preview-gambar-btn').prop('disabled', !keteranganVal);
                    }
                });
            }

            updatePageNumbers();

            // --- Listener Submissions & Jumlah Halaman ---
            $('#submissions').change(function() {
                isHanyaTU = $(this).val() === HANYA_TU_ID;
                $('.gambar-rincian-row .gambar-keterangan').val(null).trigger('change');
                updatePageNumbers();
            });

            $('#jumlah_halaman').on('change', function() {
                $('.gambar-rincian-row .gambar-keterangan').val(null).trigger('change');
                updatePageNumbers();
            });

            // --- Listener Engines ---
            $('#engines').change(function() {
                let id = $(this).val();
                $('#people').val(null).trigger('change.select2');
                resetDropdowns(1);

                if (!id) return;
                $.get("<?php echo e(route('get.brands')); ?>", {
                        engine_id: id
                    })
                    .done(function(data) {
                        let html = '<option value="" selected disabled>Pilih Merk</option>';
                        data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                        $('#brands').html(html).prop('disabled', false).trigger('change.select2');
                    });
            });

            $('#brands').change(function() {
                let id = $(this).val();
                $('#hidden_brand_id').val(id);
                resetDropdowns(2);
                if (!id) return;
                $.get("<?php echo e(route('get.chassiss')); ?>", {
                        brand_id: id
                    })
                    .done(function(data) {
                        let html = '<option value="" selected disabled>Pilih Type Chassis</option>';
                        data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                        $('#chassiss').html(html).prop('disabled', false).trigger('change.select2');
                    });
            });

            $('#chassiss').change(function() {
                let id = $(this).val();
                $('#hidden_chassis_id').val(id);
                resetDropdowns(3);
                if (!id) return;
                $.get("<?php echo e(route('get.vehicles')); ?>", {
                        chassis_id: id
                    })
                    .done(function(data) {
                        let html = '<option value="" selected disabled>Pilih Jenis Kendaraan</option>';
                        data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                        $('#vehicles').html(html).prop('disabled', false).trigger('change.select2');
                    });
            });

            $('#vehicles').change(function() {
                let id = $(this).val();
                $('#hidden_vehicle_id').val(id);
                updatePageNumbers();
                $('.gambar-rincian-row .gambar-keterangan').val(null).trigger('change');

                if (!id) return;
                $.get("<?php echo e(route('get.keterangans')); ?>", {
                        mdata_id: id
                    })
                    .done(function(data) {
                        let html = '<option value="" selected disabled>Pilih Keterangan</option>';
                        if (Array.isArray(data) && data.length) {
                            data.forEach(d => {
                                const fotoData = {
                                    utama: d.foto_utama || null,
                                    terurai: d.foto_terurai || null,
                                    kontruksi: d.foto_kontruksi || null,
                                    detail: d.foto_optional || null
                                };
                                html +=
                                    `<option value="${d.id}" data-foto='${JSON.stringify(fotoData)}'>${d.keterangan}</option>`;
                            });
                        } else {
                            html += `<option value="" disabled>Tidak ada data keterangan</option>`;
                        }
                        $('.gambar-rincian-row .gambar-keterangan').html(html).prop('disabled', true)
                            .trigger('change.select2');
                    });
            });

            // --- Listener Preview ---
            $(document).on('click', '.preview-gambar-btn', function() {
                if ($(this).is(':disabled')) return;

                let row = $(this).closest('.gambar-rincian-row');
                let selectedOption = row.find('.gambar-keterangan option:selected');
                if (!selectedOption.length || !selectedOption.val()) {
                    toastr.warning("Silakan pilih Keterangan Gambar terlebih dahulu.");
                    return;
                }

                let fotoData = selectedOption.data('foto') || {};
                let jenisGambar = row.attr('id').split('-')[0];
                if (!fotoData[jenisGambar]) {
                    toastr.warning("Tidak ada gambar untuk jenis body ini pada keterangan yang dipilih.");
                    return;
                }

                let fotoHtml = `<div class="mb-2 text-center">
                            <img src="/storage/body/${fotoData[jenisGambar]}" class="img-fluid border rounded">
                        </div>`;
                $('#imgPreviewModal').html(fotoHtml);
                $('#modalPreview').modal('show');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('drafter.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\02. ZULFIKAR\CODING\REKAYASA\SIREGAR\resources\views\drafter\workspace\add_workspace.blade.php ENDPATH**/ ?>