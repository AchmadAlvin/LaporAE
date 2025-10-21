<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <title>Sign In - {{ config('app.name', 'LaporAE') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    {{-- Bootstrap tidak lagi diperlukan jika kita hanya pakai CSS inline ini --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <style>
        /* CSS Disalin dari register.blade.php untuk konsistensi */
        :root {
            --blue: #0b63ff;
            --blue-dark: #0650d6;
            --muted: #6b7280;
            --text-color: #020617;
            --bg-light: #f3f7ff;
            --border-color: #e6edf8;
            --input-bg: #fff; /* Input background putih */
            --danger: #dc2626;
            --success: #22c55e;
            --placeholder-color: #9ca3af;
        }

        * { box-sizing: border-box; font-family: 'Inter', system-ui, sans-serif; }

        body { margin: 0; min-height: 100vh; background: var(--bg-light); display: flex; align-items: center; justify-content: center; padding: 24px; color: var(--text-color); }

        .container-panel { width: 100%; max-width: 1100px; border-radius: 12px; overflow: hidden; display: grid; grid-template-columns: 1fr 1fr; box-shadow: 0 20px 50px rgba(2, 6, 23, 0.08); background: #fff; }

        /* Gaya Bagian Kiri (Ilustrasi) */
        .left-section {
            padding: 48px;
            background: linear-gradient(180deg, var(--blue), var(--blue-dark));
            color: #fff;
            display: flex;
            flex-direction: column;
            gap: 18px;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .left-section img { max-width: 260px; height: auto; display: block; margin-bottom: 20px; }
        .left-section h2 { margin: 0; font-size: 28px; font-weight: 700; margin-top: 20px; }
        .left-section p { margin: 0; color: rgba(255, 255, 255, 0.9); max-width: 400px; }
        .link-light { color: #fff; text-decoration: none; font-weight: 600; }
        .link-light:hover { text-decoration: underline; }


        /* Gaya Bagian Kanan (Form) */
        .right-section { padding: 48px; background: #fff; color: var(--text-color); display: flex; flex-direction: column; align-items: center; justify-content: center; } /* Background putih */
        .form-wrapper { width: 100%; max-width: 420px; } /* max-width disamakan */
        h2 { text-align: left; margin-bottom: 24px; color: var(--text-color); font-size: 24px; font-weight: 700; } /* Warna teks biasa */
        .form-group { margin-bottom: 16px; }
        .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border-width: 0; }
        label { display: block; font-size: 13px; color: var(--muted); margin-bottom: 6px; } /* Label ditampilkan */
        .form-input { width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid var(--border-color); /* Border biasa */ background: var(--input-bg); color: var(--text-color); font-size: 15px; }
        .form-input::placeholder { color: var(--placeholder-color); opacity: 1; }
        .form-input:focus { outline: none; border-color: var(--blue); box-shadow: 0 0 0 2px rgba(11, 99, 255, 0.2); }
        .btn { display: inline-block; width: 100%; padding: 12px; border-radius: 10px; border: 0; font-weight: 700; cursor: pointer; transition: background-color 0.2s ease, opacity 0.2s ease; text-align: center; }
        .btn-primary { background: var(--blue); color: #fff; /* Tombol biru */ }
        .btn-primary:hover { background: var(--blue-dark); }
        .muted-text { font-size: 13px; color: var(--muted); text-align: center; margin-top: 24px; } /* Warna teks biasa */
        .link-primary { color: var(--blue); text-decoration: none; font-weight: 600; } /* Link biru */
        .link-primary:hover { text-decoration: underline; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .alert-success { background-color: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .alert ul { margin: 0; padding-left: 20px; list-style-type: disc; }
        .field-error { font-size: 13px; color: var(--danger); margin-top: 4px; }

        @media(max-width:980px){ /* Disesuaikan dari 900px */
            .container-panel{ grid-template-columns:1fr; }
            .left-section{ display: none; }
            .right-section{ padding: 28px; }
        }
    </style>
</head>
<body>
    {{-- Menggunakan class container-panel --}}
    <div class="container-panel" role="main">
        <section class="left-section">
             {{-- Pastikan path gambar benar --}}
             <h1>LaporAE</h3>
             <h2>Selamat Datang Kembali!</h2>
             <p>Masuk untuk melaporkan, memantau status, dan berinteraksi dengan tim. Data Anda aman.</p>
             <div style="margin-top:12px">
                <a class="link-light" href="{{ route('register.form') }}">Belum punya akun? Daftar</a>
             </div>
        </section>

        {{-- Menggunakan class right-section --}}
        <section class="right-section" aria-labelledby="login-heading">
             {{-- Menggunakan class form-wrapper --}}
             <div class="form-wrapper">
                 <h2 id="login-heading">Masuk Akun</h2>

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

                    <div class="form-group">
                        <label for="email">Alamat Email</label> {{-- Label ditampilkan --}}
                        <input id="email" name="email" type="email" class="form-input" value="{{ old('email') }}" placeholder="Your e-mail" required autofocus>
                        @error('email') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi</label> {{-- Label ditampilkan --}}
                        <input id="password" name="password" type="password" class="form-input" placeholder="Password" required>
                        @error('password') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="captcha_answer">Pertanyaan: {{ $captchaQuestion ?? 'Loading...' }}</label>
                        <input id="captcha_answer" name="captcha_answer" type="number" class="form-input" placeholder="Jawaban" required>
                        @error('captcha_answer') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Masuk</button>
                 </form>

                 <p class="muted-text">Belum punya akun? <a class="link-primary" href="{{ route('register.form') }}">Daftar Sekarang</a></p>
             </div>
        </section>
    </div>
</body>
</html>