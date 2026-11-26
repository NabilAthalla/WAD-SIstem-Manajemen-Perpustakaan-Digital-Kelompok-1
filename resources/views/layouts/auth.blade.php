<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') — LiteraHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/telyu.css') }}" rel="stylesheet">
</head>
<body class="auth-body">

<main class="auth-shell">
    <section class="auth-hero">
        <a class="brand" href="{{ url('/') }}">
            <span class="brand-mark"><i class="bi bi-book-half"></i></span>
            <span class="brand-text">
                <strong>LiteraHub</strong>
                <small>Digital Library</small>
            </span>
        </a>

        <div class="hero-copy">
            <span class="hero-badge"><i class="bi bi-stars"></i> Sistem Manajemen Perpustakaan</span>
            <h1>Kelola penerbit &amp; supplier dalam satu tempat.</h1>
            <p>Catat, perbarui, dan pantau seluruh mitra penerbit perpustakaan Anda dengan alur kerja yang rapi dan mudah.</p>

            <ul class="hero-list">
                <li><i class="bi bi-check2"></i> Kelola data penerbit secara terpusat</li>
                <li><i class="bi bi-check2"></i> Pencarian cepat berdasarkan wilayah</li>
                <li><i class="bi bi-check2"></i> Akses aman khusus administrator</li>
            </ul>
        </div>

        <div class="hero-foot">&copy; {{ date('Y') }} LiteraHub. Semua hak dilindungi.</div>
    </section>

    <section class="auth-panel">
        <div class="auth-card">
            <span class="eyebrow">Selamat datang kembali</span>
            <h2>Masuk ke Dashboard</h2>
            <p class="auth-sub">Gunakan akun administrator Anda untuk mulai mengelola data penerbit.</p>

            @if ($errors->any())
                <div class="alert-soft-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">
                        Email <span class="required">*</span>
                    </label>
                    <div class="input-icon">
                        <i class="bi bi-envelope"></i>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="nama@email.com"
                               autocomplete="email"
                               required
                               autofocus>
                    </div>
                    @error('email')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        Password <span class="required">*</span>
                    </label>
                    <div class="input-icon password-wrap">
                        <i class="bi bi-lock"></i>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Masukkan password"
                               autocomplete="current-password"
                               required>
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-brand auth-submit">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>

            <p class="auth-hint"><i class="bi bi-shield-lock"></i> Akses terbatas untuk administrator.</p>
        </div>
    </section>
</main>

<script>
    (function () {
        const toggle = document.getElementById('togglePassword');
        const input = document.getElementById('password');
        if (!toggle || !input) return;

        toggle.addEventListener('click', function () {
            const visible = input.type === 'text';
            input.type = visible ? 'password' : 'text';
            toggle.querySelector('i').className = visible ? 'bi bi-eye' : 'bi bi-eye-slash';
            toggle.setAttribute('aria-label', visible ? 'Tampilkan password' : 'Sembunyikan password');
        });
    })();
</script>
@stack('scripts')

</body>
</html>
