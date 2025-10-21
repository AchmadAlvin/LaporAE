<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <title>Admin Sign In - {{ env('APP_NAME','LaporAE') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue: #0b63ff;
            --blue-dark: #0650d6;
            --muted: #6b7280;
            --text-color: #020617;
            --bg-light: #f3f7ff;
            --border-color: #e6edf8;
            --input-bg: #fff;
            --danger: #dc2626;
            --success: #22c55e;
            --placeholder-color: #9ca3af;
        }
        * { box-sizing: border-box; font-family: 'Inter', system-ui, sans-serif; }
        body { margin: 0; min-height: 100vh; background: var(--bg-light); display: flex; align-items: center; justify-content: center; padding: 24px; color: var(--text-color); }
        .form-container { width: 100%; max-width: 450px; background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(2, 6, 23, 0.08); }
        h2 { text-align: center; margin-bottom: 24px; color: var(--text-color); font-size: 24px; font-weight: 700; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; color: var(--muted); margin-bottom: 6px; }
        .form-input { width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); background: var(--input-bg); color: var(--text-color); font-size: 15px; }
        .form-input::placeholder { color: var(--placeholder-color); opacity: 1; }
        .form-input:focus { outline: none; border-color: var(--blue); box-shadow: 0 0 0 2px rgba(11, 99, 255, 0.2); }
        .btn { display: inline-block; width: 100%; padding: 12px; border-radius: 10px; border: 0; background: var(--blue); color: #fff; font-weight: 700; cursor: pointer; transition: background-color 0.2s ease; text-align: center; }
        .btn:hover { background-color: var(--blue-dark); }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .alert-success { background-color: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .alert ul { margin: 0; padding-left: 20px; list-style-type: disc; }
        .field-error { font-size: 13px; color: var(--danger); margin-top: 4px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Admin Sign In</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.process') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="form-input" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus>
            @error('email') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" class="form-input" placeholder="Password" required>
            @error('password') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="captcha_answer">Pertanyaan: {{ $captchaQuestion ?? 'Loading...' }}</label>
            <input id="captcha_answer" name="captcha_answer" type="number" class="form-input" placeholder="Jawaban" required>
            @error('captcha_answer') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <button class="btn" type="submit">Sign In</button>
    </form>
</div>

</body>
</html>
