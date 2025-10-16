<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(): View
    {
        $laporans = Laporan::latest()->get();

        return view('laporan.index', [
            'laporans' => $laporans,
            'user' => session('user'),
            'admin' => session('admin'),
        ]);
    }

    public function create(): View|RedirectResponse
    {
        if ($redirect = $this->ensureUserAuthenticated()) {
            return $redirect;
        }

        return view('laporan.create', [
            'user' => session('user'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->ensureUserAuthenticated()) {
            return $redirect;
        }

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kategori' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'foto' => ['required', 'string', 'max:255'],
        ]);

        $user = session('user');

        Laporan::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'kategori' => $validated['kategori'],
            'lokasi' => $validated['lokasi'],
            'foto' => $validated['foto'],
            'status' => 'Baru Masuk',
            'pelapor_id' => $user['id'],
        ]);

        return redirect()->route('dashboard')->with('status', 'Laporan berhasil dikirim.');
    }

    public function edit(int $id): View|RedirectResponse
    {
        if ($redirect = $this->ensureAdminAuthenticated()) {
            return $redirect;
        }

        $laporan = Laporan::findOrFail($id);

        return view('admin.laporan.edit', [
            'laporan' => $laporan,
            'admin' => session('admin'),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if ($redirect = $this->ensureAdminAuthenticated()) {
            return $redirect;
        }

        $validated = $request->validate([
            'status' => ['required', 'in:Baru Masuk,Sedang Diverifikasi,Selesai Ditindaklanjuti'],
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.dashboard')->with('status', 'Status laporan diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        if ($redirect = $this->ensureAdminAuthenticated()) {
            return $redirect;
        }

        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('admin.dashboard')->with('status', 'Laporan berhasil dihapus.');
    }

    protected function ensureUserAuthenticated(): ?RedirectResponse
    {
        if (! session()->has('user')) {
            return redirect()->route('login.form')->with('error', 'Silakan login sebagai pengguna.');
        }

        return null;
    }

    protected function ensureAdminAuthenticated(): ?RedirectResponse
    {
        if (! session()->has('admin')) {
            return redirect()->route('admin.login.form')->with('error', 'Silakan login sebagai admin.');
        }

        return null;
    }
}
