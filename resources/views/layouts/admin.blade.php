<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="#1a1a2e">
    <title>{{ config('restaurant.name') }} — Admin</title>
    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:   #e85d04;
            --primary-d: #c44d00;
            --bg:        #e7e7dd;
            --surface:   #ffffff;
            --border:    #e2e2dd;
            --text:      #1c1c1a;
            --muted:     #6b6b65;
            --success:   #2d6a4f;
            --success-bg:#d8f3dc;
            --danger:    #c1121f;
            --danger-bg: #ffe0e0;
            --warning-bg: #fff3cd;
            --warning:   #856404;
            --radius:    12px;
            --shadow:    0 1px 4px rgba(0,0,0,.08);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 16px;
            line-height: 1.5;
            min-height: 100vh;
        }

        /* ── Topbar ── */
        .topbar {
            background: var(--text);
            color: #fff;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .topbar-brand { font-weight: 700; font-size: 1.1rem; color: var(--primary); }
        .topbar-brand span { color: #fff; font-weight: 400; }
        .topbar-nav a {
            color: rgba(255,255,255,.75);
            text-decoration: none;
            font-size: .85rem;
            padding: 6px 12px;
            border-radius: 6px;
            transition: background .15s;
        }
        .topbar-nav a:hover { background: rgba(255,255,255,.12); }

        /* ── Layout ── */
        .container {
            max-width: 680px;  /* Phone-comfortable width */
            margin: 0 auto;
            padding: 20px 16px 60px;
        }

        /* ── Card ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .card-body { padding: 20px; }

        /* ── Forms ── */
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            font-size: .875rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            background: #fff;
            transition: border-color .15s;
            -webkit-appearance: none;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(232,93,4,.15);
        }
        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { color: var(--danger); font-size: .85rem; margin-top: 4px; }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        @media (max-width: 420px) { .form-row { grid-template-columns: 1fr; } }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .15s, transform .1s;
            -webkit-tap-highlight-color: transparent;
        }
        .btn:active { transform: scale(.97); }
        .btn-primary  { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-d); }
        .btn-outline  { background: transparent; border: 1.5px solid var(--border); color: var(--text); }
        .btn-outline:hover { border-color: #999; }
        .btn-danger   { background: var(--danger); color: #fff; }
        .btn-sm       { padding: 7px 14px; font-size: .875rem; }
        .btn-block    { width: 100%; }
        .btn-icon     { padding: 8px; border-radius: 6px; }

        /* ── Alerts ── */
        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: .95rem;
        }
        .alert-success { background: var(--success-bg); color: var(--success); }
        .alert-danger  { background: var(--danger-bg);  color: var(--danger); }
        .alert-warning  { background: var(--warning-bg);  color: var(--warning); }
        
        /* ── menu items ── */
        .menu-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
        }
        .menu-item:last-child { border-bottom: none; padding-bottom: 0; }
        .menu-info { flex: 1; min-width: 0; }
        .menu-name { font-weight: 600; font-size: 1rem; }
        .menu-desc { font-size: .875rem; color: var(--muted); margin-top: 2px; }
        .menu-price { font-weight: 700; color: var(--primary); white-space: nowrap; }
        .menu-actions { display: flex; gap: 6px; flex-shrink: 0; }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 600;
        }
        .badge-sold-out { background: var(--danger-bg); color: var(--danger); }
        .badge-available { background: var(--success-bg); color: var(--success); }

        /* ── Section headers ── */
        .section-label {
            font-size: .95rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            padding: 8px 20px 4px;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
        }

        /* ── Misc ── */
        .mt-3 { margin-top: 12px; }
        .mt-4 { margin-top: 20px; }
        .mb-4 { margin-bottom: 20px; }
        .text-muted { color: var(--muted); }
        .text-center { text-align: center; }
        .empty-state { padding: 40px 20px; text-align: center; color: var(--muted); }
        .empty-state-icon { font-size: 2.5rem; margin-bottom: 10px; }

        /* ── Delete confirm (tiny JS-free solution) ── */
        .delete-form { display: inline; }
    </style>
    <!-- @stack('styles') -->
</head>
<body>
    <nav class="topbar">
        <a href="{{ route('admin.menu-items.index') }}" class="topbar-brand" style="text-decoration: none;">
            🍽 <span>{{ config('restaurant.name') }}</span>
        </a>
        <div class="topbar-nav">
            @auth
                <a href="{{ route('admin.menu-items.index') }}">Home</a>
                <a href="{{ route('admin.qr.show') }}">QR Code</a>
                <a href="{{ route('menu.today') }}" target="_blank">Preview ↗</a>
                <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" style="background:none;border:none;cursor:pointer;color:rgba(255,255,255,.6);font-size:.85rem;padding:6px 12px;">Sign out</button>
                </form>
            @endauth
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        @yield('content')
    </div>

</body>
</html>
