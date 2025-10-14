@extends('drafter.layouts.app')

@section('content')
    <div class="content-wrapper">
        <br>
        <div class="content">
            <div class="container-fluid">
                <div class="col-12 col-sm-12">
                    <div>
                        <a href="{{ route('index.workspace') }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-circle-left"></i> Kembali
                        </a>
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

                                {{-- Tab Detail Transaksi --}}
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
                                                @foreach ($workspace->workspaceGambar as $g)
                                                    <tr>
                                                        <td>{{ $workspace->no_transaksi ?? '-' }}</td>
                                                        <td>
                                                            {{ $g->brandModel->name ?? '-' }}
                                                            {{ $g->chassisModel ? ' ' . $g->chassisModel->name : '' }}
                                                            {{ $g->vehicleModel ? ' ' . $g->vehicleModel->name : '' }}
                                                            {{ $g->keteranganModel ? ' - ' . $g->keteranganModel->keterangan : '' }}
                                                        </td>
                                                        <td>{{ $workspace->submission->name ?? '-' }}</td>
                                                        <td>{{ $workspace->created_at->format('d/m/Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-profile-tab">

                                    @php
                                        if (is_null($images)) {
                                            $imagesArr = [];
                                        } elseif (is_array($images)) {
                                            $imagesArr = array_values($images);
                                        } elseif ($images instanceof \Illuminate\Support\Collection) {
                                            $imagesArr = $images->values()->all();
                                        } else {
                                            $imagesArr = is_iterable($images)
                                                ? iterator_to_array($images)
                                                : (array) $images;
                                            $imagesArr = array_values($imagesArr);
                                        }

                                        $total = count($imagesArr);
                                    @endphp

                                    <div class="container-fluid">
                                        @if ($total === 0)
                                            <div class="text-muted">Tidak ada gambar.</div>
                                        @else
                                            <div class="d-flex overflow-auto py-3 px-2" style="gap: 15px;">
                                                @foreach ($imagesArr as $imagePath)
                                                    <div class="border rounded p-2 bg-light flex-shrink-0 text-center"
                                                        style="max-width: 1000px;">
                                                        <img src="{{ asset($imagePath) }}" class="overlay-img img-fluid"
                                                            data-preview="{{ asset($imagePath) }}" alt="Overlay Image">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3 d-flex justify-content-between align-items-center mt-3">
                                        <a href="{{ route('export.overlay.workspace', $workspace->id) }}" target="_blank"
                                            class="btn btn-danger">
                                            <i class="fa-solid fa-file-pdf"></i> Download
                                        </a>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Preview --}}
    <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 text-center">
                    <img src="" id="imgPreviewModal" class="img-fluid" alt="Preview">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .overlay-img {
            width: 100%;
            max-width: 650px;
            /* dari 450 jadi 650 */
            height: auto;
            object-fit: contain;
            cursor: pointer;
            border-radius: 8px;
            border: 1px solid #ddd;
            background: #fff;
            transition: transform .2s ease;
        }

        .overlay-img:hover {
            transform: scale(1.03);
        }

        /* Responsif */
        @media (max-width: 768px) {
            .overlay-img {
                max-width: 500px;
                /* naik dari 350 */
            }
        }

        @media (max-width: 576px) {
            .overlay-img {
                max-width: 350px;
                /* naik dari 250 */
            }
        }

        .overflow-auto {
            scroll-behavior: smooth;
        }
    </style>
@endpush




@push('scripts')
    <script>
        $(function() {
            $(document).on('click', '.overlay-img', function() {
                const src = $(this).data('preview') || $(this).attr('src');
                if (!src) return;
                $('#imgPreviewModal').attr('src', src);
                $('#modalPreview').modal('show');
            });

            $('#modalPreview').on('hidden.bs.modal', function() {
                $('#imgPreviewModal').attr('src', '');
            });
        });
    </script>
@endpush
