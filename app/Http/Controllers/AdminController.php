<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function loginForm(): View
    {
        $captcha = $this->generateCaptcha('admin_login');

        return view('admin.auth.login', [
            'captchaQuestion' => $captcha['question'],
        ]);
    }

    public function loginProcess(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'captcha_answer' => ['required', 'numeric'],
        ]);

        if (! $this->validateCaptcha('admin_login', (int) $request->input('captcha_answer'))) {
            return back()->withInput()->withErrors(['captcha_answer' => 'Jawaban captcha salah.']);
        }

        $admin = Admin::where('email', $request->input('email'))->first();

        if (! $admin || ! Hash::check($request->input('password'), $admin->password)) {
            return back()->withInput()->withErrors(['email' => 'Kredensial tidak valid.']);
        }

        session(['admin' => [
            'id' => $admin->id,
            'nama' => $admin->nama,
            'email' => $admin->email,
        ]]);

        return redirect()->route('admin.dashboard')->with('status', 'Login admin berhasil.');
    }

    public function index(): View|RedirectResponse
    {
        if ($redirect = $this->ensureAdminAuthenticated()) {
            return $redirect;
        }

        return view('admin.dashboard', [
            'laporans' => Laporan::latest()->get(),
            'admin' => session('admin'),
        ]);
    }

    public function edit(int $id): View|RedirectResponse
    {
        if ($redirect = $this->ensureAdminAuthenticated()) {
            return $redirect;
        }

        return app(LaporanController::class)->edit($id);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if ($redirect = $this->ensureAdminAuthenticated()) {
            return $redirect;
        }

        return app(LaporanController::class)->update($request, $id);
    }

    public function destroy(int $id): RedirectResponse
    {
        if ($redirect = $this->ensureAdminAuthenticated()) {
            return $redirect;
        }

        return app(LaporanController::class)->destroy($id);
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
    public function logout(): RedirectResponse // Tambahkan fungsi ini
    {
        session()->forget('admin'); // Hapus data sesi admin
        session()->flash('status', 'Logout admin berhasil.'); // Pesan opsional
        return redirect()->route('admin.login.form'); // Redirect ke halaman login admin
    }
}
