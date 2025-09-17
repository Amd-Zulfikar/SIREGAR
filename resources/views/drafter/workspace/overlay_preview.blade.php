{{-- resources/views/drafter/workspace/overlay_preview.blade.php --}}
@extends('drafter.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h4>Preview Overlay Workspace</h4>
                <a href="{{ route('index.workspace') }}" class="btn btn-danger mb-2">Kembali</a>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @foreach ($images as $index => $img)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ $img }}" class="card-img-top"
                                    style="height:300px; object-fit:contain;">
                                <div class="card-body text-center">
                                    {{-- Cetak per foto --}}
                                    <a href="{{ route('export.overlay.workspace', $workspace->id) }}?foto={{ $index }}"
                                        class="btn btn-primary btn-sm mb-1" target="_blank">
                                        Cetak Foto Ini
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Cetak Semua --}}
                <div class="text-right mt-3">
                    <a href="{{ route('export.overlay.workspace', $workspace->id) }}" class="btn btn-success"
                        target="_blank">
                        Cetak Semua Foto
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
