@php
    $text = '';
    $type_index = 0;
    
    if ($type == 'utama') {
        $text = 'Utama'; 
        $type_index = 0; // Index 0
    } elseif ($type == 'terurai') {
        $text = 'Terurai'; 
        $type_index = 1; // Index 1
    } elseif ($type == 'kontruksi') {
        $text = 'Konstruksi'; 
        $type_index = 2; // Index 2
    }
@endphp

<div class="row form-group align-items-center">
    <div class="col-md-2">
        <label class="col-form-label-sm">Gambar {{ $text }} {{ $index }}:</label>
    </div>
    <div class="col-md-2">
        {{-- Varian --}}
        <select name="rincian[{{ $type }}][{{ $index }}][varian_id]" class="form-control form-control-sm select2-sm" required>
            <option selected disabled>Pilih Varian</option>
            @foreach ($varians as $v)
                <option value="{{ $v->id }}">{{ $v->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        {{-- Jenis Body (Keterangan) --}}
        <select name="rincian[{{ $type }}][{{ $index }}][keterangan_id]" class="form-control form-control-sm select2-sm gambar-keterangan" required disabled>
            <option selected disabled>Pilih Jenis Body</option>
        </select>
    </div>
    <div class="col-md-2">
        {{-- Jumlah Gambar (Dikunci dan diset 1) --}}
        <input type="number" 
               name="rincian[{{ $type }}][{{ $index }}][jumlah_gambar]" 
               class="form-control form-control-sm jumlah-gambar" 
               placeholder="Jml. Gbr" 
               value="1" 
               readonly 
               required>
    </div>
    <div class="col-md-1">
        {{-- Halaman Gambar (Diatur otomatis oleh JS) --}}
        <input type="text" 
               name="rincian[{{ $type }}][{{ $index }}][halaman_gambar]" 
               class="form-control form-control-sm halaman-gambar-input" 
               placeholder="Hal" 
               data-type="{{ $type }}"
               data-index-baris="{{ $index }}"
               data-type-index="{{ $type_index }}"
               readonly {{-- Wajib readonly agar tidak diubah --}}
               required>
    </div>
    <div class="col-md-1 text-right">
        <button type="button" class="btn btn-sm btn-info preview-gambar-btn" data-type="{{ $type }}" data-index="{{ $index }}" disabled>Preview</button>
    </div>
</div>