{{-- resources/views/admin/workspace/print.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Workspace {{ $workspace->id }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .image {
            margin-bottom: 20px;
            text-align: center;
        }

        .image img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <h2>Workspace #{{ $workspace->id }}</h2>
    <p>Customer: {{ $workspace->customer->name ?? '-' }}</p>
    <p>Employee: {{ $workspace->employee->name ?? '-' }}</p>

    <hr>

    @foreach ($overlayedImages as $img)
        <div class="image">
            <img src="{{ public_path('storage/temp/' . $img) }}" alt="Overlay Image">
        </div>
    @endforeach
</body>

</html>
