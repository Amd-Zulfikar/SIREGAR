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
                                                <label class="col-sm-3 col-form-label-sm">Jumlah Tu :</label>
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
                                                <label class="col-sm-3 col-form-label-sm">Pengajuan :</label>
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
                                                        data-placeholder="Pilih Pemeriksa">
                                                        <option value="" selected disabled></option>
                                                        <?php $__currentLoopData = $people; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($p['id']); ?>">[<?php echo e($p['type']); ?>]
                                                                <?php echo e($p['name']); ?></option>
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
                                            'optional' => ['color' => 'info', 'display' => 'Optional'],
                                            // 'kelistrikan' => ['color' => 'info', 'display' => 'Kelistrikan'],
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
                                                                    <option value="<?php echo e($v->id); ?>"
                                                                        data-utama="<?php echo e($v->name_utama); ?>"
                                                                        data-terurai="<?php echo e($v->name_terurai); ?>"
                                                                        data-kontruksi="<?php echo e($v->name_kontruksi); ?>">
                                                                        <?php echo e($v->name_utama); ?> 
                                                                    </option>
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
            // --- Inisialisasi Select2 (Tetap Sama) ---
            $('.select2-static').select2({
                width: '100%',
                minimumResultsForSearch: Infinity,
                allowClear: false
            });

            $('#customers, #submissions, #people, #engines, #brands, #chassiss, #vehicles, .varian-select, .gambar-keterangan')
                .select2({
                    width: '100%',
                    allowClear: true
                });

            function pad(num, size = 2) {
                return String(num).padStart(size, '0');
            }

            const HANYA_TU_ID = '4';
            let isHanyaTU = false;

            const ALL_TYPES = ['utama', 'terurai', 'kontruksi', 'optional'];

            function getTypeIndex(type) {
                return ALL_TYPES.indexOf(type);
            }

            // --- Fungsi untuk memperbarui teks Select2 secara paksa ---
            function updateSelect2Text(selectElement, newText) {
                // Select2 menggunakan elemen span untuk menampilkan teks
                // Cari elemen span Select2 yang sesuai dan perbarui teksnya
                selectElement.next('.select2-container').find('.select2-selection__rendered').text(newText);
            }


            // --- Update halaman gambar ---
            function updatePageNumbers() {
                let jumlahGbrUtama = parseInt($('#jumlah_halaman').val()) || 0;

                let factor = isHanyaTU ? 1 : ALL_TYPES.length;
                const totalPages = jumlahGbrUtama * factor;

                $('#hidden_jumlah_gambar').val(totalPages);

                const isVehicleSelected = $('#vehicles').val();

                for (let i = 1; i <= 4; i++) {
                    let rowUtama = $('#utama-row-' + i);
                    let varianSelectUtama = rowUtama.find('.varian-select');
                    let varianUtamaVal = varianSelectUtama.val();
                    let varianUtamaOption = varianSelectUtama.find('option:selected');

                    // Ambil semua nama varian dari pilihan Utama
                    let teruraiName = varianUtamaOption.data('terurai');
                    let kontruksiName = varianUtamaOption.data('kontruksi');
                    let utamaName = varianUtamaOption.data('utama') || varianUtamaOption
                        .text(); // Fallback ke teks asli

                    ALL_TYPES.forEach(type => {
                        let row = $('#' + type + '-row-' + i);
                        let varianSelect = row.find('.varian-select');
                        let selectKeterangan = row.find('.gambar-keterangan');
                        let previewBtn = row.find('.preview-gambar-btn');
                        const isPrimary = (type === 'utama');

                        const typeIndex = getTypeIndex(type);

                        const shouldShow = (i <= jumlahGbrUtama) && (isPrimary || !isHanyaTU);

                        if (shouldShow) {
                            row.show();
                            let pageNum = '';

                            // --- LOGIKA PENOMORAN (Tetap Sama) ---
                            if (isHanyaTU) {
                                pageNum = isPrimary ? i : '';
                            } else {
                                const basePageJump = typeIndex * 4;
                                pageNum = i + basePageJump;
                            }

                            // Terapkan penomoran
                            row.find('.halaman-gambar-input').val(pageNum ? pad(pageNum) : '').prop(
                                'readonly', true);
                            row.find('.total-halaman-input').val(pageNum ? pad(totalPages) : '').prop(
                                'readonly', true);
                            row.find('.jumlah-gambar-hidden').val(totalPages);

                            // --- LOGIKA VARIAN DAN DISABLED ---
                            if (isPrimary) {
                                // Utama: Enabled
                                varianSelect.prop('disabled', !isVehicleSelected);

                            } else {
                                // Non-Utama (Terurai, Kontruksi): Disabled
                                varianSelect.prop('disabled', true);

                                // 1. Sinkronkan value ID Varian
                                varianSelect.val(varianUtamaVal).trigger('change.select2');

                                // 2. Paksa Select2 menampilkan teks yang benar saat load
                                if (varianUtamaVal) {
                                    let newText = '';
                                    if (type === 'terurai') {
                                        newText = teruraiName || utamaName;
                                    } else if (type === 'kontruksi') {
                                        newText = kontruksiName || utamaName;
                                    }

                                    // PENTING: Perbarui teks secara paksa di elemen Select2
                                    if (newText) {
                                        // Cari opsi di dropdown ini dan pastikan teksnya benar sebelum ditampilkan
                                        let syncOption = varianSelect.find(
                                            `option[value="${varianUtamaVal}"]`);
                                        if (syncOption.length) {
                                            syncOption.text(newText);
                                        }
                                        updateSelect2Text(varianSelect, newText);
                                    }
                                }
                            }

                            // Keterangan: Hanya baris Utama yang enabled
                            let isKeteranganEnabled = isPrimary && isVehicleSelected;
                            selectKeterangan.prop('disabled', !isKeteranganEnabled);

                            // Sinkronisasi Keterangan (Tetap Sama)
                            let keteranganUtamaVal = rowUtama.find('.gambar-keterangan').val();
                            if (!isPrimary && keteranganUtamaVal) {
                                selectKeterangan.val(keteranganUtamaVal).trigger('change.select2');
                            }
                            previewBtn.prop('disabled', !selectKeterangan.val());

                        } else {
                            // Sembunyikan dan Reset
                            row.hide();
                            row.find('input').val('');
                            varianSelect.val(null).trigger('change.select2').prop('disabled', true);
                            selectKeterangan.val(null).trigger('change.select2').prop('disabled', true);
                            previewBtn.prop('disabled', true);
                        }
                    });

                    // Pastikan Detail & Kelistrikan tetap tersembunyi
                    $('#detail-row-' + i).hide();
                    $('#kelistrikan-row-' + i).hide();
                }
            }

            // --- Listener Submissions & Jumlah Halaman (Tetap Sama) ---
            $('#submissions').change(function() {
                isHanyaTU = $(this).val() === HANYA_TU_ID;
                updatePageNumbers();
            });

            updatePageNumbers();
            $('#jumlah_halaman').on('change', updatePageNumbers);

            // --- Reset cascading dropdown (Tetap Sama) ---
            function resetDropdowns(start) {
                if (start <= 1) {
                    $('#brands').html('<option></option>').val(null).trigger('change.select2').prop('disabled',
                        true);
                    $('#hidden_brand_id').val('');
                }
                if (start <= 2) {
                    $('#chassiss').html('<option></option>').val(null).trigger('change.select2').prop('disabled',
                        true);
                    $('#hidden_chassis_id').val('');
                }
                if (start <= 3) {
                    $('#vehicles').html('<option></option>').val(null).trigger('change.select2').prop('disabled',
                        true);
                    $('#hidden_vehicle_id').val('');
                    $('.gambar-rincian-row').find('.varian-select, .gambar-keterangan').prop('disabled', true).val(
                        null).trigger('change.select2');
                    $('.preview-gambar-btn').prop('disabled', true);
                    updatePageNumbers();
                }
            }

            // --- Handlers Cascading (Tetat Sama) ---
            $('#engines').change(function() {
                let id = $(this).val();
                resetDropdowns(1);
                if (!id) return;
                $.get("<?php echo e(route('get.brands')); ?>", {
                        engine_id: id
                    })
                    .done(function(data) {
                        let html = '<option></option>';
                        data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                        $('#brands').html(html).prop('disabled', false).trigger('change.select2');
                    })
                    .fail(function() {
                        toastr.error('Gagal memuat merk');
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
                        let html = '<option></option>';
                        data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                        $('#chassiss').html(html).prop('disabled', false).trigger('change.select2');
                    })
                    .fail(function() {
                        toastr.error('Gagal memuat chassis');
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
                        let html = '<option></option>';
                        data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                        $('#vehicles').html(html).prop('disabled', false).trigger('change.select2');
                    })
                    .fail(function() {
                        toastr.error('Gagal memuat kendaraan');
                    });
            });

            // --- Ambil data keterangan (Tetap Sama) ---
            $('#vehicles').change(function() {
                let id = $(this).val();
                $('#hidden_vehicle_id').val(id);

                $('.gambar-rincian-row').find('.gambar-keterangan').html('<option></option>').val(null)
                    .trigger('change.select2').prop('disabled', true);

                $('.preview-gambar-btn').prop('disabled', true);

                updatePageNumbers();

                if (!id) return;

                $.get("<?php echo e(route('get.keterangans')); ?>", {
                        mdata_id: id
                    })
                    .done(function(data) {
                        let html = '<option></option>';
                        if (Array.isArray(data) && data.length) {
                            data.forEach(d => {
                                const fotoData = {
                                    utama: d.foto_utama || null,
                                    terurai: d.foto_terurai || null,
                                    kontruksi: d.foto_kontruksi || null,
                                };
                                html +=
                                    `<option value="${d.id}" data-foto='${JSON.stringify(fotoData)}'>${d.keterangan}</option>`;
                            });
                        } else {
                            html += `<option value="">Tidak ada data keterangan</option>`;
                        }

                        $('.gambar-rincian-row').find('.gambar-keterangan')
                            .html(html)
                            .trigger('change.select2');

                        updatePageNumbers();
                    })
                    .fail(function(xhr) {
                        console.error('Gagal memuat data keterangan:', xhr.responseText);
                        toastr.error('Gagal memuat data keterangan');
                    });
            });

            // Listener Sinkronisasi Varian Utama ke Terurai & Kontruksi
            $(document).on('change', '.gambar-rincian-row[id^="utama-row-"] .varian-select', function() {
                if (isHanyaTU) return;

                let row = $(this).closest('.gambar-rincian-row');
                let rowNum = row.attr('id').split('-')[2];
                let selectedVarianId = $(this).val();
                let selectedOption = $(this).find('option:selected');

                // Ambil data nama varian yang berbeda
                let utamaName = selectedOption.data('utama');
                let teruraiName = selectedOption.data('terurai');
                let kontruksiName = selectedOption.data('kontruksi');

                ['terurai', 'kontruksi'].forEach(type => {
                    let syncRow = $('#' + type + '-row-' + rowNum);
                    if (syncRow.is(':visible')) {
                        let syncSelect = syncRow.find('.varian-select');

                        // 1. Sinkronkan nilai ID Varian
                        syncSelect.val(selectedVarianId).trigger('change.select2');

                        // 2. Update teks sesuai kategori
                        let newText = type === 'terurai' ? teruraiName : kontruksiName;
                        if (newText) {
                            let syncOption = syncSelect.find(`option[value="${selectedVarianId}"]`);
                            syncOption.text(newText);
                            updateSelect2Text(syncSelect, newText);
                        }
                    }
                });
            });



            // --- Listener Sinkronisasi Keterangan (Tetap Sama) ---
            $(document).on('change', '.gambar-rincian-row .gambar-keterangan', function() {
                let row = $(this).closest('.gambar-rincian-row');
                let isSelected = !!$(this).val();
                row.find('.preview-gambar-btn').prop('disabled', !isSelected);

                if (isHanyaTU) return;

                let rowId = row.attr('id');
                let type = rowId.split('-')[0];
                let rowNum = rowId.split('-')[2];
                let selectedKeterangan = $(this).val();
                let isPrimary = (type === 'utama');

                if (isPrimary) {
                    ['terurai', 'kontruksi'].forEach(syncType => {
                        let syncRow = $('#' + syncType + '-row-' + rowNum);
                        if (syncRow.is(':visible')) {
                            syncRow.find('.gambar-keterangan').val(selectedKeterangan).trigger(
                                'change.select2');
                            syncRow.find('.preview-gambar-btn').prop('disabled', !isSelected);
                        }
                    });
                }
            });


            // --- Preview gambar modal (Tetap Sama) ---
            $(document).on('click', '.preview-gambar-btn', function() {
                let row = $(this).closest('.gambar-rincian-row');
                let selectedOption = row.find('.gambar-keterangan option:selected');

                if (!selectedOption.val()) {
                    toastr.warning("Silakan pilih Keterangan terlebih dahulu.");
                    return;
                }

                let fotoData = selectedOption.data('foto') || {};
                let rowId = row.attr('id');
                let jenisGambar = rowId.split('-')[0];

                if (!fotoData[jenisGambar]) {
                    toastr.warning("Tidak ada gambar yang tersedia untuk jenis body ini.");
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

<?php echo $__env->make('drafter.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\02. ZULFIKAR\CODING\REKAYASA\SIREGAR\resources\views/drafter/workspace/add_workspace.blade.php ENDPATH**/ ?>