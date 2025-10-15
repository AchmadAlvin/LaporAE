<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
</head>
<body>

    <h1>Buat Akun Baru</h1>

    {{-- Menampilkan pesan sukses jika ada --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="/register" method="POST">
        @csrf  <div>
            <label for="name">Nama Lengkap:</label><br>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div>
            <label for="email">Alamat Email:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
            @error('password')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div>
            <label for="password_confirmation">Konfirmasi Password:</label><br>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <br>
        <button type="submit">Daftar</button>
    </form>

</body>
</html>