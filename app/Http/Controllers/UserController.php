<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'sometimes|accepted',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            if (! empty($data['is_admin'])) {
                Admin::create([
                    'user_id' => $user->id,
                    'name'    => $user->name,
                    'email'   => $user->email,
                    'password'=> $user->password,
                ]);
            }

            DB::commit();

            session(['user' => $user->id]);
            return redirect()->route('dashboard');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['register' => 'Gagal mendaftar: '.$e->getMessage()]);
        }
    }

    public function loginForm()
    {
        return view('login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'captcha' => 'accepted',
        ], [
            'captcha.accepted' => 'Tandai captcha "I am not a robot".'
        ]);

        $cred = $request->only('email', 'password');

        $user = User::where('email', $cred['email'])->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        $stored = $user->password;
        $passwordOk = false;

        // Attempt standard bcrypt check (may throw if stored not bcrypt)
        try {
            $passwordOk = \Illuminate\Support\Facades\Hash::check($cred['password'], $stored);
        } catch (\RuntimeException $e) {
            // Not bcrypt => try legacy checks
            $plain = $cred['password'];

            // md5
            if (! $passwordOk && is_string($stored) && strlen($stored) === 32 && md5($plain) === $stored) {
                $passwordOk = true;
            }

            // sha1
            if (! $passwordOk && is_string($stored) && strlen($stored) === 40 && sha1($plain) === $stored) {
                $passwordOk = true;
            }

            // plain text (fallback)
            if (! $passwordOk && $plain === $stored) {
                $passwordOk = true;
            }
        }

        if (! $passwordOk) {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        // If the stored password is not bcrypt or needs rehash, rehash and save
        try {
            if (! \Illuminate\Support\Facades\Hash::needsRehash($stored)) {
                // needsRehash returns false if algorithm matches current; if stored wasn't bcrypt, earlier check would have thrown.
                // But handle case where stored was legacy: rehash if it doesn't look like bcrypt.
                if (! is_string($stored) || strpos($stored, '$2y$') !== 0) {
                    $user->password = \Illuminate\Support\Facades\Hash::make($cred['password']);
                    $user->save();
                }
            } else {
                // stored uses bcrypt but flagged for rehash (older cost) -> rehash
                $user->password = \Illuminate\Support\Facades\Hash::make($cred['password']);
                $user->save();
            }
        } catch (\Throwable $e) {
            // ignore rehash/save errors, proceed to login
        }

        session(['user' => $user->id]);
        return redirect()->intended(route('dashboard'));
    }

    public function dashboard()
    {
        $user = null;
        if (session()->has('user')) {
            $user = User::find(session('user'));
        }

        // ambil semua laporan (atau hanya milik user jika ingin)
        $laporans = collect();
        if ($user) {
            $laporans = DB::table('laporans')->orderBy('created_at', 'desc')->get();
        }

        return view('dashboard', ['user' => $user, 'laporans' => $laporans]);
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login.form');
    }
}
