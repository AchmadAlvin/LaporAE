<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
</head>
<body>
    <h1>Login Admin</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.login.process') }}">
        @csrf
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <p>Pertanyaan Captcha: {{ $captchaQuestion ?? '0 + 0 = ?' }}</p>
        <label for="captcha_answer">Jawaban Captcha</label>
        <input id="captcha_answer" name="captcha_answer" type="number" required>

        <button type="submit">Login</button>
    </form>
</body>
</html>
