@extends('admin.layouts.app')

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
                                onclick="location.href='{{ route('add.transaction') }}'">Tambah
                                Transaksi</a>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Transaksi</li>
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
                                    <i class="fas fa-list"></i>
                                    Data Transaksi
                                </h3>
                            </div>
                            <!-- card -->
                            <div class="card-body pad table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No.Order</th>
                                            <th>Customer</th>
                                            <th>No.Kementrian</th>
                                            <th>Status Kementrian</th>
                                            <th>Status Internal</th>
                                            <th>Prioritas</th>
                                            <th>Chassis</th>
                                            <th>Tipe Kendaraan</th>
                                            <th>Drafter</th>
                                            <th>Checker</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Tanggal Order</th>
                                            <th>Lama Pengerjaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $index => $transaction)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>RKS-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $transaction->customer->name ?? '-' }}</td>
                                                <td>{{ $transaction->nomor_kementrian ?? '-' }}</td>
                                                <td>{{ $transaction->status_kementrian ?? '-' }}</td>
                                                <td>{{ $transaction->status_internal ?? '-' }}</td>
                                                <td>{{ $transaction->prioritas ?? '-' }}</td>
                                                <td>{{ $transaction->chassis->name ?? '-' }}</td>
                                                <td>{{ $transaction->vehicle->name ?? '-' }}</td>
                                                <td>{{ $transaction->drafter->name ?? '-' }}</td>
                                                <td>{{ $transaction->checker->name ?? '-' }}</td>
                                                <td>{{ $transaction->submission->name ?? '-' }}</td>
                                                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    @if ($transaction->updated_at)
                                                        {{ $transaction->updated_at->diffInDays($transaction->created_at) }}
                                                        Hari
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="14" class="text-center">Data Not Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>No.Order</th>
                                            <th>Customer</th>
                                            <th>No.Kementrian</th>
                                            <th>Status Kementrian</th>
                                            <th>Status Internal</th>
                                            <th>Prioritas</th>
                                            <th>Chassis</th>
                                            <th>Tipe Kendaraan</th>
                                            <th>Drafter</th>
                                            <th>Checker</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Tanggal Order</th>
                                            <th>Lama Pengerjaan</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Toastr untuk flash session
            var successMessage = "{{ session('success') ?? '' }}";
            var errorMessage = "{{ session('error') ?? '' }}";

            if (successMessage) toastr.success(successMessage);
            if (errorMessage) toastr.error(errorMessage);
        });
    </script>
@endpush
