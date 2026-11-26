<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Digital Library') — LiteraHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/telyu.css') }}" rel="stylesheet">
</head>
<body>

<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <div class="d-flex align-items-center">
            <a class="brand" href="{{ route('publishers.index') }}">
                <span class="brand-mark"><i class="bi bi-book-half"></i></span>
                <span class="brand-text">
                    <strong>LiteraHub</strong>
                    <small>Digital Library</small>
                </span>
            </a>
            <button type="button" class="sidebar-close" id="sidebarClose" aria-label="Tutup menu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        @auth
            <p class="sidebar-section">Menu Utama</p>
            <nav class="side-nav">
                <a href="{{ route('publishers.index') }}"
                   class="side-link {{ request()->routeIs('publishers.index') ? 'active' : '' }}">
                    <i class="bi bi-collection"></i>
                    <span>Data Penerbit</span>
                </a>
                <a href="{{ route('publishers.create') }}"
                   class="side-link {{ request()->routeIs('publishers.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span>Tambah Penerbit</span>
                </a>
            </nav>

            <div class="sidebar-foot">
                <div class="user-card">
                    <span class="user-avatar">{{ Str::substr(auth()->user()->name, 0, 1) }}</span>
                    <div class="user-meta">
                        <strong>{{ auth()->user()->name }}</strong>
                        <small>{{ auth()->user()->email }}</small>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="logout-btn" title="Keluar" aria-label="Keluar">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </aside>

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <div class="main">
        <header class="topbar">
            <button type="button" class="menu-toggle" id="menuToggle" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>

            <div class="breadcrumb-line">
                <small>LiteraHub</small>
                <strong>@yield('heading', 'Dashboard')</strong>
            </div>

            <div class="topbar-right">
                <span class="topbar-date">{{ now()->format('d M Y') }}</span>
                @auth
                    <span class="topbar-role"><i class="bi bi-shield-check"></i> Administrator</span>
                @endauth
            </div>
        </header>

        <main class="content">
            @if (session('success'))
                <div class="flash" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="flash-close" aria-label="Tutup">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const openBtn = document.getElementById('menuToggle');
        const closeBtn = document.getElementById('sidebarClose');

        function setSidebar(open) {
            if (!sidebar || !backdrop) return;
            sidebar.classList.toggle('is-open', open);
            backdrop.classList.toggle('is-visible', open);
            document.body.style.overflow = open ? 'hidden' : '';
        }

        openBtn?.addEventListener('click', () => setSidebar(true));
        closeBtn?.addEventListener('click', () => setSidebar(false));
        backdrop?.addEventListener('click', () => setSidebar(false));

        document.querySelectorAll('.flash-close').forEach((btn) => {
            btn.addEventListener('click', () => btn.closest('.flash')?.remove());
        });
    })();
</script>
@stack('scripts')

</body>
</html>
