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
                                                    <?php
                                                        $foto_fields = [
                                                            'foto_utama' => $mgambar->foto_utama,
                                                            'foto_terurai' => $mgambar->foto_terurai,
                                                            'foto_kontruksi' => $mgambar->foto_kontruksi,
                                                            'foto_optional' => $mgambar->foto_optional,
                                                        ];
                                                        $hasImage = false;
                                                    ?>

                                                    <div style="display:flex; flex-wrap: wrap; gap: 5px;">
                                                        <?php $__currentLoopData = $foto_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $file_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($file_name): ?>
                                                                <?php $hasImage = true; ?>
                                                                <img src="<?php echo e(asset('storage/body/' . $file_name)); ?>"
                                                                    alt="<?php echo e(ucfirst($type)); ?>"
                                                                    title="Gambar <?php echo e(ucfirst($type)); ?>"
                                                                    class="img-thumbnail preview-img"
                                                                    style="width:80px; height: 80px; object-fit: cover; cursor:pointer;"
                                                                    data-src="<?php echo e(asset('storage/body/' . $file_name)); ?>">
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        <?php if(!$hasImage): ?>
                                                            <span class="text-muted">No Image</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>

                                                <td>
                                                    
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

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CODING\SIREGAR\resources\views/admin/mgambar/index.blade.php ENDPATH**/ ?>