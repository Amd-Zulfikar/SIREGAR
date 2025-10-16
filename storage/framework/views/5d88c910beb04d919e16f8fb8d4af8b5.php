<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account</li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="<?php echo e(route('update.account', [$account->id])); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Account</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Nama Pengguna</label>
                                                <input name="name" type="text" value="<?php echo e($account->name); ?>"
                                                    class="form-control" placeholder="Masukan Nama Pengguna" required>
                                                <small><?php echo e($errors->first('name')); ?></small>
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Role</label>
                                                <select name="roles" id="roles" class="form-control select2"
                                                    style="width: 100%;">
                                                    <option selected disabled>Pilih Role</option>
                                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($role->id); ?>"
                                                            <?php echo e($account->role_id == $role->id ? 'selected' : ''); ?>>
                                                            <?php echo e($role->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <small><?php echo e($errors->first('roles')); ?></small>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input name="email" type="email"
                                                    value="<?php echo e(old('email', $account->email)); ?>" class="form-control"
                                                    placeholder="Masukan Email">
                                                <small><?php echo e($errors->first('email')); ?></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Password</label>
                                                <input name="password" type="password" value="" class="form-control"
                                                    placeholder="********">
                                                <small><?php echo e($errors->first('password')); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer me-2">
                                    <a href="<?php echo e(route('index.account')); ?>" class="btn btn-outline-danger">Kembali</a>
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
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\02. ZULFIKAR\CODING\REKAYASA\SIREGAR\resources\views\admin\account\edit_account.blade.php ENDPATH**/ ?>