<?php
    $text = '';
    $type_index = 0;
    
    if ($type == 'utama') {
        $text = 'Utama'; 
        $type_index = 0; // Index 0
    } elseif ($type == 'terurai') {
        $text = 'Terurai'; 
        $type_index = 1; // Index 1
    } elseif ($type == 'kontruksi') {
        $text = 'Konstruksi'; 
        $type_index = 2; // Index 2
    }
?>

<div class="row form-group align-items-center">
    <div class="col-md-2">
        <label class="col-form-label-sm">Gambar <?php echo e($text); ?> <?php echo e($index); ?>:</label>
    </div>
    <div class="col-md-2">
        
        <select name="rincian[<?php echo e($type); ?>][<?php echo e($index); ?>][varian_id]" class="form-control form-control-sm select2-sm" required>
            <option selected disabled>Pilih Varian</option>
            <?php $__currentLoopData = $varians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($v->id); ?>"><?php echo e($v->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-md-4">
        
        <select name="rincian[<?php echo e($type); ?>][<?php echo e($index); ?>][keterangan_id]" class="form-control form-control-sm select2-sm gambar-keterangan" required disabled>
            <option selected disabled>Pilih Jenis Body</option>
        </select>
    </div>
    <div class="col-md-2">
        
        <input type="number" 
               name="rincian[<?php echo e($type); ?>][<?php echo e($index); ?>][jumlah_gambar]" 
               class="form-control form-control-sm jumlah-gambar" 
               placeholder="Jml. Gbr" 
               value="1" 
               readonly 
               required>
    </div>
    <div class="col-md-1">
        
        <input type="text" 
               name="rincian[<?php echo e($type); ?>][<?php echo e($index); ?>][halaman_gambar]" 
               class="form-control form-control-sm halaman-gambar-input" 
               placeholder="Hal" 
               data-type="<?php echo e($type); ?>"
               data-index-baris="<?php echo e($index); ?>"
               data-type-index="<?php echo e($type_index); ?>"
               readonly 
               required>
    </div>
    <div class="col-md-1 text-right">
        <button type="button" class="btn btn-sm btn-info preview-gambar-btn" data-type="<?php echo e($type); ?>" data-index="<?php echo e($index); ?>" disabled>Preview</button>
    </div>
</div><?php /**PATH D:\CODING\SIREGAR\resources\views\drafter\workspace\gambar_item.blade.php ENDPATH**/ ?>