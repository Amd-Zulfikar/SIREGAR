@extends('drafter.layouts.app')

@section('content')
    <div class="content-wrapper">
        <br>
        <div class="content">
            <div class="container-fluid">
                <div class="col-12 col-sm-12">
                    <div>
                        <a href="{{ route('index.workspace') }}" class="btn btn-outline-primary">KEMBALI</a>
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
                                <!-- Tab Detail Transaksi -->
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
                                                            {{ $g->brandModel ? $g->brandModel->name : '-' }}
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

                                <!-- Tab Detail Gambar (isi kolom dulu: max 4 per kolom; 4 kolom per blok) -->
                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-profile-tab">

                                    @php
                                        // normalisasi input jadi array
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
                                        $maxPerCol = 4; // maksimal 4 gambar per kolom (vertikal)
                                        $colsPerBlock = 4; // 4 kolom per blok (seperti contoh)
                                        $blockSize = $maxPerCol * $colsPerBlock; // 16
                                        $blocks = $total ? array_chunk($imagesArr, $blockSize) : [];
                                    @endphp

                                    <div class="container-fluid">
                                        @if ($total === 0)
                                            <div class="text-muted">Tidak ada gambar.</div>
                                        @else
                                            @foreach ($blocks as $block)
                                                <div class="row mb-4">
                                                    @for ($col = 0; $col < $colsPerBlock; $col++)
                                                        <div
                                                            class="col-6 col-md-4 col-lg-3 d-flex flex-column align-items-center">
                                                            @for ($row = 0; $row < $maxPerCol; $row++)
                                                                @php
                                                                    $index = $col * $maxPerCol + $row;
                                                                @endphp

                                                                @if (isset($block[$index]))
                                                                    <div class="mb-3 w-100 d-flex justify-content-center">
                                                                        <img src="{{ asset($block[$index]) }}"
                                                                            class="img-fluid overlay-img"
                                                                            data-preview="{{ asset($block[$index]) }}"
                                                                            alt="Overlay Image">
                                                                    </div>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    @endfor
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                        <a href="{{ route('export.overlay.workspace', $workspace->id) }}" target="_blank"
                                            class="btn btn-danger">
                                            <i class="fa-solid fa-file-pdf"></i></i>
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

    <!-- Modal Preview -->
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
            width: 150px;
            height: 150px;
            object-fit: contain;
            cursor: pointer;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 3px;
            background: #fff;
            transition: transform .15s ease;
        }

        .overlay-img:hover {
            transform: scale(1.03);
        }

        /* Responsif ukuran gambar */
        @media (max-width: 768px) {
            .overlay-img {
                width: 120px;
                height: 120px;
            }
        }

        @media (max-width: 576px) {
            .overlay-img {
                width: 100px;
                height: 100px;
            }
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
