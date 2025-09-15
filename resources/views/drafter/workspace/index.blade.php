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
                            <a type="button" class="btn btn-block bg-gradient-primary"
                                onclick="location.href='{{ route('add.workspace') }}'">Tambah Data</a>
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
                                            <th>Drafter</th>
                                            <th>Submission</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($workspaces as $index)
                                            <tr>
                                                <td>{{ $workspaces->firstItem() + $index }}</td>
                                                <td>{{ $workspace->no_transaksi }}</td>
                                                <td>{{ $workspace->customer->name ?? '-' }}</td>
                                                <td>{{ $workspace->employee->name ?? '-' }}</td>
                                                <td>{{ $workspace->submission->judul ?? '-' }}</td>
                                                <td>{{ $workspace->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('edit.workspace', $workspace->id) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Edit
                                                    </a>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('show.workspace', $workspace->id) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Preview
                                                    </a>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('export.workspace', $workspace->id) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Cetak
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td>Data Note Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>No Transaksi</th>
                                            <th>Customer</th>
                                            <th>Drafter</th>
                                            <th>Submission</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!-- Laravel Pagination -->
                                <div class="mt-2">
                                    {{ $workspaces->links('pagination::bootstrap-4') }}
                                </div>
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
