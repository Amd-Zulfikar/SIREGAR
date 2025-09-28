@extends('drafter.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <a type="button" class="btn btn-block btn-outline-primary"
                                onclick="location.href='{{ route('add.workspace') }}'"><i
                                    class="fa-solid fa-pen-to-square"></i>
                                Ambil Gambar</a>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Workspace</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-edit"></i>
                                    Data Kerja
                                </h3>
                            </div>
                            <!-- card -->
                            <div class="card-body pad table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Transaksi</th>
                                            <th>Customer</th>
                                            <th>Gambar</th>
                                            <th>Pengajuan</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($workspaces as $index => $workspace)
                                            <tr>
                                                <td>{{ $workspaces->firstItem() + $index }}</td>
                                                <td>{{ $workspace->no_transaksi }}</td>
                                                <td>{{ $workspace->customer->name ?? '-' }}</td>
                                                <td>
                                                    @if ($workspace->workspaceGambar->isNotEmpty())
                                                        @php
                                                            $gambar = $workspace->workspaceGambar->first();
                                                        @endphp
                                                        {{ ($gambar->brandModel->name ?? '-') . ' ' . ($gambar->chassisModel->name ?? '-') . ' ' . ($gambar->vehicleModel->name ?? '-') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $workspace->submission->name ?? '-' }}</td>
                                                <td>{{ $workspace->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <a class="btn btn-outline-info"
                                                        href="{{ route('edit.workspace', $workspace->id) }}">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <a class="btn btn-outline-info"
                                                        href="{{ route('overlay.workspace', $workspace->id) }}">
                                                        <i class="fas fa-eye"></i> Preview
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>No Transaksi</th>
                                            <th>Customer</th>
                                            <th>Gambar</th>
                                            <th>Pengajuan</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!-- Laravel Pagination -->
                                {{-- <div class="mt-2">
                                    {{ $workspaces->links('pagination::bootstrap-4') }}
                                </div> --}}
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- ./row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
