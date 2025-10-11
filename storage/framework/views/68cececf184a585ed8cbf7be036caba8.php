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
                                        <div class="col-md-4">

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

                                                <label class="col-sm-3 col-form-label-sm">Varian SKRB :</label>
                                                <div class="col-sm-9">
                                                    <input name="sk_varian" type="text"
                                                        class="form-control form-control-sm"
                                                        placeholder="Masukan No Varian SKRB">
                                                    <small><?php echo e($errors->first('sk_varian')); ?></small>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-4">
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

                                                <label class="col-sm-3 col-form-label-sm">Kendaraan :</label>
                                                <div class="col-sm-9">
                                                    <select name="vehicle_id_display" id="vehicles"
                                                        class="form-control form-control-sm select2" required disabled
                                                        data-placeholder="Pilih Jenis Kendaraan">
                                                        <option value="" selected disabled></option>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group row mb-1 align-items-center">

                                                <label class="col-sm-3 col-form-label-sm">Customer :</label>
                                                <div class="col-sm-9">

                                                    <select name="customer_id" id="customers"
                                                        class="form-control form-control-sm select2" required
                                                        data-placeholder="Pilih Customer">
                                                        <option value="" selected disabled></option>
                                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>

                                                </div>

                                            </div>

                                            <div class="form-group row mb-1 align-items-center">

                                                <label class="col-sm-3 col-form-label-sm">Pemeriksa :</label>
                                                <div class="col-sm-9">

                                                    <select name="pemeriksa_id" id="pemeriksa"
                                                        class="form-control form-control-sm select2" required
                                                        data-placeholder="Pilih Pemeriksa">
                                                        <option value="" selected disabled></option>
                                                        <?php $__currentLoopData = $pemeriksas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($p->id); ?>"><?php echo e($p->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>

                                                </div>

                                            </div>

                                            <div class="form-group row mb-1 align-items-center">

                                                <label class="col-sm-3 col-form-label-sm">Drafter :</label>
                                                <div class="col-sm-9">
                                                    <select name="employee_id" id="employee"
                                                        class="form-control form-control-sm select2" required
                                                        data-placeholder="Pilih employee">
                                                        <option value="" selected disabled></option>
                                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($d->id); ?>"><?php echo e($d->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                            'detail' => ['color' => 'secondary', 'display' => 'Detail'],
                                            'kelistrikan' => ['color' => 'warning', 'display' => 'Kelistrikan'],
                                        ];
                                    ?>

                                    <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card card-outline card-<?php echo e($data['color']); ?> p-2 mb-3">
                                            <div class="card-body p-0" id="gambar-<?php echo e($type); ?>-container">

                                                <?php for($i = 1; $i <= ($type === 'detail' ? 10 : 4); $i++): ?>
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
                                                                <?php if($type === 'optional'): ?> required data-placeholder="Pilih Varian" <?php else: ?> disabled required data-placeholder="Pilih Varian" <?php endif; ?>>

                                                                <option value="" selected disabled></option>

                                                                <?php $__currentLoopData = $varians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($v->id); ?>"
                                                                        data-utama="<?php echo e($v->name_utama); ?>"
                                                                        data-terurai="<?php echo e($v->name_terurai); ?>"
                                                                        data-kontruksi="<?php echo e($v->name_kontruksi); ?>"
                                                                        data-optional="<?php echo e($v->name_optional); ?>"
                                                                        data-id-terurai="<?php echo e($v->id_terurai ?? $v->id); ?>"
                                                                        data-id-kontruksi="<?php echo e($v->id_kontruksi ?? $v->id); ?>">
                                                                        <?php if($type === 'terurai'): ?>
                                                                            <?php echo e($v->name_terurai); ?>

                                                                        <?php elseif($type === 'kontruksi'): ?>
                                                                            <?php echo e($v->name_kontruksi); ?>

                                                                        <?php elseif($type === 'optional'): ?>
                                                                            <?php echo e($v->name_optional); ?>

                                                                        <?php elseif($type === 'detail'): ?>
                                                                            <?php echo e($v->name_optional); ?>

                                                                        <?php elseif($type === 'kelistrikan'): ?>
                                                                            <?php echo e($v->name_optional); ?>

                                                                        <?php else: ?>
                                                                            <?php echo e($v->name_utama); ?>

                                                                        <?php endif; ?>
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

                                                                <option value="" selected disabled></option>

                                                                <?php if($type === 'kelistrikan'): ?>
                                                                    <option value="" selected disabled>-- Pilih
                                                                        Kelistrikan --</option>
                                                                    <?php $__currentLoopData = $electricities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($el->id); ?>"
                                                                            data-foto='<?php echo e(json_encode($el->foto_kelistrikan ?? [])); ?>'>
                                                                            <?php echo e($el->description); ?>

                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php else: ?>
                                                                    <?php $__currentLoopData = $varians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($v->id); ?>">
                                                                            <?php if($type === 'terurai'): ?>
                                                                                <?php echo e($v->name_terurai); ?>

                                                                            <?php elseif($type === 'kontruksi'): ?>
                                                                                <?php echo e($v->name_kontruksi); ?>

                                                                            <?php elseif($type === 'optional'): ?>
                                                                                <?php echo e($v->name_optional); ?>

                                                                            <?php elseif($type === 'detail'): ?>
                                                                                <?php echo e($v->name_optional); ?>

                                                                            <?php else: ?>
                                                                                <?php echo e($v->name_utama); ?>

                                                                            <?php endif; ?>
                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>

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
                                                            <?php if($type === 'optional'): ?>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm delete-row-btn ml-1"> <i
                                                                        class="fa fa-trash"></i> Delete </button>
                                                            <?php endif; ?>

                                                            <?php if($type === 'detail'): ?>
                                                                <input type="checkbox"
                                                                    class="form-check-input hide-detail-checkbox"
                                                                    name="rincian[detail][<?php echo e($i); ?>][hide]"
                                                                    id="hide-detail-<?php echo e($i); ?>">
                                                                <label class="form-check-label"
                                                                    for="hide-detail-<?php echo e($i); ?>"></label>
                                                            <?php endif; ?>

                                                            <?php if($type === 'detail' && $i === 1): ?>
                                                                <button type="button"
                                                                    class="btn btn-success btn-sm add-detail-row-btn ml-1">
                                                                    <i class="fa fa-plus"></i> Tambah
                                                                </button>
                                                            <?php endif; ?>

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

            $('.select2').removeAttr('required');


            $('.select2-static').select2({
                width: '100%',
                minimumResultsForSearch: Infinity,
                allowClear: false
            });

            $('.gambar-rincian-row[id^="optional-row-"] .varian-select').prop('disabled', false);

            $('.gambar-rincian-row[id^="optional-row-"] .gambar-keterangan').prop('disabled', true);

            $('#customers, #submissions, #employee, #pemeriksa, #engines, #brands, #chassiss, #vehicles').select2({
                width: '100%',
                allowClear: true
            });

            $('.varian-select, .gambar-keterangan').select2({
                width: '100%',
                allowClear: true
            });

            const HANYA_TU_ID = '4';
            let isHanyaTU = false;
            const ALL_TYPES = ['utama', 'terurai', 'kontruksi', 'optional', 'detail', 'kelistrikan'];

            function pad(num, size = 2) {
                return String(num).padStart(size, '0');
            }

            function updatePageNumbers() {
                const jumlahPerKategori = parseInt($('#jumlah_halaman').val()) || 0;
                const activeTypes = isHanyaTU ? ['utama'] : ALL_TYPES;
                const totalPages = jumlahPerKategori * activeTypes.length;
                $('#hidden_jumlah_gambar').val(totalPages);

                const maxRowsPerType = 4; // sesuai markup (utama, terurai, kontruksi, optional punya 4)
                const vehicleSelected = !!$('#vehicles').val();

                // 1) Sembunyikan semua rows dulu (tapi jangan ubah disabled pada utama bila nanti kita akan enable lagi)
                ALL_TYPES.forEach(type => {
                    for (let i = 1; i <= maxRowsPerType; i++) {
                        const row = $(`#${type}-row-${i}`);
                        if (!row.length) continue;
                        row.hide();
                        // reset nomor halaman fields (akan di-set ulang nanti untuk rows yang visible)
                        row.find('.halaman-gambar-input, .total-halaman-input, .jumlah-gambar-hidden').val(
                            '');
                        // jangan ubah select disabled state di sini, kita atur di langkah berikut
                    }
                });

                // 2) Mode HANYA TU: tampilkan baris utama sebanyak jumlahPerKategori (maks 4)
                if (isHanyaTU) {
                    const jumlahUtama = Math.min(Math.max(jumlahPerKategori, 1), maxRowsPerType);

                    // tampilkan container utama, sembunyikan container lain
                    ALL_TYPES.forEach(type => {
                        const container = $(`#gambar-${type}-container`);
                        if (type === 'utama') {
                            container.show();
                        } else {
                            container.hide();
                            // nonaktifkan selects & preview di container yang disembunyikan
                            container.find('select').prop('disabled', true).val(null).trigger(
                                'change.select2');
                            container.find('.preview-gambar-btn').prop('disabled', true);
                        }
                    });

                    // tampilkan baris utama sesuai jumlahUtama dan aktifkan selects-nya
                    for (let i = 1; i <= maxRowsPerType; i++) {
                        const row = $(`#utama-row-${i}`);
                        if (!row.length) continue;
                        if (i <= jumlahUtama) {
                            row.show();
                            const pageNum = i;
                            row.find('.halaman-gambar-input').val(pad(pageNum));
                            row.find('.total-halaman-input').val(pad(totalPages));
                            row.find('.jumlah-gambar-hidden').val(totalPages);

                            // Pastikan selects di utama aktif (user harus bisa memilih)
                            row.find('.varian-select').prop('disabled', false).trigger('change.select2');
                            row.find('.gambar-keterangan').prop('disabled', false).trigger('change.select2');

                            // Preview: aktifkan hanya kalau option yang terpilih punya foto
                            const selectedOption = row.find('.gambar-keterangan option:selected');
                            const fotoData = selectedOption.data('foto') || {};
                            const hasFile = (fotoData.utama && (Array.isArray(fotoData.utama) ? fotoData.utama
                                .length > 0 : !!fotoData.utama));
                            row.find('.preview-gambar-btn').prop('disabled', !hasFile);
                        } else {
                            row.hide();
                        }
                    }

                    // update nomor & total pages visible
                    updateHalamanRows();
                    return; // jangan lanjut ke logic normal
                }

                // 3) Bukan HANYA TU: tampilkan rows per kategori sesuai jumlahPerKategori
                activeTypes.forEach((type, typeIndex) => {
                    let limit = jumlahPerKategori;
                    if (type === 'kelistrikan' || type === 'detail') limit = 1;

                    for (let i = 1; i <= Math.min(limit, maxRowsPerType); i++) {
                        const row = $(`#${type}-row-${i}`);
                        if (!row.length) continue;

                        row.show();
                        const pageNum = (typeIndex * jumlahPerKategori) + i;
                        row.find('.halaman-gambar-input').val(pad(pageNum));
                        row.find('.total-halaman-input').val(pad(totalPages));
                        row.find('.jumlah-gambar-hidden').val(totalPages);

                        // Aktifkan selects: jika ada vehicle terpilih, biarkan selects tetap bisa diatur
                        row.find('.varian-select').prop('disabled', false).trigger('change.select2');
                        row.find('.gambar-keterangan').prop('disabled', false).trigger('change.select2');

                        // Aktifkan preview jika ada file pada option terpilih
                        const selectedOption = row.find('.gambar-keterangan option:selected');
                        const fotoData = selectedOption.data('foto') || {};
                        let hasFile = false;
                        if (type === 'kelistrikan' || type === 'detail') {
                            hasFile = fotoData[type] && fotoData[type].length > 0;
                        } else {
                            // bisa berupa string atau array, cek fleksibel
                            if (Array.isArray(fotoData[type])) hasFile = fotoData[type].length > 0;
                            else hasFile = !!fotoData[type];
                        }
                        row.find('.preview-gambar-btn').prop('disabled', !hasFile);
                    }
                });

                // akhir: update nomor halaman visible agar konsisten
                updateHalamanRows();
            }


            $('#submissions').on('change', function() {
                const submissionId = $(this).val();
                isHanyaTU = submissionId === HANYA_TU_ID;

                if (isHanyaTU) {

                    ALL_TYPES.forEach(type => {
                        $(`#gambar-${type}-container .gambar-rincian-row`).hide();
                    });


                    $('#gambar-utama-container .gambar-rincian-row:first').show();
                    updateHalamanRows();
                } else {

                    updateKategoriRows();
                }
            });

            function updateKategoriRows() {
                const jumlahHalaman = parseInt($('#jumlah_halaman').val()) || 0;


                ALL_TYPES.forEach(type => {
                    const container = $(`#gambar-${type}-container`);
                    container.find('.gambar-rincian-row').hide();

                    if (type === 'kelistrikan' || type === 'detail') {

                        container.find('.gambar-rincian-row:first').show();
                    } else {

                        for (let i = 1; i <= jumlahHalaman; i++) {
                            container.find(`#${type}-row-${i}`).show();
                        }
                    }
                });
                updateHalamanRows();
            }

            function updateHalamanRows() {
                let pageNum = 1;
                const visibleRows = $('.gambar-rincian-row:visible');

                const totalPages = visibleRows.length;

                visibleRows.each(function() {
                    $(this).find('.halaman-gambar-input').val(String(pageNum).padStart(2, '0'));
                    $(this).find('.total-halaman-input').val(String(totalPages).padStart(2, '0'));
                    $(this).find('.jumlah-gambar-hidden').val(totalPages);
                    pageNum++;
                });
            }

            $('#jumlah_halaman').on('change', updatePageNumbers);
            updatePageNumbers();

            function resetDropdowns(start) {
                if (start <= 1) {
                    $('#brands').html('<option></option>').val(null).prop('disabled', true).trigger(
                        'change.select2');
                    $('#hidden_brand_id').val('');
                }
                if (start <= 2) {
                    $('#chassiss').html('<option></option>').val(null).prop('disabled', true).trigger(
                        'change.select2');
                    $('#hidden_chassis_id').val('');
                }
                if (start <= 3) {
                    $('#vehicles').html('<option></option>').val(null).prop('disabled', true).trigger(
                        'change.select2');
                    $('#hidden_vehicle_id').val('');
                    $('.gambar-rincian-row').find('.varian-select, .gambar-keterangan').prop('disabled', true).val(
                        null).trigger('change.select2');
                    $('.preview-gambar-btn').prop('disabled', true);
                    updatePageNumbers();
                }
            }

            $('#engines').change(function() {
                const id = $(this).val();
                resetDropdowns(1);
                if (!id) return;
                $.get("<?php echo e(route('get.brands')); ?>", {
                        engine_id: id
                    })
                    .done(function(data) {
                        let html = '<option></option>';
                        data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
                        $('#brands').html(html).prop('disabled', false).trigger('change.select2');
                    });
            });

            $('#brands').change(function() {
                const id = $(this).val();
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
                    });
            });

            $('#chassiss').change(function() {
                const id = $(this).val();
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
                    });
            });

            $('#gambar-detail-container, #gambar-kelistrikan-container').hide();

            $('#vehicles').change(function() {
                const id = $(this).val();
                $('#hidden_vehicle_id').val(id);

                updatePageNumbers();

                // 🚫 Jika pengajuan hanya TU, tampilkan hanya kategori "utama"
                if (isHanyaTU) {
                    // berapa baris utama yang harus ditampilkan (default 1)
                    const jumlahUtama = parseInt($('#jumlah_halaman').val()) || 1;
                    const maxUtama = 4; // sesuai markup kamu (utama punya 4 row di blade)

                    // sembunyikan semua container kecuali utama
                    ALL_TYPES.forEach(type => {
                        const container = $(`#gambar-${type}-container`);
                        if (type === 'utama') {
                            container.show();
                            // untuk utama: tampilkan rows 1..jumlahUtama, sembunyikan sisanya
                            for (let i = 1; i <= maxUtama; i++) {
                                const row = $(`#${type}-row-${i}`);
                                if (!row.length) continue;
                                if (i <= jumlahUtama) {
                                    row.show();
                                    // pastikan input di utama aktif
                                    row.find('.varian-select').prop('disabled', false).trigger(
                                        'change.select2');
                                    row.find('.gambar-keterangan').prop('disabled', false).trigger(
                                        'change.select2');
                                    row.find('.preview-gambar-btn').prop('disabled',
                                        true); // preview off awal
                                } else {
                                    row.hide();
                                }
                            }
                        } else {
                            container.hide();
                            // nonaktifkan semua selects & tombol di container yang disembunyikan
                            container.find('select, button').prop('disabled', true);
                        }
                    });

                    // pastikan semua jumlah/nomor halaman sesuai urutan yang terlihat
                    updateHalamanRows();

                    // stop eksekusi, jangan lanjut ke logic normal
                    return;
                }

                // ===== kalau bukan HANYA TU, jalankan logic normal (existing) =====
                if (id) {
                    $('#gambar-detail-container, #gambar-kelistrikan-container').show();

                    ['detail', 'kelistrikan'].forEach(type => {
                        const row = $(`#${type}-row-1`);
                        if (!row.length) return;
                        row.show();
                        row.find('.varian-select, .gambar-keterangan').prop('disabled', false)
                            .trigger('change.select2');

                        const selectedOption = row.find('.gambar-keterangan option:selected');
                        const fotoData = selectedOption.data('foto') || {};
                        const hasFile = fotoData && fotoData[type];
                        row.find('.preview-gambar-btn').prop('disabled', !hasFile);
                    });
                } else {
                    $('#gambar-detail-container, #gambar-kelistrikan-container').hide();
                }

                // Reset semua dropdown keterangan dan preview di seluruh rows
                $('.gambar-rincian-row').find('.gambar-keterangan').html('<option></option>').val(null)
                    .prop('disabled', true).trigger('change.select2');
                $('.preview-gambar-btn').prop('disabled', true);

                if (!id) return;

                // --- Keterangan Umum ---
                $.get("<?php echo e(route('get.keterangans')); ?>", {
                        mdata_id: id
                    })
                    .done(function(data) {
                        let optionHtml = '<option></option>';
                        if (Array.isArray(data) && data.length) {
                            data.forEach(function(d) {
                                const fotoData = {
                                    utama: d.foto_utama || null,
                                    terurai: d.foto_terurai || null,
                                    kontruksi: d.foto_kontruksi || null,
                                    optional: d.foto_optional || null,
                                    detail: d.foto_detail || null,
                                    kelistrikan: d.foto_kelistrikan || null
                                };
                                optionHtml +=
                                    `<option value="${d.id}" data-foto='${JSON.stringify(fotoData)}'>${d.keterangan}</option>`;
                            });
                        } else {
                            optionHtml += `<option value="">Tidak ada data keterangan</option>`;
                        }

                        $('.gambar-rincian-row').each(function() {
                            const row = $(this);
                            const rowId = row.attr('id') || '';
                            const type = rowId.split('-')[0];
                            const varianSelect = row.find('.varian-select');
                            const keteranganSelect = row.find('.gambar-keterangan');

                            if (type !== 'kelistrikan') {
                                keteranganSelect.html(optionHtml).val(null).trigger(
                                    'change.select2');
                                varianSelect.prop('disabled', false).trigger('change.select2');
                                keteranganSelect.prop('disabled', false).trigger(
                                    'change.select2');
                            }
                        });
                    })
                    .fail(function() {
                        toastr.error('Gagal memuat data keterangan');
                    });

                // --- Keterangan Kelistrikan ---
                $.get("<?php echo e(route('get.keterangans.electricity')); ?>", {
                        mdata_id: id
                    })
                    .done(function(res) {
                        const $kelistrikan = $('#kelistrikan-row-1 .gambar-keterangan');
                        $kelistrikan.empty().append(
                            '<option value="">-- Pilih Kelistrikan --</option>');

                        res.forEach(function(item) {
                            const fotoData = [{
                                file_name: item.file_name,
                                file_path: item.file_path
                            }];
                            $kelistrikan.append(
                                `<option value="${item.id}" data-foto='${JSON.stringify({ kelistrikan: fotoData })}'>${item.description}</option>`
                            );
                        });

                        $kelistrikan.prop('disabled', false).trigger('change.select2');
                        $('#kelistrikan-row-1 .preview-gambar-btn').prop('disabled', true);

                        $kelistrikan.select2({
                            width: '100%',
                            placeholder: '-- Pilih Kelistrikan --',
                            allowClear: true
                        }).on('select2:select', function(e) {
                            const selectedOption = $(this).find('option:selected');
                            const fotoData = selectedOption.data('foto') || {};
                            const row = $(this).closest('.gambar-rincian-row');
                            const kelistrikanFotos = fotoData.kelistrikan || [];
                            row.find('.preview-gambar-btn').prop('disabled', kelistrikanFotos
                                .length === 0);
                        });
                    })
                    .fail(function() {
                        toastr.error('Gagal memuat data kelistrikan');
                    });

                // --- Keterangan Detail ---
                $.get("<?php echo e(route('get.keterangans.detail')); ?>", {
                        mdata_id: id
                    })
                    .done(function(res) {
                        const $detail = $('#detail-row-1 .gambar-keterangan');
                        $detail.off('change');
                        $detail.empty().append('<option value="">-- Pilih Detail --</option>');

                        res.forEach(function(item) {
                            const fotoData = [{
                                file_name: item.file_name,
                                file_path: item.file_path
                            }];
                            $detail.append(
                                `<option value="${item.id}" data-foto='${JSON.stringify({ detail: fotoData })}'>${item.description}</option>`
                            );
                        });

                        $detail.prop('disabled', false);

                        if ($detail.hasClass('select2-hidden-accessible')) {
                            $detail.select2('destroy');
                        }
                        $detail.select2({
                            width: '100%',
                            placeholder: '-- Pilih Detail --',
                            allowClear: true
                        });

                        $detail.on('change', function() {
                            const row = $(this).closest('.gambar-rincian-row');
                            const selectedOption = $(this).find('option:selected');
                            const fotoData = selectedOption.data('foto') || {};
                            const detailFotos = fotoData.detail || [];
                            row.find('.preview-gambar-btn').prop('disabled', detailFotos
                                .length === 0);
                        });
                    })
                    .fail(function() {
                        toastr.error('Gagal memuat data detail');
                    });
            });



            // Event ketika kategori Utama / sinkronisasi semua
            $(document).on('change',
                '.gambar-rincian-row[id^="utama-row-"] .varian-select, .gambar-rincian-row[id^="utama-row-"] .gambar-keterangan',
                function() {
                    const row = $(this).closest('.gambar-rincian-row');
                    const rowNum = row.attr('id').split('-')[2];

                    const varianSelect = row.find('.varian-select');
                    const selectedVarianId = varianSelect.val();
                    const selectedVarian = varianSelect.find(`option[value="${selectedVarianId}"]`);
                    const utamaName = selectedVarian.data('utama');
                    const teruraiName = selectedVarian.data('terurai');
                    const kontruksiName = selectedVarian.data('kontruksi');
                    const optionalName = selectedVarian.data('optional');
                    const detailName = selectedVarian.data('detail');
                    const kelistrikanName = selectedVarian.data('kelistrikan');

                    const selectedOption = row.find('.gambar-keterangan option:selected');
                    const fotoData = selectedOption.length ? selectedOption.data('foto') || {} : {};
                    const isKeteranganSelected = selectedOption.length && selectedOption.val();

                    const hasFileUtama = fotoData.utama && fotoData.utama.length > 0;
                    row.find('.preview-gambar-btn').prop('disabled', !hasFileUtama);

                    ['terurai', 'kontruksi', 'optional'].forEach(type => {
                        const syncRow = $(`#${type}-row-${rowNum}`);
                        if (!syncRow.length) return;

                        syncRow.show();

                        const syncSelect = syncRow.find('.varian-select');
                        const keteranganSelect = syncRow.find('.gambar-keterangan');

                        if (type === 'terurai' || type === 'kontruksi' || type === 'detail' || type ===
                            'kelistrikan') {
                            if (selectedVarianId) {
                                syncSelect.val(selectedVarianId).trigger('change.select2');

                                let newText = utamaName;
                                if (type === 'terurai') newText = teruraiName;
                                else if (type === 'kontruksi') newText = kontruksiName;
                                else if (type === 'detail') newText = detailName;
                                else if (type === 'kelistrikan') newText = kelistrikanName;

                                if (newText) {
                                    const syncOption = syncSelect.find(
                                        `option[value="${selectedVarianId}"]`);
                                    if (syncOption.length) syncOption.text(newText);
                                    updateSelect2Text(syncSelect, newText);
                                }
                            }
                            syncSelect.prop('disabled', true);
                        } else if (type === 'optional') {
                            syncSelect.prop('disabled', false);
                        }

                        if (isKeteranganSelected) {
                            keteranganSelect.val(selectedOption.val()).trigger('change.select2');
                            const syncOptionKet = keteranganSelect.find(
                                `option[value="${selectedOption.val()}"]`);
                            if (syncOptionKet.length) syncOptionKet.data('foto', fotoData);
                        } else {
                            keteranganSelect.val(null).trigger('change.select2');
                        }

                        let hasFile = false;
                        if (type === 'optional') {
                            hasFile = fotoData.optional && fotoData.optional.length > 0;
                        } else {
                            hasFile = fotoData[type] && fotoData[type].length > 0;
                        }
                        syncRow.find('.preview-gambar-btn').prop('disabled', !hasFile);

                        if (type === 'terurai' || type === 'kontruksi' || type === 'detail' || type ===
                            'kelistrikan') {
                            keteranganSelect.prop('disabled', true);
                        } else if (type === 'optional') {
                            keteranganSelect.prop('disabled', true);
                        } else if (type === 'utama') {
                            keteranganSelect.prop('disabled', false);
                        }
                    });

                    // Pastikan detail dan kelistrikan tetap aktif mandiri
                    ['detail', 'kelistrikan'].forEach(type => {
                        const row = $(`#${type}-row-1`);
                        if (!row.length) return;
                        row.show();

                        row.find('.varian-select').prop('disabled', false).trigger('change.select2');
                        row.find('.gambar-keterangan').prop('disabled', false).trigger(
                            'change.select2');

                        // Aktifkan preview jika ada foto
                        const selectedOption = row.find('.gambar-keterangan option:selected');
                        const fotoData = selectedOption.data('foto') || {};
                        const jenisGambar = row.attr('id').split('-')[0];
                        const hasFile = fotoData && fotoData[jenisGambar];
                        row.find('.preview-gambar-btn').prop('disabled', !hasFile);
                    });

                    $(document).on('change', '.gambar-keterangan', function() {
                        const path = $(this).find(':selected').data('path');
                        if (path) {
                            // tampilkan preview gambar
                            $('#preview-image').attr('src', '/storage/' + path);
                        }
                    });


                });


            // Helper untuk update tampilan teks Select2
            function updateSelect2Text($select, text) {
                const container = $select.next('.select2-container').find('.select2-selection__rendered');
                if (container.length) container.text(text);
            }

            // optional varian label update (tetap sama)
            $(document).on('change', '.gambar-rincian-row[id^="optional-row-"] .varian-select', function() {
                const $sel = $(this);
                const opt = $sel.find('option:selected');
                const optionalName = opt.data('optional') || opt.text();
                updateSelect2Text($sel, optionalName);
            });

            // Kategori DETAIL dan KELISTRIKAN tidak sinkron dan berdiri sendiri
            ['detail', 'kelistrikan'].forEach(type => {
                const row = $(`#${type}-row-1`);
                if (!row.length) return;
                row.show();

                const varianSelect = row.find('.varian-select');
                const keteranganSelect = row.find('.gambar-keterangan');

                // Bebas dipilih
                varianSelect.prop('disabled', false).trigger('change.select2');
                keteranganSelect.prop('disabled', false).trigger('change.select2');

                // Aktifkan tombol preview jika ada data gambar
                const selectedOption = keteranganSelect.find('option:selected');
                const fotoData = selectedOption.data('foto') || {};
                const jenisGambar = row.attr('id').split('-')[0];
                const hasFile = fotoData && fotoData[jenisGambar];
                row.find('.preview-gambar-btn').prop('disabled', !hasFile);
            });


            // Tambah baris baru di kategori DETAIL
            $(document).on('click', '.add-detail-row-btn', function() {
                const container = $('#gambar-detail-container');
                const visibleRows = container.find('.gambar-rincian-row:visible');
                const hiddenRows = container.find('.gambar-rincian-row:hidden');

                if (visibleRows.length >= 10) {
                    toastr.warning('Maksimal 10 baris detail saja.');
                    return;
                }

                if (hiddenRows.length === 0) {
                    // Kalau belum ada row lebih dari 4 di HTML, bisa buat dinamis (jika kamu mau)
                    toastr.warning('Tidak ada baris tambahan yang tersedia.');
                    return;
                }

                const nextRow = hiddenRows.first();
                nextRow.show();
                nextRow.find('.varian-select, .gambar-keterangan').prop('disabled', false).trigger(
                    'change.select2');
                nextRow.find('.preview-gambar-btn').prop('disabled', true);

                updateHalamanRows();

                toastr.success('Baris detail baru ditambahkan.');
            });

            // Event toggle hide hanya untuk kategori detail
            $(document).on('change', '.hide-detail-checkbox', function() {
                const row = $(this).closest('.gambar-rincian-row');
                if ($(this).is(':checked')) {
                    row.hide();
                } else {
                    row.show();
                }
                updateHalamanRows(); // tetap update nomor & total halaman
            });

            // Event preview tombol
            $(document).on('click', '.preview-gambar-btn', function() {
                const row = $(this).closest('.gambar-rincian-row');
                const selectedOption = row.find('.gambar-keterangan option:selected');

                if (!selectedOption.length || !selectedOption.val()) {
                    toastr.warning("Silakan pilih Keterangan terlebih dahulu.");
                    return;
                }

                const fotoData = selectedOption.data('foto') || {};
                const jenisGambar = row.attr('id').split('-')[0];
                let htmlContent = '';
                let isHandled = false;

                // --- LOGIKA KELISTRIKAN
                if ((jenisGambar === 'kelistrikan' || jenisGambar === 'detail') && fotoData[jenisGambar] &&
                    fotoData[jenisGambar].length > 0) {

                    fotoData[jenisGambar].forEach(foto => {

                        const rawPath = foto.file_path;


                        const imagePath = rawPath.startsWith('/storage/') ? rawPath : '/storage/' +
                            rawPath;


                        htmlContent +=
                            `<div class="mb-2 text-center">
                            <img src="${imagePath}" class="img-fluid border rounded" alt="${foto.file_name}">
                            </div>`;
                    });
                    isHandled = true;
                }

                // --- LOGIKA JENIS GAMBAR LAIN (Single File Name, Asumsi path: /storage/body/) ---
                else if (fotoData[jenisGambar]) {
                    // Ini berlaku untuk utama, terurai, kontruksi, optional
                    // ... (kode Anda yang lain untuk kategori non-kelistrikan/detail tetap di sini) ...
                    const fileNama = jenisGambar === 'optional' ? fotoData.optional[0].file_name : fotoData[
                        jenisGambar];

                    if (fileNama) {
                        htmlContent =
                            `<div class="mb-2 text-center">
                                <img src="/storage/body/${fileNama}" class="img-fluid border rounded" alt="Preview ${jenisGambar}">
                            </div>`;
                        isHandled = true;
                    }
                }

                if (isHandled && htmlContent) {
                    // Masukkan gambar ke dalam modal
                    $('#imgPreviewModal').html(htmlContent);

                    // Tampilkan modal yang sudah kamu punya
                    $('#modalPreview').modal('show');
                } else {
                    toastr.warning("Tidak ada gambar yang tersedia untuk kategori ini.");
                }
            });

            // Delete optional (sama seperti sebelumnya)
            $(document).on('click', '.delete-row-btn', function() {
                const row = $(this).closest('.gambar-rincian-row');
                if (!row.attr('id').startsWith('optional-row')) return;

                row.find('select').val(null).trigger('change.select2').prop('disabled', true);
                row.find('input').val('').prop('readonly', true).prop('disabled', true);
                row.find('.preview-gambar-btn').prop('disabled', true);
                row.hide();

                updateHalamanRows();

                const totalAktif = $('.halaman-gambar-input:visible').length;
                $('.total-halaman-input:visible').val(String(totalAktif).padStart(2, '0'));
                $('#hidden_jumlah_gambar').val(totalAktif);

                let pageNum = 1;
                $('.halaman-gambar-input:visible').each(function() {
                    $(this).val(String(pageNum).padStart(2, '0'));
                    pageNum++;
                });
                toastr.info('Baris optional dihapus.');
            });

            $(document).on('submit', '#form-workspace', function(e) {
                e.preventDefault(); // hentikan submit default dulu

                const $form = $(this);
                const fd = new FormData(this);

                // tampilkan semua field yang akan dikirim
                let output = '';
                for (const [k, v] of fd.entries()) {
                    output += `${k} = ${v}\n`;
                }
                toastr.info(output, 'DEBUG: Data Form'); // tampilkan toastr semua field

                // opsional: lanjut submit setelah 1 detik agar bisa lihat toastr
                setTimeout(() => {
                    $form.off('submit'); // matikan event ini supaya submit normal jalan
                    $form.submit();
                }, 1000);
            });



        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('drafter.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\02. ZULFIKAR\CODING\REKAYASA\SIREGAR\resources\views/drafter/workspace/add_workspace.blade.php ENDPATH**/ ?>