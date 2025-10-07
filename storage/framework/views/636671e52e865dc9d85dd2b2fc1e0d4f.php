<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <br>
        <div class="content">
            <div class="container-fluid">
                <div class="col-12 col-sm-12">
                    <div>
                        <a href="<?php echo e(route('index.workspace')); ?>" class="btn btn-outline-primary"><i
                                class="fa-solid fa-circle-left"></i> Kembali</a>
                    </div>
                    <br>
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                        href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                        aria-selected="true">Detail Transaksi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                        href="#custom-tabs-four-profile" role="tab"
                                        aria-controls="custom-tabs-four-profile" aria-selected="false">Detail Gambar</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <!-- Tab Detail Transaksi -->
                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-home-tab">
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-striped table-valign-middle">
                                            <thead>
                                                <tr>
                                                    <th>No Transaksi</th>
                                                    <th>Gambar</th>
                                                    <th>Pengajuan</th>
                                                    <th>Tanggal Pengerjaan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $workspace->workspaceGambar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($workspace->no_transaksi ?? '-'); ?></td>
                                                        <td>
                                                            <?php echo e($g->brandModel ? $g->brandModel->name : '-'); ?>

                                                            <?php echo e($g->chassisModel ? ' ' . $g->chassisModel->name : ''); ?>

                                                            <?php echo e($g->vehicleModel ? ' ' . $g->vehicleModel->name : ''); ?>

                                                            <?php echo e($g->keteranganModel ? ' - ' . $g->keteranganModel->keterangan : ''); ?>

                                                        </td>
                                                        <td><?php echo e($workspace->submission->name ?? '-'); ?></td>
                                                        <td><?php echo e($workspace->created_at->format('d/m/Y')); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-profile-tab">

                                    <?php

                                        if (is_null($images)) {
                                            $imagesArr = [];
                                        } elseif (is_array($images)) {
                                            $imagesArr = array_values($images);
                                        } elseif ($images instanceof \Illuminate\Support\Collection) {
                                            $imagesArr = $images->values()->all();
                                        } else {
                                            $imagesArr = is_iterable($images)
                                                ? iterator_to_array($images)
                                                : (array) $images;
                                            $imagesArr = array_values($imagesArr);
                                        }

                                        $total = count($imagesArr);
                                    ?>

                                    <div class="container-fluid">
                                        <?php if($total === 0): ?>
                                            <div class="text-muted">Tidak ada gambar.</div>
                                        <?php else: ?>
                                            <div class="row">

                                                <div class="col-12 d-flex flex-column align-items-center">
                                                    <?php $__currentLoopData = $imagesArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="mb-3 w-75 w-md-50 d-flex justify-content-center">
                                                            <img src="<?php echo e(asset($imagePath)); ?>" class="img-fluid overlay-img"
                                                                data-preview="<?php echo e(asset($imagePath)); ?>" alt="Overlay Image">
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                        <a href="<?php echo e(route('export.overlay.workspace', $workspace->id)); ?>" target="_blank"
                                            class="btn btn-danger">
                                            <i class="fa-solid fa-file-pdf"></i>Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview -->
    <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 text-center">
                    <img src="" id="imgPreviewModal" class="img-fluid" alt="Preview">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .overlay-img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            cursor: pointer;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 3px;
            background: #fff;
            transition: transform .15s ease;
        }

        .overlay-img:hover {
            transform: scale(1.03);
        }

        /* Responsif ukuran gambar */
        @media (max-width: 768px) {
            .overlay-img {
                width: 120px;
                height: 120px;
            }
        }

        @media (max-width: 576px) {
            .overlay-img {
                width: 100px;
                height: 100px;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(function() {
            $(document).on('click', '.overlay-img', function() {
                const src = $(this).data('preview') || $(this).attr('src');
                if (!src) return;
                $('#imgPreviewModal').attr('src', src);
                $('#modalPreview').modal('show');
            });

            $('#modalPreview').on('hidden.bs.modal', function() {
                $('#imgPreviewModal').attr('src', '');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('drafter.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\02. ZULFIKAR\CODING\REKAYASA\SIREGAR\resources\views\drafter\workspace\overlay_preview.blade.php ENDPATH**/ ?>