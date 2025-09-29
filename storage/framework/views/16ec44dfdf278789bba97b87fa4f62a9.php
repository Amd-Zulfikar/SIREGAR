<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <a type="button" class="btn btn-block btn-outline-primary"
                                onclick="location.href='<?php echo e(route('add.customer')); ?>'">Tambah Data</a>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Customer</li>
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
                                <h3 class="card-title"><i class="fas fa-edit"></i> Data Customer</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Perusahaan</th>
                                            <th>Nama Direktur</th>
                                            <th>Paraf</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($customer->name); ?></td>
                                                <td><?php echo e($customer->direktur); ?></td>
                                                <td>
                                                    <?php if($customer->foto_paraf): ?>
                                                        <?php $files = json_decode($customer->foto_paraf, true); ?>
                                                        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <img src="<?php echo e(asset('storage/paraf/' . $file)); ?>"
                                                                style="width:50px; height:50px; object-fit:cover; cursor:pointer;"
                                                                class="img-thumbnail preview-img"
                                                                data-src="<?php echo e(asset('storage/paraf/' . $file)); ?>">
                                                            <!-- MODIFIED -->
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <span>Tidak ada file</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="status-switch"
                                                        data-id="<?php echo e($customer->id); ?>" name="status"
                                                        <?php echo e($customer->status ? 'checked' : ''); ?> data-bootstrap-switch
                                                        data-off-color="danger" data-on-color="success">
                                                </td>
                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="<?php echo e(route('edit.customer', $customer->id)); ?>">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>

                                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                        data-url="<?php echo e(route('delete.customer', $customer->id)); ?>">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="5">Data Not Found!</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nama Perusahaan</th>
                                            <th>Nama Direktur</th>
                                            <th>Paraf</th>
                                            <th>Status</th>
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
        <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true"> <!-- MODIFIED -->
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
            $('.preview-img').on('click', function() {
                $('#imgPreviewModal').attr('src', $(this).data('src'));
                $('#modalPreview').modal('show');
            });

            // 🔥 Inisialisasi bootstrapSwitch
            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });

            // 🔥 Event ON/OFF
            $(document).on('switchChange.bootstrapSwitch', '.status-switch', function(event, state) {
                let id = $(this).data('id');
                let newStatus = state ? 1 : 0;

                $.ajax({
                    url: "<?php echo e(url('admin/customer/action')); ?>/" + id,
                    method: "POST",
                    data: {
                        status: newStatus,
                        _token: "<?php echo e(csrf_token()); ?>"
                    },
                    success: function(res) {
                        if (res.success) {
                            console.log("Status updated:", res.status);
                        }
                    },
                    error: function(xhr) {
                        alert("Gagal update status! (" + xhr.status + ")");
                    }
                });
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

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CODING\REKAYASA\SIREGAR\resources\views/admin/customer/index.blade.php ENDPATH**/ ?>