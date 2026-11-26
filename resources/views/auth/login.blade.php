<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - LiteraHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100" style="background:#f9f8f5">
    <div class="card shadow border-0 p-4" style="width:100%;max-width:420px;border-radius:16px">
        <h3 class="fw-bold text-center mb-1">Litera<span style="color:#c9a227">Hub</span></h3>
        <p class="text-center text-muted mb-4">Silakan login untuk melanjutkan</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.proses') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Login sebagai</label>
                <select name="role" class="form-select" required>
                    <option value="pengguna" @selected(old('role') === 'pengguna')>Pengguna</option>
                    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            <button class="btn w-100 text-white fw-bold" style="background:#c9a227">Masuk</button>
        </form>

        <p class="text-center mt-3 mb-0 small">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai pengguna</a>
        </p>
    </div>
</body>
</html>