<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <a type="button" class="btn btn-block btn-outline-primary"
                                onclick="location.href='<?php echo e(route('add.mgambar')); ?>'">Tambah Data</a>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Master Gambar</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-edit"></i> Gambar Master</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Engine</th>
                                            <th>Merk</th>
                                            <th>Chassis</th>
                                            <th>Vehicle</th>
                                            <th>Jenis Body</th>
                                            <th>Gambar Body</th> 
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $mgambars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mgambar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($mgambar->mdata->engine->name ?? '-'); ?></td>
                                                <td><?php echo e($mgambar->mdata->brand->name ?? '-'); ?></td>
                                                <td><?php echo e($mgambar->mdata->chassis->name ?? '-'); ?></td>
                                                <td><?php echo e($mgambar->mdata->vehicle->name ?? '-'); ?></td>
                                                <td><?php echo e($mgambar->keterangan); ?></td>

                                                <td>
                                                    <div style="display:flex; flex-wrap: wrap; gap: 5px;">

                                                        
                                                        <?php
                                                            $imageFields = [
                                                                'Utama' => $mgambar->foto_utama
                                                                    ? asset('storage/body/' . $mgambar->foto_utama)
                                                                    : null,
                                                                'Terurai' => $mgambar->foto_terurai
                                                                    ? asset('storage/body/' . $mgambar->foto_terurai)
                                                                    : null,
                                                                'Konstruksi' => $mgambar->foto_kontruksi
                                                                    ? asset('storage/body/' . $mgambar->foto_kontruksi)
                                                                    : null,
                                                                'Optional' => $mgambar->foto_optional
                                                                    ? asset('storage/body/' . $mgambar->foto_optional)
                                                                    : null,
                                                            ];
                                                            $hasImage = false;
                                                        ?>

                                                        <?php $__currentLoopData = $imageFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title => $src): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($src): ?>
                                                                <?php $hasImage = true; ?>
                                                                <img src="<?php echo e($src); ?>"
                                                                    alt="Gambar <?php echo e($title); ?>"
                                                                    title="Gambar <?php echo e($title); ?>"
                                                                    class="img-thumbnail preview-img"
                                                                    style="width:80px; height: 80px; object-fit: cover; cursor:pointer; border: 2px solid #3c8dbc;"
                                                                    data-src="<?php echo e($src); ?>">
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        
                                                        <?php
                                                            $optionalImages = json_decode(
                                                                $mgambar->foto_optional,
                                                                true,
                                                            );
                                                        ?>

                                                        <?php if(is_array($optionalImages)): ?>
                                                            <?php $__currentLoopData = $optionalImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optional): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $optionalSrc = asset(
                                                                        'storage/body/optional/' .
                                                                            $optional['filename'],
                                                                    );
                                                                    $optionalTitle =
                                                                        $optional['name'] ?? 'Optional Image';
                                                                    $hasImage = true;
                                                                ?>
                                                                <img src="<?php echo e($optionalSrc); ?>" alt="<?php echo e($optionalTitle); ?>"
                                                                    title="Optional: <?php echo e($optionalTitle); ?>"
                                                                    class="img-thumbnail preview-img"
                                                                    style="width:80px; height: 80px; object-fit: cover; cursor:pointer; border: 2px solid #5cb85c;"
                                                                    data-src="<?php echo e($optionalSrc); ?>">
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>

                                                        <?php if(!$hasImage): ?>
                                                            <span class="text-muted">No Image</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                

                                                <td>
                                                    <a class="btn btn-light btn-sm"
                                                        href="<?php echo e(route('copy.mgambar', $mgambar->id)); ?>">
                                                        <i class="fa-solid fa-copy"></i> Copas
                                                    </a>
                                                    <a class="btn btn-info btn-sm"
                                                        href="<?php echo e(route('edit.mgambar', $mgambar->id)); ?>">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                        data-url="<?php echo e(route('delete.mgambar', $mgambar->id)); ?>">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">Data Gambar Kosong. Silakan Tambah
                                                    Data Baru.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Engine</th>
                                            <th>Merk</th>
                                            <th>Chassis</th>
                                            <th>Vehicle</th>
                                            <th>Jenis Body</th>
                                            <th>Gambar Body</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Preview -->
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
            // Preview gambar
            $(document).on('click', '.preview-img', function() {
                $('#imgPreviewModal').attr('src', $(this).data('src'));
                $('#modalPreview').modal('show');
            });

            $('.btn-delete').click(function(e) {
                e.preventDefault();
                let url = $(this).data('url');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus dan tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });

            // Toastr untuk flash session
            var successMessage = "<?php echo e(session('success') ?? ''); ?>";
            var errorMessage = "<?php echo e(session('error') ?? ''); ?>";

            if (successMessage) toastr.success(successMessage);
            if (errorMessage) toastr.error(errorMessage);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\02. ZULFIKAR\CODING\REKAYASA\SIREGAR\resources\views/admin/mgambar/index.blade.php ENDPATH**/ ?>