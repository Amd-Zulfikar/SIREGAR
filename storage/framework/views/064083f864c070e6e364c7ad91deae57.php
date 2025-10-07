<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <!-- <h1>General Form</h1> -->
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Jenis Pengajuan</li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="<?php echo e(route('update.submission', ['id' => $submission->id])); ?>"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Jenis Pengajuan</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Nama Pengajuan</label>
                                                <input name="name" type="text" value="<?php echo e($submission->name); ?>"
                                                    class="form-control" placeholder="Masukan Nama Pengajuan" required>
                                                <small><?php echo e($errors->first('name')); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer me-2">
                                    <a href="<?php echo e(route('index.submission')); ?>" class="btn btn-outline-danger">Kembali</a>
                                    <input type="submit" value="Update" class="btn btn-outline-success">
                                </div>
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CODING\SIREGAR\resources\views/admin/submission/edit_submission.blade.php ENDPATH**/ ?>