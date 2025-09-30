<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Overlay PDF Single</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
        }

        img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <img src="<?php echo e($image); ?>" alt="Overlayed Image">
</body>

</html>
<?php /**PATH D:\02. ZULFIKAR\CODING\colaborasi\SIREGAR\resources\views\drafter\workspace\overlay_pdf.blade.php ENDPATH**/ ?>