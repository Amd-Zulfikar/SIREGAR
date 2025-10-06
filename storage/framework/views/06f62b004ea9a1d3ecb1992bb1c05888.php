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

                <form method="POST" action="<?php echo e(route('store.mgambar')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Salin Gambar Body (Data Baru)</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Pilih Data</label>

                                                <select name="mdata_id"
                                                    class="form-control select2 <?php $__errorArgs = ['mdata_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    required>
                                                    <option selected disabled>Pilih Data</option>
                                                    <?php $__currentLoopData = $mdatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($mdata->id); ?>"
                                                            <?php echo e($mgambar->mdata_id == $mdata->id ? 'selected' : ''); ?>>
                                                            <?php echo e($mdata->engine->name ?? '-'); ?> -
                                                            <?php echo e($mdata->brand->name ?? '-'); ?> -
                                                            <?php echo e($mdata->chassis->name ?? '-'); ?> -
                                                            <?php echo e($mdata->vehicle->name ?? '-'); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <small class="text-danger"><?php echo e($errors->first('mdata_id')); ?></small>
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Body</label>

                                                <input name="keterangan" type="text" class="form-control"
                                                    value="<?php echo e(old('keterangan', $mgambar->keterangan)); ?>" required>
                                                <small class="text-danger"><?php echo e($errors->first('keterangan')); ?></small>
                                            </div>
                                        </div>

                                        <!-- Upload & Preview -->
                                        <div class="col-sm-6">
                                            <!-- Upload Gambar Baru -->
                                            <div class="form-group">
                                                <label>Upload Foto Body Baru</label>
                                                <div class="custom-file">
                                                    <input type="file" name="foto_body[]" id="foto_body"
                                                        class="custom-file-input" multiple>
                                                    <label class="custom-file-label" for="foto_body">Choose files</label>
                                                </div>
                                                <small class="text-muted">Gambar lama tidak akan tersimpan. Silakan upload
                                                    jika ingin menggunakan gambar
                                                    baru.</small>
                                            </div>

                                            <!-- Preview Gambar Baru -->
                                            <div class="form-group">
                                                <label>Preview Gambar Baru</label>
                                                <div id="newPreviewContainer" class="d-flex flex-wrap mb-2"></div>
                                            </div>

                                            <div class="form-group">
                                                <label>Preview Foto Lama (Tidak Tersimpan)</label>
                                                <div id="oldPreviewContainer" class="d-flex flex-wrap">
                                                    <?php if($mgambar->foto_body): ?>
                                                        <?php $__currentLoopData = $mgambar->foto_body; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="position-relative m-1 old-image-wrapper">
                                                                <img src="<?php echo e(asset('storage/body/' . $file)); ?>"
                                                                    class="img-thumbnail old-preview-img"
                                                                    style="width:80px; height:80px; object-fit:cover; cursor:pointer;"
                                                                    data-src="<?php echo e(asset('storage/body/' . $file)); ?>">
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <span>Tidak ada file</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <a href="<?php echo e(route('index.mgambar')); ?>" class="btn btn-outline-danger">Kembali</a>
                                    <input type="submit" value="Copy & Paste" class="btn btn-outline-success">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Modal Preview Gambar -->
        <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <img src="" id="imgPreviewModal" class="img-fluid w-100">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            if (typeof bsCustomFileInput !== 'undefined') bsCustomFileInput.init();

            // Preview gambar lama modal
            $('#oldPreviewContainer').off('click', '.old-preview-img').on('click', '.old-preview-img', function() {
                $('#imgPreviewModal').attr('src', $(this).data('src'));
                $('#modalPreview').modal('show');
            });

            // Hapus gambar lama client-side dan input hidden
            $('#oldPreviewContainer').off('click', '.remove-old-img-btn').on('click', '.remove-old-img-btn',
                function() {
                    $(this).closest('.old-image-wrapper').remove();
                });

            // Preview gambar baru
            $('#foto_body').on('change', function() {
                let files = this.files;
                $('#newPreviewContainer').empty(); // hapus preview lama

                // Perbarui label custom file
                let fileNames = [];
                for (let i = 0; i < files.length; i++) {
                    fileNames.push(files[i].name);
                }
                $(this).next('.custom-file-label').html(fileNames.join(', ') || 'Choose files');

                for (let i = 0; i < files.length; i++) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let img = $('<img>')
                            .attr('src', e.target.result)
                            .addClass('img-thumbnail new-preview-img m-1')
                            .css({
                                'width': '80px',
                                'height': '80px',
                                'object-fit': 'cover',
                                'cursor': 'pointer'
                            });
                        $('#newPreviewContainer').append(img);

                        // Klik preview modal
                        img.off('click').on('click', function() {
                            $('#imgPreviewModal').attr('src', $(this).attr('src'));
                            $('#modalPreview').modal('show');
                        });
                    }
                    reader.readAsDataURL(files[i]);
                }
            });

            // Toastr untuk flash session
            var successMessage = "<?php echo e(session('success') ?? ''); ?>";
            var errorMessage = "<?php echo e(session('error') ?? ''); ?>";

            if (successMessage) toastr.success(successMessage);
            if (errorMessage) toastr.error(errorMessage);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CODING\SIREGAR\resources\views\admin\mgambar\copy_mgambar.blade.php ENDPATH**/ ?>