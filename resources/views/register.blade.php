
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/><meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Create account - {{ env('APP_NAME','LaporAE') }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{--blue:#0b63ff;--blue-dark:#0650d6;--muted:#6b7280}
    *{box-sizing:border-box;font-family:Inter,system-ui,-apple-system,"Segoe UI",Roboto,Arial}
    body{margin:0;min-height:100vh;background:#f3f7ff;display:flex;align-items:center;justify-content:center;padding:24px}
    .panel{width:100%;max-width:1100px;border-radius:12px;overflow:hidden;display:grid;grid-template-columns:520px 1fr;box-shadow:0 20px 50px rgba(2,6,23,0.08);background:#fff}
    .left{padding:48px;background:linear-gradient(180deg,var(--blue),var(--blue-dark));color:#fff;display:flex;flex-direction:column;gap:18px;align-items:center;justify-content:center}
    .left h1{margin:0;font-size:28px}
    .left p{margin:0;color:rgba(255,255,255,0.9);max-width:400px;text-align:center}
    .right{padding:48px;background:#fff;display:flex;flex-direction:column;gap:18px;align-items:center;justify-content:center}
    .card{width:100%;max-width:420px}
    label{display:block;font-size:13px;color:var(--muted);margin-bottom:6px}
    input[type="text"],input[type="email"],input[type="password"]{width:100%;padding:12px 14px;border-radius:10px;border:1px solid #e6edf8;background:#fbfdff;color:#06202a;font-size:15px;margin-bottom:10px}
    .btn{display:inline-block;width:100%;padding:12px;border-radius:10px;border:0;background:#0b63ff;color:#fff;font-weight:700;cursor:pointer}
    .muted{font-size:13px;color:var(--muted)}
    .link{color:var(--blue);text-decoration:underline;font-weight:600}
    @media(max-width:980px){.panel{grid-template-columns:1fr;}.left{padding:28px}.right{padding:28px}}
  </style>
</head>
<body>
  <div class="panel" role="main">
    <div class="left">
      <h1>Welcome!</h1>
      <p>Daftar sekarang untuk mulai melaporkan dan memantau kasus. Kami menjaga data Anda dengan aman.</p>
      <img src="https://cdn.pixabay.com/photo/2017/08/10/07/03/people-2618263_1280.png" alt="illustration" style="max-width:260px;margin-top:12px;opacity:0.95"/>
      <div style="margin-top:12px"><a class="link" href="{{ route('login.form') }}" style="color:#fff;text-decoration:underline">Already have an account? Sign in</a></div>
    </div>

    <div class="right" aria-labelledby="register-heading">
      <div class="card">
        <h2 id="register-heading">Create account</h2>

        @if ($errors->any())
          <div style="color:#b91c1c;margin-bottom:8px">Periksa input Anda.</div>
        @endif

        <form method="POST" action="{{ route('register.process') }}">
          @csrf

          <label for="name">Your name</label>
          <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
          @error('name') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

          <label for="email">Your e-mail</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required>
          @error('email') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

          <label for="password">Create password</label>
          <input id="password" type="password" name="password" required>
          @error('password') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

          <label for="password_confirmation">Confirm password</label>
          <input id="password_confirmation" type="password" name="password_confirmation" required>

          <button class="btn" type="submit">Create account</button>

          <div style="margin-top:12px;text-align:center">
            <span class="muted">Or</span> <a class="link" href="{{ route('login.form') }}">Sign in</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>