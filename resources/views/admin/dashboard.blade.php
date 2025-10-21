<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <title>Admin Dashboard - {{ env('APP_NAME','LaporAE') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,.1); }
        .table thead th { background-color: #e9ecef; }
        .badge-status { padding: .4em .6em; font-size: .75em; border-radius: .25rem; }
        .badge-baru { background-color: #cfe2ff; color: #084298; }
        .badge-verifikasi { background-color: #fff3cd; color: #664d03; }
        .badge-selesai { background-color: #d1e7dd; color: #0f5132; }
        .action-buttons form { display: inline-block; margin-left: 5px;}
        .container { max-width: 1200px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ route('admin.dashboard') }}">Admin LaporAE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item me-3">
                        <span class="navbar-text">Selamat datang, {{ $admin['nama'] ?? 'Admin' }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

```
<div class="container mt-4">
    <h2 class="mb-4">Daftar Laporan Masuk</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($laporans->isEmpty())
                <p class="text-muted text-center my-3">Belum ada laporan.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Pelapor</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporans as $laporan)
                                <tr>
                                    <td>{{ $laporan->id }}</td>
                                    <td>{{ $laporan->judul }}</td>
                                    <td>{{ $laporan->pelapor->nama_lengkap ?? $laporan->pelapor->email ?? 'N/A' }}</td>
                                    <td>{{ $laporan->kategori }}</td>
                                    <td>
                                        @php
                                            $statusClass = match($laporan->status) {
                                                'Baru Masuk' => 'badge-baru',
                                                'Sedang Diverifikasi' => 'badge-verifikasi',
                                                'Selesai Ditindaklanjuti' => 'badge-selesai',
                                                default => ''
                                            };
                                        @endphp
                                        <span class="badge-status {{ $statusClass }}">{{ $laporan->status }}</span>
                                    </td>
                                    <td>{{ $laporan->created_at->format('d M Y H:i') }}</td>
                                    <td class="text-end action-buttons">
                                        <a href="{{ route('admin.laporan.edit', $laporan->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
```

</body>
</html>
