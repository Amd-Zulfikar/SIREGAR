@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <a type="button" class="btn btn-block bg-gradient-primary"
                                onclick="location.href='{{ route('add.customer') }}'">Tambah Data</a>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Customer</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-edit"></i> Data Customer</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Perusahaan</th>
                                            <th>Nama Direktur</th>
                                            <th>Paraf</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customers as $customer)
                                            <tr>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->direktur }}</td>
                                                <td>
                                                    @if ($customer->foto_paraf)
                                                        @php $files = json_decode($customer->foto_paraf, true); @endphp
                                                        @foreach ($files as $file)
                                                            <img src="{{ asset('storage/paraf/' . $file) }}"
                                                                style="width:50px; height:50px; object-fit:cover; cursor:pointer;"
                                                                class="img-thumbnail preview-img"
                                                                data-src="{{ asset('storage/paraf/' . $file) }}">
                                                            <!-- MODIFIED -->
                                                        @endforeach
                                                    @else
                                                        <span>Tidak ada file</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="status-switch"
                                                        data-id="{{ $customer->id }}" name="status"
                                                        {{ $customer->status ? 'checked' : '' }} data-bootstrap-switch
                                                        data-off-color="danger" data-on-color="success">
                                                </td>
                                                <td>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('edit.customer', $customer->id) }}">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">Data Not Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nama Perusahaan</th>
                                            <th>Nama Direktur</th>
                                            <th>Paraf</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div class="mt-2">
                                    {{ $customers->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Preview -->
        <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true"> <!-- MODIFIED -->
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <img src="" id="imgPreviewModal" class="img-fluid w-100">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Preview gambar
            $('.preview-img').on('click', function() {
                $('#imgPreviewModal').attr('src', $(this).data('src'));
                $('#modalPreview').modal('show');
            });

            // 🔥 Inisialisasi bootstrapSwitch
            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });

            // 🔥 Event ON/OFF
            $(document).on('switchChange.bootstrapSwitch', '.status-switch', function(event, state) {
                let id = $(this).data('id');
                let newStatus = state ? 1 : 0;

                $.ajax({
                    url: "{{ url('admin/customer/action') }}/" + id,
                    method: "POST",
                    data: {
                        status: newStatus,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            console.log("Status updated:", res.status);
                        }
                    },
                    error: function(xhr) {
                        alert("Gagal update status! (" + xhr.status + ")");
                    }
                });
            });

            // Toastr untuk flash session
            var successMessage = "{{ session('success') ?? '' }}";
            var errorMessage = "{{ session('error') ?? '' }}";

            if (successMessage) toastr.success(successMessage);
            if (errorMessage) toastr.error(errorMessage);
        });
    </script>
@endpush
