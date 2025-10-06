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
                                                <label class="col-sm-3 col-form-label-sm">No. ID:</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" value="Auto Generate" readonly>
                                                </div>
                                                <label class="col-sm-3 col-form-label-sm text-right">Jumlah Gbr Tu:</label>
                                                <div class="col-sm-3">
                                                    <select name="total_images" id="jumlah_gambar_total" class="form-control form-control-sm select2-sm" required>
                                                        <option selected disabled>Pilih</option>
                                                        <?php for($i = 1; $i <= 4; $i++): ?>
                                                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Customer:</label>
                                                <div class="col-sm-9">
                                                    <select name="customer_id" id="customers" class="form-control form-control-sm select2" style="width: 250px;" required>
                                                        <option selected disabled>Pilih Perusahaan</option>
                                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Jenis Pengajuan:</label>
                                                <div class="col-sm-9">
                                                    <select name="submission_id" id="submissions" class="form-control form-control-sm select2" style="width: 150px;" required>
                                                        <option selected disabled>Pilih Pengajuan</option>
                                                        <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Diperiksa:</label>
                                                <div class="col-sm-9">
                                                    <select name="employee_id" id="employees" class="form-control form-control-sm select2" style="width: 150px;" required>
                                                        <option selected disabled>Pilih Drafter</option>
                                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($e->id); ?>"><?php echo e($e->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Type Engine:</label>
                                                <div class="col-sm-9">
                                                    <select name="engine_id" id="engines" class="form-control form-control-sm select2" style="width: 150px;" required>
                                                        <option selected disabled>Pilih Engine</option>
                                                        <?php $__currentLoopData = $engines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $en): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($en->id); ?>"><?php echo e($en->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Merk:</label>
                                                <div class="col-sm-9">
                                                    <select name="brand_id_display" id="brands" class="form-control form-control-sm select2" style="width: 250px;" required disabled>
                                                        <option selected disabled>Pilih Merk</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Type Chassis:</label>
                                                <div class="col-sm-9">
                                                    <select name="chassis_id_display" id="chassiss" class="form-control form-control-sm select2" style="width: 250px;" required disabled>
                                                        <option selected disabled>Pilih Chassis</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1 align-items-center">
                                                <label class="col-sm-3 col-form-label-sm">Jenis Kendaraan:</label>
                                                <div class="col-sm-9">
                                                    <select name="vehicle_id_display" id="vehicles" class="form-control form-control-sm select2" style="width: 150px;" required disabled>
                                                        <option selected disabled>Pilih Jenis</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr>

                                    
                                    <div class="card card-outline card-primary p-2 mb-3">
                                        <h5 class="card-title text-primary">Gambar Utama</h5>
                                        <div class="card-body p-0" id="gambar-utama-container">
                                            <?php for($i = 1; $i <= 4; $i++): ?>
                                                <div id="utama-row-<?php echo e($i); ?>" class="gambar-rincian-row" style="display: none;">
                                                    <?php echo $__env->make('drafter.workspace.gambar_item', [
                                                        'type' => 'utama', 
                                                        'index' => $i, 
                                                        'varians' => $varians
                                                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    
                                    <div class="card card-outline card-danger p-2 mb-3">
                                        <h5 class="card-title text-danger">Gambar Terurai</h5>
                                        <div class="card-body p-0" id="gambar-terurai-container">
                                            <?php for($i = 1; $i <= 4; $i++): ?>
                                                <div id="terurai-row-<?php echo e($i); ?>" class="gambar-rincian-row" style="display: none;">
                                                    <?php echo $__env->make('drafter.workspace.gambar_item', [
                                                        'type' => 'terurai', 
                                                        'index' => $i, 
                                                        'varians' => $varians
                                                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    
                                    <div class="card card-outline card-success p-2 mb-3">
                                        <h5 class="card-title text-success">Gambar Konstruksi</h5>
                                        <div class="card-body p-0" id="gambar-kontruksi-container">
                                            <?php for($i = 1; $i <= 4; $i++): ?>
                                                <div id="kontruksi-row-<?php echo e($i); ?>" class="gambar-rincian-row" style="display: none;">
                                                    <?php echo $__env->make('drafter.workspace.gambar_item', [
                                                        'type' => 'kontruksi', 
                                                        'index' => $i, 
                                                        'varians' => $varians
                                                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
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
    $('.select2').select2({ width: '100%' });
    $('.select2-sm').select2({ width: 'style', minimumResultsForSearch: Infinity });

    // util
    function pad(num, size) {
        return ("000000000" + num).slice(-size);
    }

    /**
     * updatePageNumbers
     * - Denominator = totalPages = selectedCount * numberOfCategories (3)
     * - Set tiap .halaman-gambar-input => "NN / TT" (contoh: "01 / 09")
     * - Update hidden_jumlah_gambar agar backend menerima jumlah total halaman
     */
    function updatePageNumbers() {
        let count = parseInt($('#jumlah_gambar_total').val()) || 0;
        const categories = ['utama', 'terurai', 'kontruksi']; // pastikan cocok dengan id row di blade (kontruksi)
        const numberOfCategories = categories.length;
        const totalPages = count * numberOfCategories;

        // simpan total ke hidden input supaya backend tahu jumlah halaman
        $('#hidden_jumlah_gambar').val(totalPages);

        let currentPage = 1;
        // jika count = 0, clear semua halaman
        if (count <= 0) {
            categories.forEach(type => {
                for (let i = 1; i <= 4; i++) {
                    let row = $('#' + type + '-row-' + i);
                    let pageInput = row.find('.halaman-gambar-input');
                    pageInput.val('').prop('required', false);
                }
            });
            return;
        }

        categories.forEach(type => {
            for (let i = 1; i <= 4; i++) {
                let row = $('#' + type + '-row-' + i);
                let pageInput = row.find('.halaman-gambar-input');

                // hanya set halaman untuk row yang VISIBLE (yang diaktifkan oleh jumlah_gambar_total)
                if (row.is(':visible')) {
                    let pageNum = pad(currentPage, 2);
                    let denom = pad(totalPages, 2);
                    pageInput.val(`${pageNum} / ${denom}`).prop('required', true);
                    currentPage++;
                } else {
                    pageInput.val('').prop('required', false);
                }
            }
        });
    }

    // ketika jumlah gambar total berubah => show/hide rows dan update penomoran
    $('#jumlah_gambar_total').change(function() {
        let count = parseInt($(this).val()) || 0;

        for (let i = 1; i <= 4; i++) {
            let rows = $('#utama-row-' + i + ', #terurai-row-' + i + ', #kontruksi-row-' + i);
            if (i <= count) {
                rows.show();
            } else {
                // sembunyikan dan reset value/required pada elemen input/select di baris tersembunyi
                rows.hide();
                rows.find('select, input').not('.halaman-gambar-input, [readonly], :hidden').each(function(){
                    $(this).val(null).trigger('change').prop('required', false);
                });
                // reset keterangan & disable preview
                rows.find('.gambar-keterangan').html('<option selected disabled>Pilih Jenis Body</option>').prop('disabled', true).val(null).trigger('change');
                rows.find('.preview-gambar-btn').prop('disabled', true);
                // clear halaman
                rows.find('.halaman-gambar-input').val('').prop('required', false);
            }
        }

        updatePageNumbers();
    }).trigger('change');


    // --- Cascading dropdowns (engine -> brand -> chassis -> vehicle -> keterangans) ---
    function resetDropdowns(start) {
        if (start <= 1) { 
            $('#brands').html('<option selected disabled>Pilih Merk</option>').prop('disabled', true).val(null).trigger('change');
            $('#hidden_brand_id').val('');
        }
        if (start <= 2) { 
            $('#chassiss').html('<option selected disabled>Pilih Chassis</option>').prop('disabled', true).val(null).trigger('change');
            $('#hidden_chassis_id').val('');
        }
        if (start <= 3) { 
            $('#vehicles').html('<option selected disabled>Pilih Jenis</option>').prop('disabled', true).val(null).trigger('change');
            $('#hidden_vehicle_id').val('');
        }
        // Mereset semua dropdown keterangan gambar (tetap disabled)
        $('.gambar-keterangan').html('<option selected disabled>Pilih Jenis Body</option>').prop('disabled', true).val(null).trigger('change');
        $('.preview-gambar-btn').prop('disabled', true);
    }

    $('#engines').change(function() {
        let id = $(this).val();
        resetDropdowns(1);
        if (!id) return;
        $.get("<?php echo e(route('get.brands')); ?>", { engine_id: id }, function(data) {
            let html = '<option selected disabled>Pilih Merk</option>';
            data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
            $('#brands').html(html).prop('disabled', false).trigger('change');
        });
    });

    $('#brands').change(function() {
        let id = $(this).val();
        $('#hidden_brand_id').val(id);
        resetDropdowns(2);
        if (!id) return;
        $.get("<?php echo e(route('get.chassiss')); ?>", { brand_id: id }, function(data) {
            let html = '<option selected disabled>Pilih Chassis</option>';
            data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
            $('#chassiss').html(html).prop('disabled', false).trigger('change');
        });
    });

    $('#chassiss').change(function() {
        let id = $(this).val();
        $('#hidden_chassis_id').val(id);
        resetDropdowns(3);
        if (!id) return;
        $.get("<?php echo e(route('get.vehicles')); ?>", { chassis_id: id }, function(data) {
            let html = '<option selected disabled>Pilih Jenis Kendaraan</option>';
            data.forEach(d => html += `<option value="${d.id}">${d.name}</option>`);
            $('#vehicles').html(html).prop('disabled', false).trigger('change');
        });
    });

    $('#vehicles').change(function() {
        let id = $(this).val();
        $('#hidden_vehicle_id').val(id);

        // reset semua keterangan pada baris yang VISIBLE
        $('.gambar-rincian-row:visible').find('.gambar-keterangan').html('<option selected disabled>Memuat Jenis Body...</option>').prop('disabled', true).val(null).trigger('change');
        $('.gambar-rincian-row:visible').find('.preview-gambar-btn').prop('disabled', true);

        if (!id) return;

        $.get("<?php echo e(route('get.keterangans')); ?>", { vehicle_id: id }, function(data) {
            let html = '<option selected disabled>Pilih Jenis Body</option>';
            data.forEach(d => {
                let fotoData = d.foto_body ? JSON.stringify(d.foto_body) : '[]';
                html += `<option value="${d.id}" data-foto='${fotoData}'>${d.keterangan}</option>`;
            });

            // Isi dropdown Jenis Body hanya pada baris yang visible
            $('.gambar-rincian-row:visible').find('.gambar-keterangan').html(html).prop('disabled', false).trigger('change');
        });
    });

    // Enable preview button jika keterangan dipilih
    $(document).on('change', '.gambar-keterangan', function() {
        let row = $(this).closest('.gambar-rincian-row');
        let btn = row.find('.preview-gambar-btn');
        if ($(this).val()) btn.prop('disabled', false);
        else btn.prop('disabled', true);
    });

    // Preview gambar modal
    $(document).on('click', '.preview-gambar-btn', function() {
        let parentRow = $(this).closest('.gambar-rincian-row');
        let selectedOption = parentRow.find('.gambar-keterangan option:selected');
        let fotoBody = selectedOption.data('foto');
        let fotoArray = [];

        if (fotoBody) {
            if (typeof fotoBody === "string") {
                try { fotoArray = JSON.parse(fotoBody); } catch (e) { fotoArray = []; }
            } else if (Array.isArray(fotoBody)) {
                fotoArray = fotoBody;
            }
        }

        if (fotoArray.length > 0) {
            let fotoPath = fotoArray[0].startsWith('body/') ? fotoArray[0] : 'body/' + fotoArray[0];
            $('#imgPreviewModal').attr('src', '/storage/' + fotoPath);
            $('#modalPreview').modal('show');
        } else {
            toastr.warning("Tidak ada gambar yang terlampir untuk Jenis Body ini.");
        }
    });

    // Submit via AJAX (menyertakan hidden_jumlah_gambar)
    $('#form-workspace').submit(function(e) {
        e.preventDefault();

        // Validasi minimal
        if (!$('#hidden_brand_id').val() || !$('#hidden_chassis_id').val() || !$('#hidden_vehicle_id').val() || !$('#jumlah_gambar_total').val()) {
            toastr.error("Mohon lengkapi pemilihan Engine, Brand, Chassis, Jenis Kendaraan, dan Jumlah Gambar Total.");
            return;
        }

        // Pastikan jumlah_gambar (hidden) sudah ter-set
        if (!$('#hidden_jumlah_gambar').val() || parseInt($('#hidden_jumlah_gambar').val()) === 0) {
            toastr.error("Jumlah halaman (total) tidak valid. Pastikan memilih Jumlah Gbr Tu.");
            return;
        }

        // Serialize form (hidden_jumlah_gambar akan masuk)
        let formData = $(this).serializeArray();

        $.ajax({
            url: "<?php echo e(route('store.workspace')); ?>",
            method: "POST",
            data: formData,
            success: function(res) {
                if (!res.error) {
                    toastr.success(res.message);
                    setTimeout(function() {
                        window.location.href = "<?php echo e(route('index.workspace')); ?>";
                    }, 1000);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(jqXHR) {
                let msg = "Terjadi error saat menyimpan workspace. Cek log Laravel!";
                if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                    msg = jqXHR.responseJSON.message;
                    if (jqXHR.responseJSON.errors) {
                        let errorList = Object.values(jqXHR.responseJSON.errors).map(e => e.join('<br>')).join('<br>');
                        msg += '<br>' + errorList;
                    }
                }
                toastr.error(msg);
                console.error("AJAX Error:", jqXHR.responseText);
            }
        });
    });

});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('drafter.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CODING\SIREGAR\resources\views\drafter\workspace\add_workspace.blade.php ENDPATH**/ ?>