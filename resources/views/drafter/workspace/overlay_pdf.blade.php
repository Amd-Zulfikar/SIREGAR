<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Workspace PDF</title>
    <style>
        .page {
            page-break-after: always;
            text-align: center;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <h4>Workspace: {{ $workspace->no_transaksi ?? $workspace->id }}</h4>
    @foreach ($overlayedImages as $img)
        <div class="page">
            <img src="{{ $img }}" alt="Overlay">
        </div>
    @endforeach
</body>

</html>
