<!doctype html>

<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Sign In - {{ config('app.name', 'LaporAE') }}</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f3f7ff;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .panel {
      display: grid;
      grid-template-columns: 1fr 1fr;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 15px 40px rgba(0,0,0,0.08);
      max-width: 1000px;
      width: 100%;
    }
    .left {
      background: linear-gradient(180deg, #0b63ff, #0650d6);
      color: #fff;
      padding: 50px;
      text-align: center;
    }
    .left img {
      width: 250px;
      margin-bottom: 20px;
    }
    .right {
      padding: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .form-card {
      width: 100%;
      max-width: 380px;
    }
    .form-input {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: 1px solid #e5e7eb;
      margin-bottom: 15px;
    }
    .form-input:focus {
      border-color: #0b63ff;
      outline: none;
      box-shadow: 0 0 0 2px rgba(11,99,255,0.15);
    }
    .btn-primary {
      background-color: #0b63ff;
      border: none;
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      font-weight: 600;
    }
    .btn-primary:hover {
      background-color: #0650d6;
    }
    .muted-center {
      text-align: center;
      font-size: 14px;
      color: #6b7280;
      margin-top: 20px;
    }
    .muted-center a {
      color: #0b63ff;
      text-decoration: underline;
      font-weight: 600;
    }
    @media (max-width: 900px) {
      .panel { grid-template-columns: 1fr; }
      .left { display: none; }
    }
  </style>

</head>

<body>
  <div class="panel">
    <section class="left">
      <img src="https://cdn.pixabay.com/photo/2017/08/10/07/03/people-2618263_1280.png" alt="Illustration">
      <h2>Selamat Datang Kembali!</h2>
      <p>Masuk untuk melaporkan, memantau status, dan berinteraksi dengan tim. Data Anda aman.</p>
      <a class="text-white fw-bold" href="{{ route('register.form') }}">Belum punya akun? Daftar</a>
    </section>
<section class="right">
  <div class="form-card">
    <h3 class="text-center mb-4">Masuk Akun</h3>

    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
      @csrf
      <input id="email" name="email" type="email" class="form-input" value="{{ old('email') }}" placeholder="Alamat Email" required autofocus>
      <input id="password" name="password" type="password" class="form-input" placeholder="Kata Sandi" required>

      <label for="captcha_answer" class="form-label">Pertanyaan: {{ $captchaQuestion ?? 'Loading...' }}</label>
      <input id="captcha_answer" name="captcha_answer" type="number" class="form-input" placeholder="Jawaban" required>

      <button type="submit" class="btn btn-primary">Masuk</button>
    </form>

    <p class="muted-center">Belum punya akun? <a href="{{ route('register.form') }}">Daftar Sekarang</a></p>
  </div>
</section>

  </div>
</body>
</html>
