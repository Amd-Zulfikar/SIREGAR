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

    <h2>Workspace No: {{ $workspace->no_transaksi }}</h2>
    <p>Customer: {{ $workspace->customer->name ?? '-' }}</p>
    <p>Drafter: {{ $workspace->employee->name ?? '-' }}</p>
    <p>Varian: {{ $workspace->varian->name ?? '-' }}</p>
    <p>Tanggal: {{ $workspace->created_at->format('d-m-Y') }}</p>

    @foreach ($overlayedImages as $image)
        <div class="image-container">
            <img src="{{ $image }}" alt="Overlay Image">
        </div>
    @endforeach

</body>

</html>
