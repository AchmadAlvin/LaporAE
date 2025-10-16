<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Pengguna</title>
</head>
<body>
    <h1>Registrasi Pengguna</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register.process') }}">
        @csrf
        <label for="nama_lengkap">Nama Lengkap</label>
        <input id="nama_lengkap" name="nama_lengkap" type="text" value="{{ old('nama_lengkap') }}" required>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <label for="password_confirmation">Konfirmasi Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required>

        <p>Pertanyaan Captcha: {{ $captchaQuestion ?? '0 + 0 = ?' }}</p>
        <label for="captcha_answer">Jawaban Captcha</label>
        <input id="captcha_answer" name="captcha_answer" type="number" required>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login.form') }}">Login di sini</a></p>
</body>
</html>
