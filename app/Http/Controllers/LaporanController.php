<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(): RedirectResponse
    {
        if (session()->has('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }

    public function create(): View|RedirectResponse
    {
        if ($redirect = $this->ensureUserAuthenticated()) {
            return $redirect;
        }

        return view('laporan.create', [
            'user' => session('user'),
            'captchaQuestion' => $this->generateCaptcha('laporan_create')['question'],
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
            'foto' => ['required', 'image', 'max:2048'],
            'captcha_answer' => ['required', 'numeric'],
        ]);

        if (! $this->validateCaptcha('laporan_create', (int) $request->input('captcha_answer'))) {
            return back()
                ->withInput()
                ->withErrors(['captcha_answer' => 'Jawaban captcha tidak sesuai.']);
        }

        $user = session('user');

        $fotoPath = $request->file('foto')->store('laporans', 'public');

        Laporan::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'kategori' => $validated['kategori'],
            'lokasi' => $validated['lokasi'],
            'foto' => $fotoPath,
            'status' => 'Baru Masuk',
            'pelapor_id' => $user['id'] ?? null,
        ]);

        return redirect()->route('dashboard')->with('status', 'Laporan berhasil dikirim.');
    }

    public function show(int $id): View|RedirectResponse
    {
        if ($redirect = $this->ensureUserAuthenticated()) {
            return $redirect;
        }

        $laporan = Laporan::with('pelapor')->findOrFail($id);

        $user = session('user');
        if (! is_array($user) || ($laporan->pelapor_id !== ($user['id'] ?? null))) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        return view('laporan.show', [
            'laporan' => $laporan,
        ]);
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

        $user = session('user');
        if (! is_array($user) || ! isset($user['id'])) {
            session()->forget('user');
            return redirect()->route('login.form')->with('error', 'Session pengguna tidak valid.');
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

    protected function generateCaptcha(string $key): array
    {
        $first = random_int(1, 9);
        $second = random_int(1, 9);

        session(["captcha_{$key}" => $first + $second]);

        return [
            'question' => "{$first} + {$second} = ?",
        ];
    }

    protected function validateCaptcha(string $key, int $answer): bool
    {
        $expected = session("captcha_{$key}");
        session()->forget("captcha_{$key}");

        return $expected !== null && $expected === $answer;
    }
}
