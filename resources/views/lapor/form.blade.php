<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buat Laporan</title>
</head>
<body>
    <h1>Buat Laporan Baru</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('lapor.store') }}">
        @csrf
        <label for="judul">Judul</label>
        <input id="judul" name="judul" type="text" value="{{ old('judul') }}" required>

        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>

        <label for="kategori">Kategori</label>
        <input id="kategori" name="kategori" type="text" value="{{ old('kategori') }}" required>

        <label for="lokasi">Lokasi</label>
        <input id="lokasi" name="lokasi" type="text" value="{{ old('lokasi') }}" required>

        <label for="foto">Foto (URL atau nama file)</label>
        <input id="foto" name="foto" type="text" value="{{ old('foto') }}" required>

        <p>Captcha sederhana (silakan isi 1 + 1):</p>
        <input id="captcha_lapor" name="captcha_lapor" type="number" required>

        <button type="submit">Kirim Laporan</button>
    </form>

    <p><a href="{{ route('dashboard') }}">Kembali ke Dashboard</a></p>
</body>
</html>
