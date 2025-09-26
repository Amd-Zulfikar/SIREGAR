@extends('drafter.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <br>
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="col-12 col-sm-12">
                    <div>
                        <a href="{{ route('index.workspace') }}" class="btn bg-gradient-primary">KEMBALI</a>
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
                                                <tr>
                                                    <td>{{ $workspace->no_transaksi ?? '-' }}</td>
                                                    <td>
                                                        @if ($workspace->workspaceGambar->isNotEmpty())
                                                            @php $g = $workspace->workspaceGambar->first(); @endphp
                                                            {{ $g->brandModel ? ' ' . ($g->brandModel->name ?? '-') : '' }}
                                                            {{ $g->chassisModel ? ' ' . ($g->chassisModel->name ?? '-') : '' }}
                                                            {{ $g->vehicleModel ? ' ' . ($g->vehicleModel->name ?? '-') : '' }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ $workspace->submission->name ?? '-' }}</td>
                                                    <td>{{ $workspace->created_at->format('d/m/Y') }}</td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-profile-tab">
                                    <div>
                                        <div class="container-fluid d-flex justify-content-between align-items-center">
                                            {{-- Tombol cetak PDF --}}
                                            <a href="{{ route('export.overlay.workspace', $workspace->id) }}"
                                                target="_blank" class="btn btn-danger">
                                                <i class="fas fa-file-pdf"></i> Cetak PDF
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="container-fluid">
                                        @if (count($images) > 0)
                                            <div class="row">
                                                @foreach ($images as $img)
                                                    <div class="col-md-6 mb-4">
                                                        <div class="card shadow-sm">
                                                            <div class="card-body text-center">
                                                                <img src="{{ asset($img) }}" class="img-fluid rounded"
                                                                    alt="Overlay Image" style="max-height: 800px;">
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
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

@endsection
