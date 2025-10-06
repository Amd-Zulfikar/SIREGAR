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
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                
                <form method="POST" action="<?php echo e(route('update.mgambar', $mgambar->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Data Gambar: <?php echo e($mgambar->varian_body); ?></h3>
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
                                                    <option disabled>Pilih Data</option>
                                                    <?php $__currentLoopData = $mdatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($mdata->id); ?>"
                                                            <?php echo e(old('mdata_id', $mgambar->mdata_id) == $mdata->id ? 'selected' : ''); ?>>
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
                                                    value="<?php echo e(old('varian_body', $mgambar->keterangan)); ?>"
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

                                            
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label for="foto_utama" class="text-info"><i class="fas fa-image"></i>
                                                    Gambar Utama
                                                    <?php if($mgambar->foto_utama): ?>
                                                        <span class="badge badge-info ml-1">TERSEDIA</span>
                                                    <?php endif; ?>
                                                </label>

                                                
                                                <div class="current-image-preview mb-2" id="current_preview_utama">
                                                    <?php if($mgambar->foto_utama): ?>
                                                        <img src="<?php echo e(asset('storage/body/' . $mgambar->foto_utama)); ?>"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width: 150px; height: auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Gambar saat ini (disimpan)</p>
                                                    <?php else: ?>
                                                        <p class="text-muted small mt-1">Belum ada gambar utama.</p>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <input type="hidden" name="old_foto_utama"
                                                    value="<?php echo e($mgambar->foto_utama); ?>">

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

                                            
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label for="foto_terurai" class="text-warning"><i
                                                        class="fas fa-layer-group"></i> Gambar Terurai
                                                    <?php if($mgambar->foto_terurai): ?>
                                                        <span class="badge badge-warning ml-1">TERSEDIA</span>
                                                    <?php endif; ?>
                                                </label>

                                                <div class="current-image-preview mb-2" id="current_preview_terurai">
                                                    <?php if($mgambar->foto_terurai): ?>
                                                        
                                                        <img src="<?php echo e(asset('storage/body/' . $mgambar->foto_terurai)); ?>"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width: 150px; height: auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Gambar saat ini (disimpan)</p>
                                                    <?php else: ?>
                                                        <p class="text-muted small mt-1">Belum ada gambar terurai.</p>
                                                    <?php endif; ?>
                                                </div>
                                                <input type="hidden" name="old_foto_terurai"
                                                    value="<?php echo e($mgambar->foto_terurai); ?>">

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

                                            
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label for="foto_kontruksi" class="text-primary"><i
                                                        class="fas fa-tools"></i> Gambar Konstruksi
                                                    <?php if($mgambar->foto_kontruksi): ?>
                                                        <span class="badge badge-primary ml-1">TERSEDIA</span>
                                                    <?php endif; ?>
                                                </label>

                                                <div class="current-image-preview mb-2" id="current_preview_kontruksi">
                                                    <?php if($mgambar->foto_kontruksi): ?>
                                                        
                                                        <img src="<?php echo e(asset('storage/body/' . $mgambar->foto_kontruksi)); ?>"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width: 150px; height: auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Gambar saat ini (disimpan)</p>
                                                    <?php else: ?>
                                                        <p class="text-muted small mt-1">Belum ada gambar konstruksi.</p>
                                                    <?php endif; ?>
                                                </div>
                                                <input type="hidden" name="old_foto_kontruksi"
                                                    value="<?php echo e($mgambar->foto_kontruksi); ?>">

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

                                            
                                            <div class="form-group border p-3 rounded" style="background-color: #f7f9fc;">
                                                <label for="foto_optional" class="text-success">
                                                    <i class="fas fa-search-plus"></i> Gambar Detail
                                                    <?php if($mgambar->foto_optional): ?>
                                                        <span class="badge badge-success ml-1">TERSEDIA</span>
                                                    <?php endif; ?>
                                                </label>

                                                <div class="current-image-preview mb-2" id="current_preview_detail">
                                                    <?php if($mgambar->foto_optional): ?>
                                                        <img src="<?php echo e(asset('storage/body/' . $mgambar->foto_optional)); ?>"
                                                            class="img-thumbnail border border-secondary"
                                                            style="max-width: 150px; height: auto; cursor:pointer;"
                                                            onclick="$('#imgPreviewModal').attr('src', this.src); $('#modalPreview').modal('show');">
                                                        <p class="text-muted small mt-1">Gambar saat ini (disimpan)</p>
                                                    <?php else: ?>
                                                        <p class="text-muted small mt-1">Belum ada gambar detail.</p>
                                                    <?php endif; ?>
                                                </div>

                                                
                                                <input type="hidden" name="old_foto_optional"
                                                    value="<?php echo e($mgambar->foto_optional); ?>">

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

                                                
                                                <div class="preview mt-2" id="preview_detail"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <a href="<?php echo e(route('index.mgambar')); ?>"
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CODING\SIREGAR\resources\views/admin/mgambar/edit_mgambar.blade.php ENDPATH**/ ?>