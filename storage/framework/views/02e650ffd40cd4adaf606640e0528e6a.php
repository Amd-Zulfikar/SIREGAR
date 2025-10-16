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
                <form method="POST" action="<?php echo e(route('store.mgambarelectricity')); ?>" enctype="multipart/form-data">
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
                                                            <?php echo e($mdata->brand->name ?? '-'); ?>

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


                                        </div>

                                        <div class="col-sm-6">
                                            <div id="gambar-kelistrikan-container">
                                                <div class="form-group border p-3 rounded mb-3"
                                                    style="background-color: #f7f9fc;">
                                                    <label class="text-info"><i class="fas fa-image"></i> Gambar
                                                        kelistrikan</label>
                                                    <div class="input-group mb-2">
                                                        <input type="text"
                                                            class="form-control form-control-sm file-name-display"
                                                            value="Belum ada file dipilih" readonly>
                                                        <div class="input-group-append">
                                                            <label class="btn btn-sm btn-info mb-0">
                                                                Upload Gambar
                                                                <input type="file" name="foto_kelistrikan[]"
                                                                    class="foto_kelistrikan" style="display: none;"
                                                                    accept="image/*" onchange="updateFileName(this)">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="preview mt-2"></div>

                                                    <input name="description[]" type="text"
                                                        class="form-control form-control-sm mt-2"
                                                        placeholder="Contoh: kelistrikan PENGIKAT KURSI DLL" required>
                                                </div>
                                            </div>

                                            <!-- Tombol tambah gambar -->
                                            <button type="button" id="add-gambar" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus"></i> Tambah
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer me-2">
                                    <a href="<?php echo e(route('index.mgambarelectricity')); ?>"
                                        class="btn btn-outline-danger">Kembali</a>
                                    <input type="submit" value="Simpan Data Gambar" class="btn btn-outline-success">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

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
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(function() {
            $('.select2').select2();

            // Tambah field gambar baru
            $('#add-gambar').on('click', function() {
                const newField = `
                <div class="form-group border p-3 rounded mb-3" style="background-color: #f7f9fc;">
                    <label class="text-info"><i class="fas fa-image"></i> Gambar kelistrikan</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control form-control-sm file-name-display" value="Belum ada file dipilih" readonly>
                        <div class="input-group-append">
                            <label class="btn btn-sm btn-info mb-0">
                                Upload Gambar
                                <input type="file" name="foto_kelistrikan[]" class="foto_kelistrikan" style="display: none;" accept="image/*" onchange="updateFileName(this)">
                            </label>
                        </div>
                    </div>
                    <div class="preview mt-2"></div>
                    <input name="description[]" type="text"
                        class="form-control form-control-sm mt-2"
                        placeholder="Contoh: kelistrikan PENGIKAT KURSI DLL" required>

                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-gambar">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
                $('#gambar-kelistrikan-container').append(newField);
            });

            // Hapus field gambar
            $(document).on('click', '.remove-gambar', function() {
                $(this).closest('.form-group').remove();
            });
        });

        // Fungsi preview
        function updateFileName(input) {
            const fileNameInput = $(input).closest('.input-group').find('.file-name-display');
            const previewContainer = $(input).closest('.form-group').find('.preview');
            previewContainer.html('');

            if (input.files.length > 0) {
                const file = input.files[0];
                fileNameInput.val(file.name);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = $('<img src="' + e.target.result +
                        '" class="img-thumbnail" style="max-width: 150px; height: auto; cursor:pointer;" alt="Preview Gambar">'
                    );
                    img.on('click', function() {
                        $('#imgPreviewModal').attr('src', e.target.result);
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

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\02. ZULFIKAR\CODING\REKAYASA\SIREGAR\resources\views\admin\mgambar_electricity\add_mgambar_electricity.blade.php ENDPATH**/ ?>