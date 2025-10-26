@php
    $isEdit = isset($laporan);
    $action = $isEdit ? route('laporan.update', $laporan->id) : route('lapor.store');
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="row g-3">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="col-12">
        <label for="judul" class="form-label">Judul Laporan</label>
        <input id="judul" name="judul" type="text" value="{{ old('judul', $laporan->judul ?? '') }}" class="form-control @error('judul') is-invalid @enderror" required>
        @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="deskripsi" class="form-label">Deskripsi Kejadian</label>
        <textarea id="deskripsi" name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $laporan->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="kategori" class="form-label">Kategori</label>
        <input id="kategori" name="kategori" type="text" value="{{ old('kategori', $laporan->kategori ?? '') }}" class="form-control @error('kategori') is-invalid @enderror" required>
        @error('kategori')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="lokasi" class="form-label">Lokasi Kejadian</label>
        <input id="lokasi" name="lokasi" type="text" value="{{ old('lokasi', $laporan->lokasi ?? '') }}" class="form-control @error('lokasi') is-invalid @enderror" required>
        @error('lokasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="foto" class="form-label">Unggah Foto Bukti</label>
        <input id="foto" name="foto" type="file" accept="image/*" class="form-control @error('foto') is-invalid @enderror" {{ $isEdit ? '' : 'required' }}>
        <div class="form-text">
            Format diperbolehkan: JPG, PNG. Maksimal 2MB.
            @if ($isEdit && $laporan->foto_url)
                <br>
                <a href="{{ $laporan->foto_url }}" target="_blank" class="text-decoration-none">Lihat foto saat ini</a>
            @endif
        </div>
        @error('foto')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 d-flex gap-2">
        <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Simpan Perubahan' : 'Kirim Laporan' }}</button>
        <a href="{{ $isEdit ? route('laporan.show', $laporan->id) : route('dashboard') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
