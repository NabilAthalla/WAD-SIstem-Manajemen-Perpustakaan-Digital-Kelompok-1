<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - LiteraHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Tampilan.css') }}">
    <style>
        body { min-height: 100vh; display: flex; align-items: center; justify-content: center;
               background: linear-gradient(160deg, #0b1626 0%, #12233b 55%, #1c3150 100%) !important; padding: 1.5rem; }
        .auth-card { width: 100%; max-width: 440px; border-radius: 18px !important; }
        .auth-brand { font-family: 'Cormorant Garamond', Georgia, serif; font-size: 2.2rem; font-weight: 700; color: #0b1626; }
        .auth-brand span { color: #c8a24a; }
    </style>
</head>
<body>
    <div class="card auth-card border-0 shadow-lg">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="auth-brand">Litera<span>Hub</span></div>
                <p class="mb-0">Sistem Manajemen Perpustakaan Digital</p>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>