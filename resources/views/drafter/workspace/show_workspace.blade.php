@extends('drafter.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h4>Detail Workspace</h4>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Preview Workspace</h3>
                        <div class="card-tools">
                            <a href="{{ route('export.workspace', $workspace->id) }}" class="btn btn-success btn-sm"
                                target="_blank">
                                <i class="fas fa-print"></i> Cetak
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- tampilkan detail workspace -->
                        <p>No Transaksi: {{ $workspace->no_transaksi }}</p>
                        <p>Customer: {{ $workspace->customer->name ?? '-' }}</p>
                        <p>Drafter: {{ $workspace->employee->name ?? '-' }}</p>
                        <p>Submission: {{ $workspace->submission->judul ?? '-' }}</p>
                        <p>Tanggal: {{ $workspace->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
