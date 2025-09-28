<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <a type="button" class="btn btn-block bg-gradient-primary"
                                onclick="location.href='<?php echo e(route('add.role')); ?>'">Tambah Data</a>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Role</li>
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
                                    <i class="fas fa-edit"></i>
                                    Data Role
                                </h3>
                            </div>
                            <!-- card -->
                            <div class="card-body pad table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <td>
                                                    <?php echo e($role->name); ?>

                                                </td>
                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="<?php echo e(route('edit.role', $role->id)); ?>">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Edit
                                                    </a>
                                                </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td>Data Note Found!</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!-- Laravel Pagination -->
                                <div class="mt-2">
                                    <?php echo e($roles->links('pagination::bootstrap-4')); ?>

                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- ./row -->
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

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CODING\REKAYASA\SIREGAR\resources\views\admin\role\index.blade.php ENDPATH**/ ?>