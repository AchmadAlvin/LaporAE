<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Status Laporan</title>
</head>
<body>
    <h1>Edit Status Laporan</h1>

    <p>Judul: {{ $laporan->judul }}</p>
    <p>Deskripsi: {{ $laporan->deskripsi }}</p>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.laporan.update', $laporan->id) }}">
        @csrf
        @method('PUT')

        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="Baru Masuk" @selected(old('status', $laporan->status) === 'Baru Masuk')>Baru Masuk</option>
            <option value="Sedang Diverifikasi" @selected(old('status', $laporan->status) === 'Sedang Diverifikasi')>Sedang Diverifikasi</option>
            <option value="Selesai Ditindaklanjuti" @selected(old('status', $laporan->status) === 'Selesai Ditindaklanjuti')>Selesai Ditindaklanjuti</option>
        </select>

        <button type="submit">Simpan</button>
    </form>

    <p><a href="{{ route('admin.dashboard') }}">Kembali</a></p>
</body>
</html>
