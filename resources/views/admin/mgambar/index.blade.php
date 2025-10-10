@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <a type="button" class="btn btn-block btn-outline-primary"
                                onclick="location.href='{{ route('add.mgambar') }}'">Tambah Data</a>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Master Gambar</li>
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
                                <h3 class="card-title"><i class="fas fa-edit"></i> Gambar Master</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Engine</th>
                                            <th>Merk</th>
                                            <th>Chassis</th>
                                            <th>Vehicle</th>
                                            <th>Jenis Body</th>
                                            <th>Gambar Body</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($mgambars as $mgambar)
                                            <tr>
                                                <td>{{ $mgambar->mdata->engine->name ?? '-' }}</td>
                                                <td>{{ $mgambar->mdata->brand->name ?? '-' }}</td>
                                                <td>{{ $mgambar->mdata->chassis->name ?? '-' }}</td>
                                                <td>{{ $mgambar->mdata->vehicle->name ?? '-' }}</td>
                                                <td>{{ $mgambar->keterangan }}</td>

                                                <td>
                                                    <div style="display:flex; flex-wrap: wrap; gap: 5px;">

                                                        {{-- 1. Tampilkan Foto Utama, Terurai, Konstruksi --}}
                                                        @php $hasImage = false; @endphp
                                                        @foreach (['Utama' => $mgambar->foto_utama, 'Terurai' => $mgambar->foto_terurai, 'Konstruksi' => $mgambar->foto_kontruksi, 'Optional' => $mgambar->foto_optional] as $title => $file)
                                                            @if ($file)
                                                                @php $hasImage = true; @endphp
                                                                <img src="{{ asset('storage/body/' . $file) }}"
                                                                    alt="Gambar {{ $title }}"
                                                                    title="Gambar {{ $title }}"
                                                                    class="img-thumbnail preview-img"
                                                                    style="width:80px; height:80px; object-fit:cover; cursor:pointer; border:2px solid #3c8dbc;"
                                                                    data-src="{{ asset('storage/body/' . $file) }}">
                                                            @endif
                                                        @endforeach

                                                        {{-- 2. Tampilkan Optional Images dari relasi --}}
                                                        {{-- @if ($mgambar->optionalImages->count() > 0)
                                                            @foreach ($mgambar->optionalImages as $optional)
                                                                @php $hasImage = true; @endphp
                                                                <img src="{{ asset('storage/body/optional/' . $optional->file_name) }}"
                                                                    alt="{{ $optional->description ?? 'Optional Image' }}"
                                                                    title="{{ $optional->description ?? 'Optional Image' }}"
                                                                    class="img-thumbnail preview-img"
                                                                    style="width:80px; height:80px; object-fit:cover; cursor:pointer; border:2px solid #5cb85c;"
                                                                    data-src="{{ asset('storage/body/optional/' . $optional->file_name) }}">
                                                            @endforeach
                                                        @endif --}}

                                                        @if (!$hasImage)
                                                            <span class="text-muted">No Image</span>
                                                        @endif

                                                    </div>
                                                </td>


                                                <td>
                                                    <a class="btn btn-light btn-sm"
                                                        href="{{ route('copy.mgambar', $mgambar->id) }}">
                                                        <i class="fa-solid fa-copy"></i> Copas
                                                    </a>
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('edit.mgambar', $mgambar->id) }}">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                        data-url="{{ route('delete.mgambar', $mgambar->id) }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Data Gambar Kosong. Silakan Tambah
                                                    Data Baru.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Engine</th>
                                            <th>Merk</th>
                                            <th>Chassis</th>
                                            <th>Vehicle</th>
                                            <th>Jenis Body</th>
                                            <th>Gambar Body</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Preview -->
        <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true">
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
            $(document).on('click', '.preview-img', function() {
                $('#imgPreviewModal').attr('src', $(this).data('src'));
                $('#modalPreview').modal('show');
            });

            $('.btn-delete').click(function(e) {
                e.preventDefault();
                let url = $(this).data('url');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus dan tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
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
