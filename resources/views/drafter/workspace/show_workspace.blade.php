@extends('drafter.layouts.app')

@section('content')

    <div class="container mt-4">
        <h3>Preview Workspace #{{ $workspace->id }}</h3>
        <p><strong>Customer:</strong> {{ $workspace->customer->name ?? '-' }}</p>
        <p><strong>Employee:</strong> {{ $workspace->employee->name ?? '-' }}</p>

        <h4>Rincian Gambar</h4>
        <div class="row">
            @foreach ($workspace->workspaceGambar as $item)
                @php
                    $fotos = json_decode($item->foto_body, true);
                @endphp
                @if ($fotos)
                    @foreach ($fotos as $foto)
                        <div class="col-md-3">
                            <div class="card mb-3">
                                <img src="{{ asset('storage/body/' . $foto) }}" class="card-img-top" alt="Foto Body">
                                <div class="card-body">
                                    <p><strong>Keterangan:</strong> {{ $item->keterangan }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach
        </div>

        <a href="{{ route('workspace.print', $workspace->id) }}" target="_blank" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak PDF
        </a>
    </div>
@endsection

@endsection
