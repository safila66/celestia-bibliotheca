<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Bibliotheca Stellarum') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
    <style>
        /* ── Reset & Base ───────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cosmos:   #08091a;
            --deep:     #0d1025;
            --panel:    #111830;
            --border:   #1e2a50;
            --border2:  #2a3560;
            --gold:     #c9b07a;
            --gold-dim: #7a6840;
            --blue:     #6a9fd8;
            --blue-dim: #3a5080;
            --text:     #e8dfc8;
            --muted:    #7788aa;
            --subtle:   #3a4468;
            --ok:       #40a060;
            --warn:     #c09040;
            --danger:   #c05050;
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: 'EB Garamond', serif;
            background: var(--cosmos);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.7;
        }

        a { color: var(--blue); text-decoration: none; transition: color .2s; }
        a:hover { color: var(--gold); }

        /* ── Navbar ─────────────────────────────────── */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(8,9,26,.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 2rem; height: 60px; gap: 1.5rem;
        }

        .nav-logo {
            font-family: 'Cinzel', serif;
            font-size: .82rem; letter-spacing: .12em;
            color: var(--gold); white-space: nowrap;
            display: flex; align-items: center; gap: .5rem;
        }

        .nav-links { display: flex; gap: .2rem; flex: 1; }

        .nav-link {
            font-family: 'Cinzel', serif;
            font-size: .68rem; letter-spacing: .06em;
            color: var(--muted); padding: .35rem .85rem;
            border-radius: 2px; transition: all .2s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--text); background: var(--panel);
        }

        .nav-search {
            display: flex; align-items: center; gap: .5rem;
            background: var(--deep); border: 1px solid var(--border);
            border-radius: 20px; padding: .35rem 1rem;
            font-size: .72rem; color: var(--subtle);
        }
        .nav-search input {
            background: none; border: none; outline: none;
            color: var(--text); font-family: 'EB Garamond', serif;
            font-size: .78rem; width: 160px;
        }
        .nav-search input::placeholder { color: var(--subtle); }

        .nav-actions { display: flex; align-items: center; gap: .75rem; }

        .nav-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, var(--panel), var(--blue-dim));
            border: 1px solid var(--border2);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cinzel', serif; font-size: .65rem;
            color: var(--blue); cursor: pointer;
        }

        .nav-btn {
            font-family: 'Cinzel', serif; font-size: .65rem;
            letter-spacing: .06em; padding: .35rem 1rem;
            border: 1px solid var(--border2); border-radius: 2px;
            color: var(--blue); background: transparent;
            transition: all .2s; cursor: pointer;
        }
        .nav-btn:hover, .nav-btn.primary {
            background: var(--blue); color: var(--cosmos); border-color: var(--blue);
        }

        /* ── Flash messages ─────────────────────────── */
        .flash {
            padding: .75rem 2rem; font-size: .8rem;
            display: flex; align-items: center; gap: .75rem;
        }
        .flash.success { background: rgba(40,80,40,.4); border-bottom: 1px solid #204030; color: #70c080; }
        .flash.error   { background: rgba(80,20,20,.4); border-bottom: 1px solid #402020; color: #e07070; }

        /* ── Main wrapper ────────────────────────────── */
        .page-wrapper { display: flex; min-height: calc(100vh - 60px); }

        .sidebar {
            width: 220px; flex-shrink: 0;
            background: #0b0e20;
            border-right: 1px solid var(--border);
            padding: 1.5rem 0;
        }

        .sidebar-section { margin-bottom: 1.5rem; }
        .sidebar-label {
            font-family: 'Cinzel', serif; font-size: .58rem;
            letter-spacing: .18em; color: var(--subtle);
            text-transform: uppercase; padding: 0 1.2rem .6rem;
        }
        .sidebar-item {
            display: flex; align-items: center; gap: .6rem;
            padding: .55rem 1.2rem; font-size: .78rem; color: var(--muted);
            cursor: pointer; transition: all .2s; position: relative;
        }
        .sidebar-item:hover, .sidebar-item.active {
            background: var(--panel); color: var(--text);
        }
        .sidebar-item.active::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0;
            width: 2px; background: var(--gold);
        }

        main.content { flex: 1; padding: 2rem; }

        /* ── Footer ─────────────────────────────────── */
        .footer {
            background: var(--deep); border-top: 1px solid var(--border);
            padding: 2rem; text-align: center;
        }
        .footer-logo {
            font-family: 'Cinzel', serif; font-size: .85rem;
            color: var(--gold); letter-spacing: .1em; margin-bottom: .5rem;
        }
        .footer-sub { font-size: .72rem; color: var(--subtle); font-style: italic; }

        /* ── Dropdown ────────────────────────────────── */
        .dropdown { position: relative; }
        .dropdown-menu {
            position: absolute; right: 0; top: calc(100% + 8px);
            background: var(--panel); border: 1px solid var(--border2);
            border-radius: 4px; min-width: 180px; z-index: 200;
            display: none; flex-direction: column; overflow: hidden;
        }
        .dropdown:hover .dropdown-menu { display: flex; }
        .dropdown-item {
            padding: .6rem 1rem; font-size: .75rem; color: var(--muted);
            transition: all .2s; border-bottom: 1px solid var(--border);
        }
        .dropdown-item:last-child { border-bottom: none; }
        .dropdown-item:hover { background: var(--deep); color: var(--text); }

        /* ── Utilities ────────────────────────────────── */
        .section-header {
            display: flex; align-items: center; gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .section-title {
            font-family: 'Cinzel', serif; font-size: .75rem;
            letter-spacing: .12em; color: var(--gold-dim);
            text-transform: uppercase;
        }
        .section-line { flex: 1; height: 1px; background: var(--border); }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <a href="/" class="nav-logo">✦ <span>Bibliotheca Stellarum</span></a>

    <div class="nav-links">
        <a href="/" class="nav-link <?= current_url() === base_url('/') ? 'active' : '' ?>">Beranda</a>
        <a href="/catalog" class="nav-link <?= str_contains(current_url(), 'catalog') ? 'active' : '' ?>">catalog</a>
        <a href="/collections" class="nav-link">Koleksi</a>
        <a href="/reading-rooms" class="nav-link">Ruang Baca</a>
        <a href="/archives" class="nav-link">Arsip</a>
        <a href="/about" class="nav-link">Tentang</a>
    </div>

    <form action="/catalog" method="get" class="nav-search">
        <span>🔭</span>
        <input type="text" name="q" placeholder="Cari koleksi..." value="<?= esc(request()->getGet('q') ?? '') ?>">
    </form>

    <div class="nav-actions">
        <?php if (session()->get('user_id')): ?>
            <div class="dropdown">
                <div class="nav-avatar"><?= strtoupper(substr(session()->get('user_name'), 0, 2)) ?></div>
                <div class="dropdown-menu">
                    <a href="/profil" class="dropdown-item">👤 Profil Saya</a>
                    <a href="/peminjaman-saya" class="dropdown-item">📋 Peminjaman</a>
                    <a href="/daftar-bacaan" class="dropdown-item">⭐ Daftar Bacaan</a>
                    <a href="/logout" class="dropdown-item" style="color:var(--danger)">↩ Keluar</a>
                </div>
            </div>
        <?php else: ?>
            <a href="/login" class="nav-btn">Masuk</a>
            <a href="/register" class="nav-btn primary">Daftar</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Flash -->
<?php if (session()->getFlashdata('success')): ?>
<div class="flash success">✦ <?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="flash error">✗ <?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<!-- Content -->
<?= $this->renderSection('content') ?>

<!-- Footer -->
<footer class="footer">
    <div class="footer-logo">✦ Bibliotheca Stellarum</div>
    <div class="footer-sub">Ad astra per libros &mdash; Menuju bintang melalui buku</div>
</footer>

<?= $this->renderSection('scripts') ?>
</body>
</html>