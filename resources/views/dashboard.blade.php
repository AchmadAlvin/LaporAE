<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Dashboard - {{ env('APP_NAME','LaporAE') }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

  <div class="container py-4">
    @php
      $user = $user ?? null;
      $laporans = $laporans ?? collect();
      $userId = $user->id ?? null;
      $laporanPengguna = collect($laporans)->where('pelapor_id', $userId);
      $total = $laporanPengguna->count();
      $open = $laporanPengguna->where('status','open')->count();
      $closed = $laporanPengguna->where('status','closed')->count();

      // prefer user name, fallback to email, then 'Pengguna'
      $displayName = $user->name ?? $user->email ?? 'Pengguna';
    @endphp

    <div class="topbar mb-3">
      <div>
        <h3 style="margin:0">Dashboard Pengguna</h3>
        <div class="text-muted" style="font-size:13px">Selamat datang, {{ $displayName }}.</div>
      </div>

      <div style="display:flex;gap:8px;align-items:center">
        <a href="{{ url('/laporans/create') }}" class="btn btn-primary btn-sm">Tambah Laporan</a>
        <a href="{{ route('logout') }}" class="btn btn-outline-secondary btn-sm">Logout</a>
      </div>
    </div>

    <div class="card-stats mb-4">
      <div class="stat">
        <div class="label">Total laporan</div>
        <div class="value">{{ $total }}</div>
      </div>
      <div class="stat">
        <div class="label">Open</div>
        <div class="value text-primary">{{ $open }}</div>
      </div>
      <div class="stat">
        <div class="label">Closed</div>
        <div class="value text-muted">{{ $closed }}</div>
      </div>
    </div>

    <h5 class="mb-3">Daftar Laporan Saya</h5>

    <div class="table-wrap">
      @if ($laporanPengguna->isEmpty())
        <p class="text-muted mb-0">Belum ada laporan.</p>
      @else
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Dibuat</th>
                <th class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($laporanPengguna as $lap)
                <tr>
                  <td>{{ $lap->judul ?? ($lap->title ?? '-') }}</td>
                  <td>{{ $lap->kategori ?? ($lap->category ?? '-') }}</td>
                  @php $s = strtolower($lap->status ?? ''); @endphp
                  <td>
                    <span class="badge-status {{ $s === 'open' ? 'badge-open' : ($s === 'closed' ? 'badge-closed' : 'badge-pending') }}">
                      {{ ucfirst($lap->status ?? '-') }}
                    </span>
                  </td>
                  <td>{{ isset($lap->created_at) ? \Illuminate\Support\Carbon::parse($lap->created_at)->format('d M Y H:i') : '-' }}</td>
                  <td class="text-end">
                    <a href="{{ url('/laporans/'.$lap->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
