@extends('drafter.layouts.app')

@section('content')
    <div class="content-wrapper">
        {{-- Header --}}
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1>Preview Overlay - {{ $workspace->kode_transaksi }}</h1>

                {{-- Tombol cetak PDF --}}
                <a href="{{ route('workspace.overlay.pdf', $workspace->id) }}" target="_blank" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </a>
            </div>
        </section>

        {{-- Konten --}}
        <section class="content">
            <div class="container-fluid">
                @if (count($images) > 0)
                    <div class="row">
                        @foreach ($images as $img)
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <img src="{{ asset($img) }}" class="img-fluid rounded" alt="Overlay Image"
                                            style="max-height: 800px;">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Tidak ada gambar overlay yang dapat ditampilkan.
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
