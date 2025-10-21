<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/><meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Create account - {{ env('APP_NAME','LaporAE') }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <main class="panel split">
    <section class="left">
      <div class="illustration-wrap">
        <img class="illustration" src="https://cdn.pixabay.com/photo/2017/08/10/07/03/people-2618263_1280.png" alt="illustration">
      </div>
      <div class="left-text">
        <h1>Welcome!</h1>
        <p>Daftar sekarang untuk mulai melaporkan dan memantau kasus. Kami menjaga data Anda dengan aman.</p>
        <a class="link-plain" href="{{ route('login.form') }}">Already have an account? Sign in</a>
      </div>
    </section>

    <section class="right">
      <div class="form-card register-card">
        <h2>Create account</h2>

        @if($errors->any())
          <div class="alert alert-danger">Periksa input Anda.</div>
        @endif

        <form method="POST" action="{{ route('register.process') }}">
          @csrf

          <input class="form-input" type="text" name="name" placeholder="Your name" value="{{ old('name') }}" required autofocus>
          @error('name') <div class="field-error">{{ $message }}</div> @enderror

          <input class="form-input" type="email" name="email" placeholder="Your e-mail" value="{{ old('email') }}" required>
          @error('email') <div class="field-error">{{ $message }}</div> @enderror

          <input class="form-input" type="password" name="password" placeholder="Create password" required minlength="1" aria-describedby="passwordHelp">
          @error('password') <div class="field-error">{{ $message }}</div> @enderror
          <div id="passwordHelp" style="font-size:13px;color:#6b7280;margin-bottom:8px">Minimal 1 karakter.</div>

          <input class="form-input" type="password" name="password_confirmation" placeholder="Confirm password" required minlength="1">

          <label class="admin-check"><input type="checkbox" name="is_admin" value="1"> Register as admin</label>

          <div class="actions">
            <button class="btn btn-yellow" type="submit">Create account</button>
            <a class="btn btn-outline-light" href="{{ route('login.form') }}">Sign in</a>
          </div>

          <p class="muted-center">Or <a class="link-plain" href="{{ route('login.form') }}">Sign in</a></p>
        </form>
      </div>
    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
