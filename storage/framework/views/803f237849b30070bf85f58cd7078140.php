<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Master Data</li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="<?php echo e(route('store.mdata')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Data</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Pilih Engine</label>
                                                <select name="engines" id="engines" class="form-control select2"
                                                    style="width: 100%;">
                                                    <option selected disabled>Pilih Engine</option>
                                                    <?php $__currentLoopData = $engines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $engine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($engine->id); ?>"
                                                            <?php echo e($mdata->engine_id == $engine->id ? 'selected' : ''); ?>>
                                                            <?php echo e($engine->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <small><?php echo e($errors->first('engines')); ?></small>
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Merk</label>
                                                <select name="brands" id="brands" class="form-control select2"
                                                    style="width: 100%;">
                                                    <option selected disabled>Pilih Merk</option>
                                                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($brand->id); ?>"
                                                            <?php echo e($mdata->brand_id == $brand->id ? 'selected' : ''); ?>>
                                                            <?php echo e($brand->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <small><?php echo e($errors->first('brands')); ?></small>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label>Pilih Chassis</label>
                                                <select name="chassiss" id="chassiss" class="form-control select2"
                                                    style="width: 100%;">
                                                    <option selected disabled>Pilih Chassis</option>
                                                    <?php $__currentLoopData = $chassiss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chassis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($chassis->id); ?>"
                                                            <?php echo e($mdata->chassis_id == $chassis->id ? 'selected' : ''); ?>>
                                                            <?php echo e($chassis->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <small><?php echo e($errors->first('chassiss')); ?></small>
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Jenis Kendaraan</label>
                                                <select name="vehicles" id="vehicles" class="form-control select2"
                                                    style="width: 100%;">
                                                    <option selected disabled>Pilih Jenis Kendaraan</option>
                                                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($vehicle->id); ?>"
                                                            <?php echo e($mdata->vehicle_id == $vehicle->id ? 'selected' : ''); ?>>
                                                            <?php echo e($vehicle->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <small><?php echo e($errors->first('vehicles')); ?></small>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer me-2">
                                    <a href="<?php echo e(route('index.mdata')); ?>" class="btn btn-outline-danger">Kembali</a>
                                    <input type="submit" value="Simpan" class="btn btn-outline-success">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
        })

        // Toastr untuk flash session
        var successMessage = "<?php echo e(session('success') ?? ''); ?>";
        var errorMessage = "<?php echo e(session('error') ?? ''); ?>";

        if (successMessage) toastr.success(successMessage);
        if (errorMessage) toastr.error(errorMessage);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\02. ZULFIKAR\CODING\colaborasi\SIREGAR\resources\views\admin\mdata\copy_mdata.blade.php ENDPATH**/ ?>