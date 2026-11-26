<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'LiteraHub - Sistem Manajemen Perpustakaan Digital')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0b1220;
            --navy-2: #111b30;
            --gold: #c9a227;
            --gold-soft: #f5d98a;
            --muted: #94a3b8;
        }
        body { font-family: 'Inter', sans-serif; background: #f9f8f5; color: #1e293b; }
        .brand-font { font-family: 'Playfair Display', serif; }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: linear-gradient(180deg, var(--navy) 0%, var(--navy-2) 100%);
            border-bottom: 1px solid rgba(201, 162, 39, .35);
            box-shadow: 0 6px 24px rgba(11, 18, 32, .25);
            padding: .6rem 0;
        }
        .navbar-brand { display: flex; align-items: center; gap: .75rem; padding: 0; }
        .brand-mark {
            width: 40px; height: 40px; border-radius: 11px;
            background: linear-gradient(135deg, #e6c453, #b08d1f);
            display: grid; place-items: center;
            color: var(--navy); font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(201, 162, 39, .35);
        }
        .brand-text { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: #fff; line-height: 1; }
        .brand-text span { color: var(--gold); }
        .brand-sub { display: block; margin-top: 4px; font-family: 'Inter', sans-serif; font-size: .6rem; font-weight: 500; letter-spacing: .2em; text-transform: uppercase; color: var(--muted); }

        .navbar-custom .nav-link {
            position: relative;
            color: #cbd5e1; font-size: .92rem; font-weight: 500;
            padding: .6rem 1rem; border-radius: 8px;
            transition: color .2s, background .2s;
        }
        .navbar-custom .nav-link i { color: var(--muted); transition: color .2s; }
        .navbar-custom .nav-link:hover { color: #fff; background: rgba(255, 255, 255, .06); }
        .navbar-custom .nav-link:hover i { color: var(--gold); }
        .navbar-custom .nav-link.active { color: var(--gold-soft); font-weight: 600; }
        .navbar-custom .nav-link.active i { color: var(--gold); }
        @media (min-width: 992px) {
            .navbar-custom .nav-link.active::after {
                content: ''; position: absolute; left: 1rem; right: 1rem; bottom: -.7rem;
                height: 3px; border-radius: 3px 3px 0 0; background: var(--gold);
            }
        }

        /* Akun */
        .user-btn {
            display: flex; align-items: center; gap: .65rem;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .14);
            color: #fff; border-radius: 999px; padding: .3rem .9rem .3rem .3rem;
            transition: background .2s, border-color .2s;
        }
        .user-btn:hover, .user-btn.show { background: rgba(255, 255, 255, .12); border-color: rgba(201, 162, 39, .6); color: #fff; }
        .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #e6c453, #b08d1f);
            color: var(--navy); font-weight: 700; font-size: .9rem;
            display: grid; place-items: center;
        }
        .user-meta { line-height: 1.15; text-align: left; }
        .user-meta .name { font-size: .85rem; font-weight: 600; }
        .user-meta .role { font-size: .68rem; letter-spacing: .08em; text-transform: uppercase; color: var(--gold-soft); }
        .user-btn::after { margin-left: .2rem; }

        .dropdown-menu-user { border: 0; border-radius: 14px; padding: .5rem; min-width: 250px; box-shadow: 0 16px 40px rgba(11, 18, 32, .22); margin-top: .75rem !important; }
        .dropdown-user-head { padding: .75rem .9rem; }
        .dropdown-user-head .n { font-weight: 600; }
        .dropdown-user-head .e { font-size: .8rem; color: #64748b; }
        .role-badge { display: inline-block; margin-top: .4rem; padding: .15rem .6rem; border-radius: 999px; font-size: .68rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; }
        .role-admin { background: #fef3c7; color: #92400e; }
        .role-pengguna { background: #dbeafe; color: #1e40af; }
        .dropdown-menu-user .dropdown-item { border-radius: 8px; padding: .55rem .9rem; font-size: .9rem; }

        @media (max-width: 991.98px) {
            .navbar-collapse { margin-top: .75rem; padding: .75rem; background: rgba(255, 255, 255, .04); border-radius: 12px; }
            .navbar-custom .nav-link.active { background: rgba(201, 162, 39, .12); }
            .user-btn { margin-top: .75rem; width: 100%; }
        }

        /* ===== KOMPONEN UMUM ===== */
        .btn-gold { background: linear-gradient(135deg, #d4ae3a, #b08d1f); color: #fff; font-weight: 600; border: 0; box-shadow: 0 4px 12px rgba(201, 162, 39, .3); transition: transform .15s, box-shadow .15s; }
        .btn-gold:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(201, 162, 39, .4); }
        .card-custom { border: 0; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, .06); }
        .table-head th { background: var(--navy); color: var(--gold-soft); font-size: .72rem; letter-spacing: .08em; text-transform: uppercase; font-weight: 600; border: 0; }

        .page-header { margin-bottom: 1.75rem; }
        .page-header .crumb { font-size: .78rem; letter-spacing: .08em; text-transform: uppercase; color: var(--gold); font-weight: 600; }
        .page-header h2 { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--navy); margin: .25rem 0 .35rem; }
        .page-header h2::after { content: ''; display: block; width: 56px; height: 3px; background: var(--gold); border-radius: 3px; margin-top: .6rem; }
        .page-header p { color: #64748b; margin: 0; }

        footer.site-footer { background: var(--navy); color: var(--muted); font-size: .85rem; border-top: 1px solid rgba(201, 162, 39, .35); }
        footer.site-footer strong { color: var(--gold); }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('buku.index') }}">
            <div class="brand-mark"><i class="bi bi-book-half"></i></div>
            <div>
                <div class="brand-text">Litera<span>Hub</span></div>
                <small class="brand-sub">Perpustakaan Digital</small>
            </div>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mx-lg-4 me-auto gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                        <i class="bi bi-journal-bookmark me-1"></i> Katalog & Buku
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-people me-1"></i> Anggota & Kartu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-truck me-1"></i> Penerbit & Supplier</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-building me-1"></i> Fasilitas & Area</a>
                </li>
            </ul>

            @auth
            <div class="dropdown">
                <button class="user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="avatar">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="user-meta">
                        <span class="name d-block">{{ auth()->user()->name }}</span>
                        <span class="role d-block">{{ auth()->user()->role }}</span>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-user">
                    <li class="dropdown-user-head">
                        <div class="n">{{ auth()->user()->name }}</div>
                        <div class="e">{{ auth()->user()->email }}</div>
                        <span class="role-badge {{ auth()->user()->isAdmin() ? 'role-admin' : 'role-pengguna' }}">
                            {{ auth()->user()->role }}
                        </span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </div>
</nav>

<main class="container py-4 flex-grow-1">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<footer class="site-footer py-3 text-center">
    © {{ date('Y') }} <strong>LiteraHub</strong> — Sistem Manajemen Perpustakaan Digital · Kelompok 1
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>