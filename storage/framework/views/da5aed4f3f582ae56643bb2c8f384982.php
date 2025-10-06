<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <a type="button" class="btn btn-block bg-gradient-primary" onclick="location.href='#'">Tambah
                                Transaksi</a>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Transaksi</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-list"></i>
                                    Data Transaksi
                                </h3>
                            </div>
                            <!-- card -->
                            <div class="card-body pad table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No.Order</th>
                                            <th>Customer</th>
                                            <th>No.Kementrian</th>
                                            <th>Status Kementrian</th>
                                            <th>Status Internal</th>
                                            <th>Prioritas</th>
                                            <th>Chassis</th>
                                            <th>Tipe Kendaraan</th>
                                            <th>Drafter</th>
                                            <th>Checker</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Tanggal Order</th>
                                            <th>Lama Pengerjaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($index + 1); ?></td>
                                                <td>RKS-<?php echo e(str_pad($transaction->id, 6, '0', STR_PAD_LEFT)); ?></td>
                                                <td><?php echo e($transaction->customer->name ?? '-'); ?></td>
                                                <td><?php echo e($transaction->nomor_kementrian ?? '-'); ?></td>
                                                <td><?php echo e($transaction->status_kementrian ?? '-'); ?></td>
                                                <td><?php echo e($transaction->status_internal ?? '-'); ?></td>
                                                <td><?php echo e($transaction->prioritas ?? '-'); ?></td>
                                                <td><?php echo e($transaction->chassis->name ?? '-'); ?></td>
                                                <td><?php echo e($transaction->vehicle->name ?? '-'); ?></td>
                                                <td><?php echo e($transaction->drafter->name ?? '-'); ?></td>
                                                <td><?php echo e($transaction->checker->name ?? '-'); ?></td>
                                                <td><?php echo e($transaction->submission->name ?? '-'); ?></td>
                                                <td><?php echo e($transaction->created_at->format('d-m-Y')); ?></td>
                                                <td>
                                                    <?php if($transaction->updated_at): ?>
                                                        <?php echo e($transaction->updated_at->diffInDays($transaction->created_at)); ?>

                                                        Hari
                                                    <?php else: ?>
                                                        0
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="14" class="text-center">Data Not Found!</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>No.Order</th>
                                            <th>Customer</th>
                                            <th>No.Kementrian</th>
                                            <th>Status Kementrian</th>
                                            <th>Status Internal</th>
                                            <th>Prioritas</th>
                                            <th>Chassis</th>
                                            <th>Tipe Kendaraan</th>
                                            <th>Drafter</th>
                                            <th>Checker</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Tanggal Order</th>
                                            <th>Lama Pengerjaan</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            // Toastr untuk flash session
            var successMessage = "<?php echo e(session('success') ?? ''); ?>";
            var errorMessage = "<?php echo e(session('error') ?? ''); ?>";

            if (successMessage) toastr.success(successMessage);
            if (errorMessage) toastr.error(errorMessage);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CODING\SIREGAR\resources\views/admin/transaction/index.blade.php ENDPATH**/ ?>