<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Celestia Bibliotheca' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Raleway:wght@300;400&display=swap" rel="stylesheet">
    <style>
        /* ── RESET & BASE ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ════════════════════════════════════════════
            DARK MODE TOKENS (default)
        ════════════════════════════════════════════ */
        :root,
        [data-theme="dark"] {
            --gold:        #C9A84C;
            --gold-light:  #E8C96A;
            --gold-dim:    #7A6030;
            --ivory:       #F0EBE0;
            --deep-navy:   #04060F;
            --mid-navy:    #0A0E20;
            --moon-silver: #D4D0C8;
            --text-dim:    rgba(240,235,224,0.55);

            /* Komponen */
            --bg-body:         #04060F;
            --bg-card:         rgba(4,6,15,0.5);
            --bg-nav:          linear-gradient(to bottom, rgba(4,6,15,0.95) 0%, rgba(4,6,15,0.8) 70%, transparent 100%);
            --bg-footer:       #04060F;
            --border-gold:     rgba(201,168,76,0.15);
            --text-body:       #F0EBE0;
            --text-muted:      rgba(240,235,224,0.55);
            --shadow-card:     0 8px 32px rgba(0,0,0,0.6);
            --starfield-op:    1;
        }

        /* ════════════════════════════════════════════
            LIGHT MODE TOKENS
        ════════════════════════════════════════════ */
        [data-theme="light"] {
            --gold:        #A8752A;
            --gold-light:  #C9943E;
            --gold-dim:    #C9A86A;
            --ivory:       #2C2416;
            --deep-navy:   #F5F0E8;
            --mid-navy:    #EDE5D8;
            --moon-silver: #5A4E3A;
            --text-dim:    rgba(44,36,22,0.6);

            --bg-body:         #F5F0E8;
            --bg-card:         rgba(255,252,245,0.85);
            --bg-nav:          linear-gradient(to bottom, rgba(245,240,232,0.97) 0%, rgba(245,240,232,0.9) 70%, transparent 100%);
            --bg-footer:       #EDE5D8;
            --border-gold:     rgba(168,117,42,0.2);
            --text-body:       #2C2416;
            --text-muted:      rgba(44,36,22,0.6);
            --shadow-card:     0 8px 32px rgba(168,117,42,0.12);
            --starfield-op:    1;
        }

        html, body {
            width: 100%;
            min-height: 100vh;
            background: var(--bg-body);
            color: var(--text-body);
            font-family: 'EB Garamond', serif;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            transition: background 0.5s ease, color 0.5s ease;
        }

        /* ── LIGHT MODE BACKGROUND ── */
        [data-theme="light"] #parchment-overlay {
            opacity: 1;
            background: url('/assets/images/celesthica-light-mode.png') center top / cover no-repeat fixed;
            filter: none;
        }

        /* ── STARFIELD BACKGROUND (DARK MODE) ── */
        #starfield {
            position: fixed; inset: 0; z-index: 0;
            pointer-events: none;
            opacity: var(--starfield-op);
            transition: opacity 0.6s ease;
        }

        /* Default parchment texture overlay (Dark Mode) */
        #parchment-overlay {
            position: fixed; inset: 0; z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(ellipse at 20% 20%, rgba(201,168,76,0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(168,117,42,0.05) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(237,229,216,0.3) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.6s ease, background 0.6s ease;
        }

        /* ── GLOBAL LAYOUT WRAPPER ── */
        main {
            flex: 1;
            position: relative;
            z-index: 10;
            padding-top: 80px;
            min-height: calc(100vh - 100px);
        }

        /* ── NAV ── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 22px 56px;
            background: var(--bg-nav);
            backdrop-filter: blur(8px);
            transition: background 0.5s ease;
        }
        [data-theme="light"] nav {
            border-bottom: 1px solid rgba(168,117,42,0.15);
        }

        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            font-family: 'Cinzel', serif; font-size: 13px; letter-spacing: 0.18em;
            color: var(--gold); text-transform: uppercase; text-decoration: none;
            transition: color 0.3s;
            text-shadow: 0 1px 4px rgba(0,0,0,0.8);
        }
        .nav-logo svg { width: 22px; height: 22px; filter: drop-shadow(0 1px 2px rgba(0,0,0,0.8)); }

        .nav-links { display: flex; gap: 36px; }
        .nav-links a {
            font-family: 'Raleway', sans-serif; font-size: 12px;
            letter-spacing: 0.12em; color: #F0EBE0; text-decoration: none;
            opacity: 0.85; transition: opacity 0.2s, color 0.2s;
            text-shadow: 0 1px 4px rgba(0,0,0,0.8);
        }
        /* Dropdown CSS (Spotify Style) */
        .nav-dropdown { position: relative; display: inline-block; padding: 10px 0; }
        .nav-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--gold-dim); color: var(--deep-navy);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cinzel', serif; font-weight: bold; font-size: 14px;
            cursor: pointer; border: 2px solid transparent; transition: border-color 0.2s;
            overflow: hidden;
        }
        .nav-avatar img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .nav-avatar:hover { border-color: var(--gold); }
        .nav-dropdown-content {
            display: none; position: absolute; right: 0; top: 100%;
            background: #282828; min-width: 200px;
            box-shadow: 0 16px 24px rgba(0,0,0,0.5); border: none;
            z-index: 101; border-radius: 4px; overflow: hidden; padding: 4px;
            margin-top: 8px;
        }
        .nav-dropdown-content.show { display: block; }
        .nav-dropdown-content a {
            color: #EBEBEB; padding: 12px 16px; text-decoration: none; display: block;
            font-family: 'Raleway', sans-serif; font-size: 13px; font-weight: 600;
            letter-spacing: 0.15em; transition: background 0.2s, color 0.2s; border-radius: 2px;
            text-transform: uppercase;
        }
        .nav-dropdown-content a:hover { background: #3E3E3E; color: #fff; }
        .nav-dropdown-content .divider {
            height: 1px; background: #3E3E3E; margin: 4px 0;
        }
        
        [data-theme="light"] .nav-dropdown-content { background: #fff; box-shadow: 0 8px 16px rgba(0,0,0,0.1); border: 1px solid rgba(0,0,0,0.1); }
        [data-theme="light"] .nav-dropdown-content a { color: #333; }
        [data-theme="light"] .nav-dropdown-content a:hover { background: rgba(0,0,0,0.05); }
        [data-theme="light"] .nav-dropdown-content .divider { background: rgba(0,0,0,0.1); }

        .nav-right { display: flex; align-items: center; gap: 18px; }

        /* ── BUTTONS ── */
        .btn-primary, .btn-outline {
            font-family: 'Raleway', sans-serif; font-size: 12px;
            letter-spacing: 0.16em; text-transform: uppercase;
            text-decoration: none; display: inline-block; cursor: pointer;
            transition: all 0.25s; text-align: center;
        }
        .btn-primary {
            color: var(--bg-body); background: var(--gold);
            border: 1px solid var(--gold); padding: 10px 24px;
        }
        .btn-primary:hover { background: var(--gold-light); border-color: var(--gold-light); }

        .btn-outline {
            color: var(--text-body); background: var(--bg-card);
            border: 1px solid rgba(201,168,76,0.4); padding: 10px 24px;
        }
        .btn-outline:hover { border-color: var(--gold); color: var(--gold); }

        .btn-ghost {
            font-family: 'Raleway', sans-serif; font-size: 12px;
            letter-spacing: 0.16em; text-transform: uppercase; color: var(--text-body);
            background: none; border: none; cursor: pointer; text-decoration: none;
            opacity: 0.8; transition: opacity 0.2s;
        }
        .btn-ghost:hover { opacity: 1; color: var(--gold-light); }
        
        nav .btn-ghost {
            color: #F0EBE0;
            text-shadow: 0 1px 4px rgba(0,0,0,0.8);
        }

        /* ── NAV LIGHT MODE ── */
        [data-theme="light"] .nav-links a {
            color: #5A4E3A;
            text-shadow: none;
            opacity: 0.9;
        }
        [data-theme="light"] .nav-links a:hover,
        [data-theme="light"] .nav-links a.active {
            color: #A8752A;
            opacity: 1;
        }
        [data-theme="light"] .nav-logo {
            color: #A8752A;
            text-shadow: none;
        }
        [data-theme="light"] .nav-logo svg {
            filter: none;
        }
        [data-theme="light"] nav .btn-ghost {
            color: #5A4E3A;
            text-shadow: none;
        }
        [data-theme="light"] nav .btn-ghost:hover {
            color: #A8752A;
        }

        /* ── FOOTER ── */
        footer {
            position: relative; z-index: 10;
            padding: 40px 56px;
            border-top: 1px solid var(--border-gold);
            display: flex; justify-content: space-between; align-items: center;
            background: var(--bg-footer);
            transition: background 0.5s ease;
        }
        .footer-logo {
            font-family: 'Cinzel', serif; font-size: 14px;
            letter-spacing: 0.16em; color: var(--gold);
        }
        .footer-links { display: flex; gap: 28px; }
        .footer-links a {
            font-family: 'Raleway', sans-serif; font-size: 11px;
            letter-spacing: 0.1em; color: var(--text-muted);
            text-decoration: none; transition: color 0.2s;
        }
        .footer-links a:hover { color: var(--gold); }
        .footer-copy {
            font-size: 11px; color: var(--text-muted);
            font-family: 'Raleway', sans-serif;
        }

        /* ── FLASH MESSAGES ── */
        .alert {
            padding: 15px 20px; margin: 20px 56px; border-radius: 4px;
            font-family: 'Raleway', sans-serif; font-size: 13px; letter-spacing: 0.05em;
            border: 1px solid transparent;
        }
        .alert-success { background: rgba(40,167,69,0.1); border-color: #28a745; color: #28a745; }
        .alert-error   { background: rgba(220,53,69,0.1); border-color: #dc3545; color: #ff6b6b; }
        
        [data-theme="light"] .alert-success { background: #d4edda; border-color: #c3e6cb; color: #155724; font-weight: bold; }
        [data-theme="light"] .alert-error   { background: #f8d7da; border-color: #f5c6cb; color: #721c24; font-weight: bold; }

        /* ════════════════════════════════════════════
            BOOK FLIP TOGGLE
        ════════════════════════════════════════════ */
        .theme-book-wrap {
            position: relative;
            width: 52px;
            height: 36px;
            cursor: pointer;
            flex-shrink: 0;
        }

        /* Cahaya/aura di belakang buku */
        .book-aura {
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            pointer-events: none;
            transition: opacity 0.5s ease, background 0.5s ease;
            filter: blur(8px);
            z-index: 0;
        }
        [data-theme="dark"]  .book-aura { background: radial-gradient(circle, rgba(180,200,255,0.35) 0%, transparent 70%); opacity: 1; }
        [data-theme="light"] .book-aura { background: radial-gradient(circle, rgba(255,210,80,0.45)  0%, transparent 70%); opacity: 1; }

        /* Sinar kecil di belakang buku */
        .book-rays {
            position: absolute;
            inset: -14px;
            z-index: 0;
            pointer-events: none;
        }
        .book-rays span {
            position: absolute;
            top: 50%; left: 50%;
            width: 2px;
            border-radius: 1px;
            transform-origin: bottom center;
            transition: opacity 0.5s ease, background 0.5s ease, height 0.5s ease;
        }
        /* 8 sinar menyebar */
        .book-rays span:nth-child(1)  { transform: translate(-50%,-100%) rotate(0deg);    height: 10px; }
        .book-rays span:nth-child(2)  { transform: translate(-50%,-100%) rotate(45deg);   height: 8px; }
        .book-rays span:nth-child(3)  { transform: translate(-50%,-100%) rotate(90deg);   height: 10px; }
        .book-rays span:nth-child(4)  { transform: translate(-50%,-100%) rotate(135deg);  height: 8px; }
        .book-rays span:nth-child(5)  { transform: translate(-50%,-100%) rotate(180deg);  height: 10px; }
        .book-rays span:nth-child(6)  { transform: translate(-50%,-100%) rotate(225deg);  height: 8px; }
        .book-rays span:nth-child(7)  { transform: translate(-50%,-100%) rotate(270deg);  height: 10px; }
        .book-rays span:nth-child(8)  { transform: translate(-50%,-100%) rotate(315deg);  height: 8px; }

        [data-theme="dark"]  .book-rays span { background: rgba(180,210,255,0.6); opacity: 0.7; }
        [data-theme="light"] .book-rays span { background: rgba(255,190,40,0.8);  opacity: 1; }

        /* Buku itu sendiri — perspective container */
        .book-toggle {
            position: relative;
            z-index: 1;
            width: 52px;
            height: 36px;
            perspective: 200px;
        }

        /* Inner — yang akan di-flip */
        .book-inner {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }
        [data-theme="light"] .book-inner {
            transform: rotateY(-180deg);
        }

        /* Halaman Depan (Dark — Bulan) & Belakang (Light — Matahari) */
        .book-front,
        .book-back {
            position: absolute;
            inset: 0;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            border-radius: 2px 4px 4px 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Halaman DEPAN = dark mode (bulan, midnight blue) */
        .book-front {
            background: linear-gradient(135deg, #0D1535 0%, #1A2550 40%, #0A0E25 100%);
            border: 1px solid rgba(100,130,220,0.4);
            box-shadow: inset -3px 0 8px rgba(0,0,0,0.5), 2px 0 6px rgba(0,0,0,0.4);
        }

        /* Spine buku kiri (depan) */
        .book-front::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 5px;
            background: linear-gradient(to right, #070A1A, #151D3A);
            border-right: 1px solid rgba(100,130,220,0.25);
        }

        /* Halaman BELAKANG = light mode (matahari, golden) */
        .book-back {
            background: linear-gradient(135deg, #FFF8E8 0%, #F5E8C0 40%, #FAEBD0 100%);
            border: 1px solid rgba(201,168,76,0.5);
            box-shadow: inset -3px 0 8px rgba(168,117,42,0.2), 2px 0 6px rgba(168,117,42,0.15);
            transform: rotateY(180deg);
        }

        .book-back::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 5px;
            background: linear-gradient(to right, #C9943E, #E8C96A);
            border-right: 1px solid rgba(201,168,76,0.4);
        }

        /* ── IKON BULAN (di halaman depan/dark) ── */
        .icon-moon {
            width: 18px;
            height: 18px;
            position: relative;
            margin-left: 4px;
        }
        .icon-moon::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: #D4D0C8;
            box-shadow: 0 0 6px rgba(180,200,255,0.6);
        }
        .icon-moon::after {
            content: '';
            position: absolute;
            top: -2px; right: -2px;
            width: 14px; height: 14px;
            border-radius: 50%;
            background: #0D1535; /* "memotong" bulan jadi sabit */
        }

        /* Bintang kecil di halaman dark */
        .moon-stars {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }
        .moon-stars span {
            position: absolute;
            width: 2px; height: 2px;
            background: rgba(200,220,255,0.8);
            border-radius: 50%;
        }
        .moon-stars span:nth-child(1) { top: 22%; right: 22%; width: 1.5px; height: 1.5px; }
        .moon-stars span:nth-child(2) { top: 60%; right: 30%; }
        .moon-stars span:nth-child(3) { top: 35%; right: 14%; width: 1px; height: 1px; }
        .moon-stars span:nth-child(4) { top: 75%; right: 18%; width: 1.5px; height: 1.5px; }

        /* ── IKON MATAHARI (di halaman belakang/light) ── */
        .icon-sun {
            width: 16px;
            height: 16px;
            position: relative;
            margin-left: 4px;
        }
        .icon-sun::before {
            content: '';
            position: absolute;
            inset: 3px;
            border-radius: 50%;
            background: radial-gradient(circle, #FFD700, #C9943E);
            box-shadow: 0 0 8px rgba(255,200,50,0.8), 0 0 16px rgba(255,160,0,0.4);
        }
        /* Sinar matahari kecil */
        .icon-sun::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(0deg,   transparent 42%, #C9943E 42%, #C9943E 58%, transparent 58%),
                linear-gradient(90deg,  transparent 42%, #C9943E 42%, #C9943E 58%, transparent 58%),
                linear-gradient(45deg,  transparent 44%, #C9943E 44%, #C9943E 56%, transparent 56%),
                linear-gradient(-45deg, transparent 44%, #C9943E 44%, #C9943E 56%, transparent 56%);
            border-radius: 50%;
            opacity: 0.6;
        }

        /* ── TOOLTIP ── */
        .theme-book-wrap::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%);
            background: rgba(4,6,15,0.9);
            color: var(--gold);
            font-family: 'Raleway', sans-serif;
            font-size: 10px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 5px 10px;
            white-space: nowrap;
            border: 1px solid rgba(201,168,76,0.3);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }
        [data-theme="light"] .theme-book-wrap::after {
            background: rgba(245,240,232,0.95);
            color: var(--gold);
        }
        .theme-book-wrap:hover::after { opacity: 1; }

        /* ── ANIMASI FLIP SAAT HOVER ── */
        .theme-book-wrap:hover .book-inner {
            transform: rotateY(-15deg);
        }
        [data-theme="light"] .theme-book-wrap:hover .book-inner {
            transform: rotateY(-180deg) rotateY(15deg);
        }

        @media (max-width: 900px) {
            nav { padding: 18px 24px; }
            .nav-links { display: none; }
            main { padding-top: 60px; }
            footer { flex-direction: column; gap: 18px; text-align: center; }
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>
<script>
    // Profile Dropdown Toggle
    function toggleProfileDropdown(e) {
        e.stopPropagation();
        var dropdown = document.getElementById('profileDropdown');
        if (dropdown) dropdown.classList.toggle('show');
    }
    
    // Close dropdown when clicking outside
    window.addEventListener('click', function() {
        var dropdown = document.getElementById('profileDropdown');
        if (dropdown && dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        }
    });
</script>
<body>

<canvas id="starfield"></canvas>
<div id="parchment-overlay"></div>

<?php
    $session    = session();
    $isLoggedIn = $session->get('logged_in');
    $role       = $session->get('user_role');
?>

<nav>
    <div class="hamburger-menu" onclick="toggleGlobalSidebar()">≡</div>
    <a href="<?= base_url('/') ?>" class="nav-logo">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 2c4.42 0 8 3.58 8 8s-3.58 8-8 8-8-3.58-8-8 3.58-8 8-8z" fill="currentColor" opacity="0.3"/>
            <path d="M12 6c-3.31 0-6 2.69-6 6 0 2.22 1.21 4.16 3 5.19V18a1 1 0 001 1h4a1 1 0 001-1v-.81c1.79-1.03 3-2.97 3-5.19 0-3.31-2.69-6-6-6z" fill="currentColor" opacity="0.7"/>
            <circle cx="12" cy="2" r="1.5" fill="currentColor"/>
        </svg>
        Celestia Bibliotheca
    </a>

    <div class="nav-links">
        <?php if ($role === 'admin'): ?>
            <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a>
            <a href="<?= base_url('admin/books') ?>">Manage Tomes</a>
            <a href="<?= base_url('admin/users') ?>">Scholars</a>
            <a href="<?= base_url('admin/loans') ?>">Circulation</a>
        <?php elseif ($role === 'user'): ?>
            <a href="<?= base_url('/') ?>">The Archive</a>
            <a href="<?= base_url('catalog/categories') ?>">Catalog</a>
            <a href="<?= base_url('catalog') ?>">Collections</a>
            <a href="<?= base_url('readers') ?>">Readers</a>
            <a href="<?= base_url('user/wishlist') ?>">My Reading</a>
        <?php else: ?>
            <a href="<?= base_url('/') ?>">Home</a>
            <a href="<?= base_url('catalog/categories') ?>">Catalog</a>
            <a href="<?= base_url('catalog') ?>">Collections</a>
            <a href="<?= base_url('about') ?>">About</a>
        <?php endif; ?>
    </div>

    <div class="nav-right">

        <div class="theme-book-wrap" id="themeToggle" role="button" aria-label="Toggle theme" data-tooltip="Switch Theme">
            <div class="book-rays">
                <span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span>
            </div>
            <div class="book-aura"></div>
            <div class="book-toggle">
                <div class="book-inner">
                    <div class="book-front">
                        <div class="moon-stars">
                            <span></span><span></span><span></span><span></span>
                        </div>
                        <div class="icon-moon"></div>
                    </div>
                    <div class="book-back">
                        <div class="icon-sun"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($isLoggedIn): ?>
            <?php
                $db = \Config\Database::connect();
                $navUser = $db->table('users')->where('id', session()->get('user_id'))->get()->getRowArray();
            ?>
            <div class="nav-dropdown">
                <div class="nav-avatar" onclick="toggleProfileDropdown(event)">
                    <?php if (!empty($navUser['photo'])): ?>
                        <img src="<?= base_url('uploads/users/' . esc($navUser['photo'])) ?>" alt="Avatar">
                    <?php else: ?>
                        <?= strtoupper(substr(esc($session->get('username') ?? 'U'), 0, 1)) ?>
                    <?php endif; ?>
                </div>
                <div class="nav-dropdown-content" id="profileDropdown">
                    <a href="<?= base_url('profil') ?>">Profil Saya</a>
                    <a href="<?= base_url('loan-saya') ?>">Peminjaman Saya</a>
                    <a href="<?= base_url('my-bookshelf') ?>">My Bookshelf</a>
                    <div class="divider"></div>
                    <a href="<?= base_url('logout') ?>">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="<?= base_url('login') ?>" class="btn-ghost">Login</a>
            <a href="<?= base_url('register') ?>" class="btn-primary">Register Here</a>
        <?php endif; ?>
    </div>
</nav>

<main>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">✦ <?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error">✗ <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</main>

<?= $this->renderSection('modals') ?>

<!-- GLOBAL SIDEBAR -->
<div class="global-sidebar-overlay" id="sidebarOverlay" onclick="toggleGlobalSidebar()"></div>
<div class="global-sidebar" id="globalSidebar">
    <div class="sidebar-header">
        <h2>Menu</h2>
        <button onclick="toggleGlobalSidebar()" style="background:none;border:none;font-size:24px;color:#C4A47C;cursor:pointer;">✕</button>
    </div>
    <div class="sidebar-links">
        <?php if ($isLoggedIn && $role === 'member'): ?>
            <a href="<?= base_url('/') ?>">Dashboard Layanan</a>
            <a href="<?= base_url('my-bookshelf') ?>">My Bookshelf</a>
            <a href="<?= base_url('loan-saya') ?>">Peminjaman Saya</a>
            <a href="<?= base_url('daftar-bacaan') ?>">Daftar Bacaan</a>
            <a href="<?= base_url('profil') ?>">Profil Saya</a>
        <?php elseif ($isLoggedIn && $role === 'admin'): ?>
            <a href="<?= base_url('admin/dashboard') ?>">Admin Dashboard</a>
            <a href="<?= base_url('admin/books') ?>">Kelola Buku</a>
        <?php else: ?>
            <a href="<?= base_url('login') ?>">Masuk</a>
            <a href="<?= base_url('register') ?>">Daftar</a>
        <?php endif; ?>
    </div>
</div>

<style>
/* Hamburger Menu */
.hamburger-menu {
    font-size: 28px;
    color: var(--gold);
    cursor: pointer;
    margin-right: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
}
.hamburger-menu:hover {
    transform: scale(1.1);
}

/* Off-canvas Sidebar */
.global-sidebar {
    position: fixed;
    top: 0; left: -300px;
    width: 280px; height: 100vh;
    background: var(--nav-bg);
    backdrop-filter: blur(20px);
    border-right: 1px solid rgba(201,168,76,0.3);
    z-index: 2000;
    transition: left 0.3s ease;
    display: flex; flex-direction: column;
    box-shadow: 10px 0 30px rgba(0,0,0,0.2);
}
.global-sidebar.open {
    left: 0;
}
.global-sidebar-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(3px);
    z-index: 1999;
    display: none;
    opacity: 0;
    transition: opacity 0.3s;
}
.global-sidebar-overlay.show {
    display: block;
    opacity: 1;
}
.sidebar-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 20px; border-bottom: 1px solid rgba(201,168,76,0.2);
}
.sidebar-header h2 {
    font-family: 'Cinzel', serif; color: var(--gold); margin: 0; font-size: 20px;
}
.sidebar-links {
    padding: 20px; display: flex; flex-direction: column; gap: 15px;
}
.sidebar-links a {
    color: #e2e8f0;
    text-decoration: none;
    font-size: 16px;
    padding: 10px;
    border-radius: 8px;
    transition: 0.2s;
}
.sidebar-links a:hover {
    background: rgba(201,168,76,0.1);
    color: var(--gold);
    padding-left: 15px;
}
</style>

<script>
function toggleGlobalSidebar() {
    document.getElementById('globalSidebar').classList.toggle('open');
    const overlay = document.getElementById('sidebarOverlay');
    if(overlay.classList.contains('show')) {
        overlay.classList.remove('show');
        setTimeout(() => overlay.style.display = 'none', 300);
    } else {
        overlay.style.display = 'block';
        setTimeout(() => overlay.classList.add('show'), 10);
    }
}
</script>

<!-- CHATBOT WIDGET -->
<div class="chatbot-btn" onclick="toggleChatbot()">💬</div>
<div class="chatbot-window" id="chatbotWindow">
    <div class="chatbot-header">
        <div class="chatbot-title">✦ Celestia AI</div>
        <button onclick="toggleChatbot()" style="background:none;border:none;color:var(--gold);cursor:pointer;">✕</button>
    </div>
    <div class="chatbot-body" id="chatbotBody">
        <div class="chat-msg bot">Halo! Saya adalah Asisten AI Celestia. Ada yang bisa saya bantu terkait penelusuran pustaka hari ini?</div>
    </div>
    <div class="chatbot-input">
        <input type="text" id="chatInput" placeholder="Ketik pesan..." onkeypress="handleChatKey(event)">
        <button onclick="sendChat()">➤</button>
    </div>
</div>

<style>
/* Chatbot CSS */
.chatbot-btn {
    position: fixed; bottom: 30px; right: 30px; z-index: 1000;
    width: 60px; height: 60px; border-radius: 50%;
    background: var(--gold); color: var(--deep-navy);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    transition: transform 0.3s;
}
.chatbot-btn:hover { transform: scale(1.1); }
.chatbot-window {
    position: fixed; bottom: 100px; right: 30px; z-index: 1000;
    width: 320px; height: 450px; background: rgba(10, 14, 28, 0.95);
    border: 1px solid rgba(201,168,76,0.3); border-radius: 12px;
    display: flex; flex-direction: column; opacity: 0; pointer-events: none;
    transform: translateY(20px); transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}
[data-theme="light"] .chatbot-window { background: rgba(255, 255, 255, 0.95); }
.chatbot-window.open { opacity: 1; pointer-events: auto; transform: translateY(0); }
.chatbot-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 15px; border-bottom: 1px solid rgba(201,168,76,0.2);
    background: rgba(201,168,76,0.1); border-radius: 12px 12px 0 0;
}
.chatbot-title { font-family: 'Cinzel', serif; color: var(--gold); font-weight: bold; }
.chatbot-body { flex: 1; padding: 15px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px; }
.chat-msg { padding: 10px 14px; border-radius: 12px; font-size: 13px; line-height: 1.4; max-width: 85%; }
.chat-msg.bot { background: rgba(201,168,76,0.1); color: var(--text-body); align-self: flex-start; border-bottom-left-radius: 2px; }
.chat-msg.user { background: var(--gold); color: var(--deep-navy); align-self: flex-end; border-bottom-right-radius: 2px; }
.chatbot-input { display: flex; padding: 10px; border-top: 1px solid rgba(201,168,76,0.2); }
.chatbot-input input {
    flex: 1; background: transparent; border: none; color: var(--text-body);
    padding: 8px 12px; outline: none; font-family: inherit;
}
.chatbot-input button { background: var(--gold); color: var(--deep-navy); border: none; border-radius: 50%; width: 35px; height: 35px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
</style>

<script>
function toggleChatbot() {
    document.getElementById('chatbotWindow').classList.toggle('open');
}
function handleChatKey(e) { if(e.key === 'Enter') sendChat(); }
async function sendChat() {
    const input = document.getElementById('chatInput');
    const msg = input.value.trim();
    if(!msg) return;
    
    input.value = '';
    appendChat('user', msg);
    
    // Show typing...
    const body = document.getElementById('chatbotBody');
    const typing = document.createElement('div');
    typing.className = 'chat-msg bot'; typing.id = 'chatTyping'; typing.innerHTML = '...';
    body.appendChild(typing);
    body.scrollTop = body.scrollHeight;

    try {
        const res = await fetch('/chatbot/ask', {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: msg })
        });
        const data = await res.json();
        document.getElementById('chatTyping').remove();
        appendChat('bot', data.reply);
    } catch(e) {
        document.getElementById('chatTyping').remove();
        appendChat('bot', 'Koneksi ke jaringan konstelasi terputus.');
    }
}
function appendChat(role, text) {
    const body = document.getElementById('chatbotBody');
    const el = document.createElement('div');
    el.className = 'chat-msg ' + role;
    el.innerHTML = text;
    body.appendChild(el);
    body.scrollTop = body.scrollHeight;
}
</script>

<footer>
    <div class="footer-logo">✦ Celestia Bibliotheca</div>
    <div class="footer-links">
        <a href="/catalog/categories">Catalog</a>
        <a href="/catalog">Collections</a>
        <a href="/reading-rooms">Reading Rooms</a>
        <a href="/privacy">Privacy</a>
    </div>
    <div class="footer-copy">© <?= date('Y') ?> Celestia Bibliotheca</div>
</footer>

<script>
/* ── STARFIELD ── */
(function() {
    const canvas = document.getElementById('starfield');
    const ctx    = canvas.getContext('2d');
    let W, H, stars = [];

    function resize() {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight * 1.5;
    }

    function createStars() {
        stars = [];
        // Lebih banyak bintang!
        const count = Math.floor(W * H / 800); 
        for (let i = 0; i < count; i++) {
            stars.push({
                x: Math.random() * W, y: Math.random() * H,
                r: Math.random() * 1.6 + 0.2,
                alpha: Math.random() * 0.7 + 0.15,
                twinkleSpeed: Math.random() * 0.02 + 0.005,
                twinklePhase: Math.random() * Math.PI * 2,
                drift: (Math.random() - 0.5) * 0.04,
            });
        }
        // Lebih banyak bintang terang
        for (let i = 0; i < 40; i++) {
            stars.push({
                x: Math.random() * W, y: Math.random() * H,
                r: Math.random() * 2.5 + 1.5,
                alpha: 0.9, twinkleSpeed: Math.random() * 0.03 + 0.01,
                twinklePhase: Math.random() * Math.PI * 2,
                drift: (Math.random() - 0.5) * 0.02, bright: true
            });
        }
    }

    let t = 0;
    function draw() {
        ctx.clearRect(0, 0, W, H);
        
        const theme = document.documentElement.getAttribute('data-theme') || 'dark';

        if (theme === 'dark') {
            const bg = ctx.createLinearGradient(0, 0, 0, H);
            bg.addColorStop(0, '#04060F'); bg.addColorStop(0.3, '#07091A');
            bg.addColorStop(0.7, '#060815'); bg.addColorStop(1, '#04060F');
            ctx.fillStyle = bg; ctx.fillRect(0, 0, W, H);

            const nebula = ctx.createRadialGradient(W*0.65, H*0.22, 0, W*0.65, H*0.22, W*0.35);
            nebula.addColorStop(0, 'rgba(80,40,120,0.07)');
            nebula.addColorStop(0.5, 'rgba(40,20,80,0.04)');
            nebula.addColorStop(1, 'transparent');
            ctx.fillStyle = nebula; ctx.fillRect(0, 0, W, H);
        }

        t += 0.008;

        // --- CONSTELLATION LINES ---
        ctx.save();
        ctx.lineWidth = 0.3;
        const brightStars = stars.filter(s => s.bright);
        for (let i = 0; i < brightStars.length; i++) {
            for (let j = i + 1; j < brightStars.length; j++) {
                const s1 = brightStars[i];
                const s2 = brightStars[j];
                const dx = s1.x - s2.x;
                const dy = s1.y - s2.y;
                const dist = Math.sqrt(dx*dx + dy*dy);
                if (dist < 180) { // Sambung jika jarak dekat
                    const alpha = (1 - dist / 180) * 0.5 * s1.alpha * s2.alpha; 
                    ctx.strokeStyle = theme === 'light' ? `rgba(229, 184, 92, ${alpha})` : `rgba(232, 201, 106, ${alpha})`;
                    ctx.beginPath();
                    ctx.moveTo(s1.x, s1.y);
                    ctx.lineTo(s2.x, s2.y);
                    ctx.stroke();
                }
            }
        }
        ctx.restore();

        // --- STARS ---
        stars.forEach(s => {
            s.x += s.drift;
            if (s.x < 0) s.x = W;
            if (s.x > W) s.x = 0;
            const a = s.alpha * (0.5 + 0.5 * Math.sin(t * s.twinkleSpeed * 60 + s.twinklePhase));
            ctx.save();
            if (s.bright) {
                ctx.globalAlpha = a * 0.3;
                // Emas lebih cerah untuk light mode agar tidak terlihat seperti jamur
                ctx.strokeStyle = theme === 'light' ? '#E5B85C' : '#E8C96A'; 
                ctx.lineWidth = 0.5;
                ctx.beginPath();
                ctx.moveTo(s.x - s.r*4, s.y); ctx.lineTo(s.x + s.r*4, s.y);
                ctx.moveTo(s.x, s.y - s.r*4); ctx.lineTo(s.x, s.y + s.r*4);
                ctx.stroke();
            }
            ctx.globalAlpha = a;
            const grad = ctx.createRadialGradient(s.x, s.y, 0, s.x, s.y, s.r);
            if (theme === 'light') {
                grad.addColorStop(0, s.bright ? '#E5B85C' : '#F0D495');
            } else {
                grad.addColorStop(0, s.bright ? '#FFF8E0' : '#D4D0C8');
            }
            grad.addColorStop(1, 'transparent');
            ctx.fillStyle = grad;
            ctx.beginPath(); ctx.arc(s.x, s.y, s.r, 0, Math.PI*2); ctx.fill();
            ctx.restore();
        });
        requestAnimationFrame(draw);
    }

    resize(); createStars(); draw();
    window.addEventListener('resize', () => { resize(); createStars(); });
})();

/* ── BOOK THEME TOGGLE ── */
(function() {
    const html   = document.documentElement;
    const toggle = document.getElementById('themeToggle');

    // Ambil preferensi tersimpan, default dark
    const saved = localStorage.getItem('cb-theme') || 'dark';
    html.setAttribute('data-theme', saved);
    updateTooltip(saved);

    toggle.addEventListener('click', function() {
        const current = html.getAttribute('data-theme');
        const next    = current === 'dark' ? 'light' : 'dark';

        // Animasi flip saat klik
        const inner = this.querySelector('.book-inner');
        inner.style.transition = 'transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1)';

        html.setAttribute('data-theme', next);
        localStorage.setItem('cb-theme', next);
        updateTooltip(next);
    });

    function updateTooltip(theme) {
        toggle.setAttribute('data-tooltip',
            theme === 'dark' ? 'Switch to Daylight' : 'Switch to Midnight'
        );
    }
})();
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
