<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function registerForm(): View
    {
        $captcha = $this->generateCaptcha('user_register');

        return view('auth.register', [
            'captchaQuestion' => $captcha['question'],
        ]);
    }

    public function registerProcess(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'captcha_answer' => ['required', 'numeric'],
        ]);

        if (! $this->validateCaptcha('user_register', (int) $request->input('captcha_answer'))) {
            return back()->withInput()->withErrors(['captcha_answer' => 'Jawaban captcha salah.']);
        }

        $user = User::create([
            'nama_lengkap' => $request->input('nama_lengkap'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        session(['user' => [
            'id' => $user->id,
            'nama_lengkap' => $user->nama_lengkap,
            'email' => $user->email,
        ]]);

        return redirect()->route('dashboard')->with('status', 'Registrasi berhasil.');
    }

    public function loginForm(): View
    {
        $captcha = $this->generateCaptcha('user_login');

        return view('auth.login', [
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

        if (! $this->validateCaptcha('user_login', (int) $request->input('captcha_answer'))) {
            return back()->withInput()->withErrors(['captcha_answer' => 'Jawaban captcha salah.']);
        }

        $user = User::where('email', $request->input('email'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            return back()->withInput()->withErrors(['email' => 'Kredensial tidak valid.']);
        }

        session(['user' => [
            'id' => $user->id,
            'nama_lengkap' => $user->nama_lengkap,
            'email' => $user->email,
        ]]);

        session()->forget('admin');

        return redirect()->route('dashboard')->with('status', 'Login berhasil.');
    }

    public function dashboard(): View|RedirectResponse
    {
        if ($redirect = $this->ensureUserAuthenticated()) {
            return $redirect;
        }

        return app(LaporanController::class)->index();
    }

    public function logout(): RedirectResponse
    {
        session()->forget(['user', 'admin']);

        return redirect()->route('login.form')->with('status', 'Anda telah logout.');
    }

    protected function ensureUserAuthenticated(): ?RedirectResponse
    {
        if (! session()->has('user')) {
            return redirect()->route('login.form')->with('error', 'Silakan login terlebih dahulu.');
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
