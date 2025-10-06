<!DOCTYPE html>
<html>

<head>
    <title>Workspace Overlay PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .image-container {
            page-break-after: always;
            text-align: center;
            margin-bottom: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>

    <h2>Workspace No: <?php echo e($workspace->no_transaksi); ?></h2>
    <p>Customer: <?php echo e($workspace->customer->name ?? '-'); ?></p>
    <p>Drafter: <?php echo e($workspace->employee->name ?? '-'); ?></p>
    <p>Varian: <?php echo e($workspace->varian->name ?? '-'); ?></p>
    <p>Tanggal: <?php echo e($workspace->created_at->format('d-m-Y')); ?></p>

    <?php $__currentLoopData = $overlayedImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="image-container">
            <img src="<?php echo e($image); ?>" alt="Overlay Image">
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>

</html>
<?php /**PATH D:\CODING\SIREGAR\resources\views\drafter\workspace\print.blade.php ENDPATH**/ ?>