<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Master Gambar</li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="<?php echo e(route('store.mgambar')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Gambar Baru</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Pilih Data Kendaraan</label>
                                                <select name="mdata_id"
                                                    class="form-control select2 <?php $__errorArgs = ['mdata_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    style="width: 100%;" required>
                                                    <option selected disabled>Pilih Data</option>
                                                    <?php $__currentLoopData = $mdatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($mdata->id); ?>"
                                                            <?php echo e(old('mdata_id') == $mdata->id ? 'selected' : ''); ?>>
                                                            <?php echo e($mdata->engine->name ?? '-'); ?> -
                                                            <?php echo e($mdata->brand->name ?? '-'); ?> -
                                                            <?php echo e($mdata->chassis->name ?? '-'); ?> -
                                                            <?php echo e($mdata->vehicle->name ?? '-'); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['mdata_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <small class="text-danger"><?php echo e($message); ?></small>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="form-group">
                                                <label>Varian Body / Keterangan</label>
                                                <input name="varian_body" type="text"
                                                    class="form-control <?php $__errorArgs = ['varian_body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('varian_body')); ?>"
                                                    placeholder="Contoh: BOX SLIDING / DROP SIDE 5 WAY" required>
                                                <?php $__errorArgs = ['varian_body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <small class="text-danger"><?php echo e($message); ?></small>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        
                                        <div class="col-sm-6">

                                            
                                            <div class="form-group border p-3 rounded mb-3"
                                                style="background-color: #f7f9fc;">
                                                <label for="foto_utama" class="text-info"><i class="fas fa-image"></i>
                                                    Gambar Utama</label>
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Belum ada file dipilih" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-info mb-0" for="foto_utama">
                                                            Upload Gambar
                                                            <input type="file" name="foto_utama" id="foto_utama"
                                                                style="display: none;" accept="image/*"
                                                                onchange="updateFileName(this, 'utama')">
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['foto_utama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <small class="text-danger d-block"><?php echo e($message); ?></small>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                <div class="preview mt-2" id="preview_utama"></div>
                                            </div>

                                            
                                            <div class="form-group border p-3 rounded mb-3"
                                                style="background-color: #f7f9fc;">
                                                <label for="foto_terurai" class="text-warning"><i
                                                        class="fas fa-layer-group"></i> Gambar Terurai</label>
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Belum ada file dipilih" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-warning mb-0" for="foto_terurai">
                                                            Upload Gambar
                                                            <input type="file" name="foto_terurai" id="foto_terurai"
                                                                style="display: none;" accept="image/*"
                                                                onchange="updateFileName(this, 'terurai')">
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['foto_terurai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <small class="text-danger d-block"><?php echo e($message); ?></small>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                <div class="preview mt-2" id="preview_terurai"></div>
                                            </div>

                                            
                                            <div class="form-group border p-3 rounded mb-3"
                                                style="background-color: #f7f9fc;">
                                                <label for="foto_kontruksi" class="text-primary"><i
                                                        class="fas fa-tools"></i> Gambar Konstruksi</label>
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Belum ada file dipilih" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-primary mb-0" for="foto_kontruksi">
                                                            Upload Gambar
                                                            <input type="file" name="foto_kontruksi" id="foto_kontruksi"
                                                                style="display: none;" accept="image/*"
                                                                onchange="updateFileName(this, 'kontruksi')">
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['foto_kontruksi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <small class="text-danger d-block"><?php echo e($message); ?></small>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                <div class="preview mt-2" id="preview_kontruksi"></div>
                                            </div>

                                            
                                            <div class="form-group border p-3 rounded mb-3"
                                                style="background-color: #f7f9fc;">
                                                <label for="foto_optional" class="text-secondary"><i
                                                        class="fas fa-th-large"></i> Gambar Optional</label>
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control form-control-sm file-name-display"
                                                        value="Belum ada file dipilih" readonly>
                                                    <div class="input-group-append">
                                                        <label class="btn btn-sm btn-secondary mb-0" for="foto_optional">
                                                            Upload Gambar
                                                            <input type="file" name="foto_optional" id="foto_optional"
                                                                style="display: none;" accept="image/*"
                                                                onchange="updateFileName(this, 'optional')">
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['foto_optional'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <small class="text-danger d-block"><?php echo e($message); ?></small>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                <div class="preview mt-2" id="preview_optional"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer me-2">
                                    <a href="<?php echo e(route('index.mgambar')); ?>" class="btn btn-outline-danger">Kembali</a>
                                    <input type="submit" value="Simpan Data Gambar" class="btn btn-outline-success">
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(function() {
            $('.select2').select2()
        });

        /**
         * Fungsi untuk menampilkan nama file dan preview gambar, serta menampilkan modal preview saat gambar diklik.
         * @param {HTMLInputElement} input - Elemen input file yang berubah.
         * @param {string} type - Jenis gambar ('utama', 'terurai', 'kontruksi', 'optional').
         */
        function updateFileName(input, type) {
            const fileNameInput = $(input).closest('.input-group').find('.file-name-display');
            const previewContainer = $('#preview_' + type);

            previewContainer.html(''); // Bersihkan preview lama

            if (input.files.length > 0) {
                const file = input.files[0];
                fileNameInput.val(file.name);

                const reader = new FileReader();
                reader.onload = function(e) {
                    // Membuat elemen gambar thumbnail
                    const img = $('<img src="' + e.target.result +
                        '" class="img-thumbnail" style="max-width: 150px; height: auto; cursor:pointer;" alt="Preview Gambar">'
                    );

                    // Menambahkan event click untuk menampilkan modal
                    img.on('click', function() {
                        $('#imgPreviewModal').attr('src', e.target.result);
                        // Asumsi Anda menggunakan Bootstrap 4/5, pastikan modal dipanggil dengan benar
                        $('#modalPreview').modal('show');
                    });

                    previewContainer.append(img);
                }
                reader.readAsDataURL(file);
            } else {
                fileNameInput.val('Belum ada file dipilih');
            }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CODING\SIREGAR\resources\views/admin/mgambar/add_mgambar.blade.php ENDPATH**/ ?>