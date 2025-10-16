<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Pemeriksa</li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="<?php echo e(route('update.pemeriksa', [$pemeriksa->id])); ?>"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Pemeriksa</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Form Input -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Nama Pemeriksa</label>
                                                <input name="name" type="text"
                                                    value="<?php echo e(old('name', $pemeriksa->name)); ?>" class="form-control"
                                                    placeholder="Masukan Nama Pemeriksa" required>
                                                <small class="text-danger"><?php echo e($errors->first('name')); ?></small>
                                            </div>
                                        </div>

                                        <!-- Upload & Preview -->
                                        <div class="col-sm-6">
                                            <!-- Upload Gambar Baru -->
                                            <div class="form-group">
                                                <label for="foto_paraf">Upload Gambar Paraf</label>
                                                <div class="custom-file">
                                                    <input type="file" name="foto_paraf[]" id="foto_paraf"
                                                        class="custom-file-input" multiple>
                                                    <label class="custom-file-label" for="foto_paraf">Choose files</label>
                                                </div>
                                                <small class="text-muted">Biarkan kosong jika tidak ingin menambahkan foto
                                                    baru.</small>
                                            </div>

                                            <!-- Preview Gambar Baru -->
                                            <div class="form-group">
                                                <label>Preview Paraf Baru</label>
                                                <div id="newPreviewContainer" class="d-flex flex-wrap mb-2"></div>
                                            </div>

                                            <!-- Gambar Lama dengan Tombol Hapus -->
                                            <div class="form-group">
                                                <label>Preview Paraf Lama</label>
                                                <div id="oldPreviewContainer" class="d-flex flex-wrap">
                                                    <?php if($pemeriksa->foto_paraf): ?>
                                                        <?php $files = json_decode($pemeriksa->foto_paraf, true); ?>
                                                        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="position-relative m-1 old-image-wrapper">
                                                                <img src="<?php echo e(asset('storage/paraf/' . $file)); ?>"
                                                                    class="img-thumbnail old-preview-img"
                                                                    style="width:80px; height:80px; object-fit:cover; cursor:pointer;"
                                                                    data-src="<?php echo e(asset('storage/paraf/' . $file)); ?>">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-old-img-btn"
                                                                    data-filename="<?php echo e($file); ?>">
                                                                    &times;
                                                                </button>
                                                                <input type="hidden" name="existing_files[]"
                                                                    value="<?php echo e($file); ?>">
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
                                    <a href="<?php echo e(route('index.pemeriksa')); ?>" class="btn btn-outline-danger">Kembali</a>
                                    <input type="submit" value="Simpan" class="btn btn-outline-success">
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
            $('#foto_paraf').on('change', function() {
                let files = this.files;
                $('#newPreviewContainer').empty(); // hapus preview lama
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
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\02. ZULFIKAR\CODING\REKAYASA\SIREGAR\resources\views\admin\pemeriksa\edit_pemeriksa.blade.php ENDPATH**/ ?>