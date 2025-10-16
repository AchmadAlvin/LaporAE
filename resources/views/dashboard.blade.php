<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pengguna</title>
</head>
<body>
    <h1>Dashboard Pengguna</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <p>Selamat datang, {{ $user['nama_lengkap'] ?? 'Pengguna' }}.</p>

    <p>
        <a href="{{ route('lapor.create') }}">Tambah Laporan</a> |
        <a href="{{ route('logout') }}">Logout</a>
    </p>

    <h2>Daftar Laporan Saya</h2>

    @php
        $userId = $user['id'] ?? null;
        $laporanPengguna = $laporans->where('pelapor_id', $userId);
    @endphp

    @if ($laporanPengguna->isEmpty())
        <p>Belum ada laporan.</p>
    @else
        <table border="1" cellpadding="4" cellspacing="0">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanPengguna as $laporan)
                    <tr>
                        <td>{{ $laporan->judul }}</td>
                        <td>{{ $laporan->kategori }}</td>
                        <td>{{ $laporan->lokasi }}</td>
                        <td>{{ $laporan->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
