<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Sign in - {{ env('APP_NAME','LaporAE') }}</title>

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
        <h1>Welcome back!</h1>
        <p>Masuk untuk melaporkan, memantau status, dan berinteraksi dengan tim. Data Anda aman.</p>
        <a class="link-plain" href="{{ route('register.form') }}">Create an account</a>
      </div>
    </section>

    <section class="right">
      <div class="form-card">
        <h2>Sign in</h2>

        @if(session('status'))
          <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
          @csrf

          <div class="form-group">
            <label class="sr-only" for="email">Email</label>
            <input id="email" name="email" type="email" class="form-input" value="{{ old('email') }}" placeholder="Your e-mail" required autofocus>
            @error('email') <div class="field-error">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label class="sr-only" for="password">Password</label>
            <input id="password" name="password" type="password" class="form-input" placeholder="Password" required>
            @error('password') <div class="field-error">{{ $message }}</div> @enderror
          </div>

          <div class="helper-row">
            <label class="helper-remember"><input type="checkbox" name="remember"> Remember</label>
            <a class="helper-link" href="{{ url('/password/reset') }}">Forgot password?</a>
          </div>

          <div class="captcha-row">
            <label class="captcha-label"><input type="checkbox" name="captcha" value="1"> I'm not a robot</label>
            @if($errors->has('captcha')) <div class="field-error">{{ $errors->first('captcha') }}</div> @endif
          </div>

          <div class="actions">
            <button class="btn btn-primary-cta" type="submit">Sign in</button>
            <button type="button" class="btn btn-ghost" onclick="location.href='{{ route('register.form') }}'">Create account</button>
          </div>

          <p class="muted-center">Belum punya akun? <a class="link-plain" href="{{ route('register.form') }}">Buat akun</a></p>
        </form>
      </div>
    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>