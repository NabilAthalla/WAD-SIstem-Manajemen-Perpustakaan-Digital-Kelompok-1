<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Anggota & Kartu') - LiteraHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #f3f5f9; color: #1f2937; }
        nav { background: #0f1f3d; color: #fff; padding: 14px 24px; display: flex; align-items: center; gap: 20px; flex-wrap: wrap; border-bottom: 3px solid #c9a227; }
        nav .brand { font-family: 'Playfair Display', Georgia, 'Times New Roman', serif; font-weight: 700; font-size: 24px; color: #fff; text-decoration: none; margin-right: 12px; }
        nav .spacer { margin-right: auto; }
        nav a { color: #dbe7f5; text-decoration: none; padding: 6px 10px; border-radius: 6px; }
        nav a:hover { color: #fff; }
        nav a.active { color: #e6bd3c; font-weight: bold; }
        footer { text-align: center; padding: 20px 16px; background: #fff; border-top: 1px solid #e5e7eb; font-size: 14px; color: #374151; margin-top: 40px; }
        footer b { color: #c9a227; }
        nav form { display: inline; margin: 0; }
        .container { max-width: 1100px; margin: 24px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,.1); margin-bottom: 20px; }
        h1 { margin: 0 0 16px; font-size: 22px; color: #1e3a5f; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 10px 8px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        th { background: #1e3a5f; color: #fff; }
        .btn { display: inline-block; padding: 7px 14px; border: 0; border-radius: 5px; background: #0f8a8a; color: #fff; font-size: 14px; cursor: pointer; text-decoration: none; }
        .btn:hover { opacity: .9; }
        .btn-sm { padding: 4px 9px; font-size: 12px; }
        .btn-gray { background: #6b7280; }
        .btn-blue { background: #2563eb; }
        .btn-red { background: #dc2626; }
        .btn-amber { background: #d97706; }
        .inline { display: inline; }
        label { display: block; font-weight: bold; margin: 12px 0 4px; font-size: 14px; }
        input, select, textarea { width: 100%; padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 5px; font-size: 14px; font-family: inherit; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px; }
        .filters { display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 10px; align-items: end; margin-bottom: 16px; }
        .filters label { margin-top: 0; }
        .alert { padding: 10px 14px; border-radius: 5px; margin-bottom: 16px; font-size: 14px; }
        .alert.success { background: #dcfce7; color: #166534; }
        .alert.error { background: #fee2e2; color: #991b1b; }
        .alert ul { margin: 0; padding-left: 18px; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 12px; color: #fff; }
        .badge-aktif { background: #16a34a; }
        .badge-nonaktif { background: #6b7280; }
        .badge-expired { background: #dc2626; }
        dl { display: grid; grid-template-columns: 200px 1fr; gap: 8px 12px; margin: 0; }
        dt { font-weight: bold; color: #475569; }
        dd { margin: 0; }
        .pagination { display: flex; gap: 4px; list-style: none; padding: 0; margin: 16px 0 0; flex-wrap: wrap; }
        .pagination li a, .pagination li span { display: block; padding: 5px 10px; border: 1px solid #cbd5e1; border-radius: 4px; text-decoration: none; color: #1e3a5f; background: #fff; font-size: 13px; }
        .pagination li.active span { background: #1e3a5f; color: #fff; }
        .pagination li.disabled span { color: #9ca3af; }
        .muted { color: #6b7280; font-size: 13px; }
        @@media (max-width: 700px) {
            .grid, .filters { grid-template-columns: 1fr; }
            dl { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <nav>
        <a class="brand" href="{{ route('members.index') }}">LiteraHub</a>
        <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">Anggota &amp; Kartu</a>
        <a href="{{ route('membership-types.index') }}" class="{{ request()->routeIs('membership-types.*') ? 'active' : '' }}">Tipe Keanggotaan</a>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} <b>LiteraHub</b> &mdash; Sistem Manajemen Perpustakaan Digital
    </footer>
</body>
</html>
