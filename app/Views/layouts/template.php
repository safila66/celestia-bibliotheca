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
            --starfield-op:    0;
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

        /* ── LIGHT MODE: Cloud accents ── */
[data-theme="light"] #parchment-overlay {
    background:
        /* Awan kiri atas */
        radial-gradient(ellipse 300px 120px at 8% 8%,  rgba(255,255,255,0.55) 0%, transparent 70%),
        radial-gradient(ellipse 200px 80px  at 18% 5%, rgba(255,255,255,0.4)  0%, transparent 70%),
        radial-gradient(ellipse 150px 60px  at 5% 14%, rgba(255,255,255,0.3)  0%, transparent 70%),

        /* Awan kanan atas */
        radial-gradient(ellipse 280px 100px at 92% 6%,  rgba(255,255,255,0.5)  0%, transparent 70%),
        radial-gradient(ellipse 180px 70px  at 82% 3%,  rgba(255,255,255,0.35) 0%, transparent 70%),
        radial-gradient(ellipse 220px 90px  at 98% 12%, rgba(255,255,255,0.3)  0%, transparent 70%),

        /* Awan tengah atas, tipis */
        radial-gradient(ellipse 400px 80px  at 50% 2%,  rgba(255,255,255,0.25) 0%, transparent 70%),

        /* Awan kiri bawah */
        radial-gradient(ellipse 250px 100px at 3% 88%,  rgba(255,255,255,0.3)  0%, transparent 70%),
        radial-gradient(ellipse 180px 70px  at 12% 95%, rgba(255,255,255,0.2)  0%, transparent 70%),

        /* Awan kanan bawah */
        radial-gradient(ellipse 260px 90px  at 95% 90%, rgba(255,255,255,0.3)  0%, transparent 70%),
        radial-gradient(ellipse 160px 60px  at 85% 96%, rgba(255,255,255,0.2)  0%, transparent 70%),

        /* Tone parchment keseluruhan */
        radial-gradient(ellipse at 20% 20%, rgba(201,168,76,0.06) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 80%, rgba(168,117,42,0.05) 0%, transparent 50%),
        radial-gradient(ellipse at 50% 50%, rgba(237,229,216,0.3) 0%, transparent 70%);
    opacity: 1;
}
        /* ── STARFIELD BACKGROUND (DARK MODE) ── */
        #starfield {
            position: fixed; inset: 0; z-index: 0;
            pointer-events: none;
            opacity: var(--starfield-op);
            transition: opacity 0.6s ease;
        }

        /* Default parchment texture overlay */
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
        
        /* Matikan parchment overlay bawaan saat light mode, pakai gambar overlay tipis */
        [data-theme="light"] #parchment-overlay { 
            opacity: 1; 
            background: rgba(245, 240, 232, 0.15);
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
        }
        .nav-logo svg { width: 22px; height: 22px; }

        .nav-links { display: flex; gap: 36px; }
        .nav-links a {
            font-family: 'Raleway', sans-serif; font-size: 12px;
            letter-spacing: 0.12em; color: var(--text-body); text-decoration: none;
            opacity: 0.7; transition: opacity 0.2s, color 0.2s;
        }
        .nav-links a:hover, .nav-links a.active { opacity: 1; color: var(--gold-light); }

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
            opacity: 0.6; transition: opacity 0.2s;
        }
        .btn-ghost:hover { opacity: 1; color: var(--gold-light); }

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
<body>

<canvas id="starfield"></canvas>
<div id="parchment-overlay"></div>

<?php
    $session    = session();
    $isLoggedIn = $session->get('logged_in');
    $role       = $session->get('role');
?>

<nav>
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
            <a href="<?= base_url('user/catalog') ?>">Catalog</a>
            <a href="<?= base_url('user/wishlist') ?>">My Reading</a>
        <?php else: ?>
            <a href="<?= base_url('/') ?>">Home</a>
            <a href="<?= base_url('catalog') ?>">Catalog</a>
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
            <span class="btn-ghost" style="cursor:default;">✦ <?= esc($session->get('username')) ?></span>
            <a href="<?= base_url('logout') ?>" class="btn-outline" style="border-color:rgba(220,53,69,0.5); color:#ff6b6b;">Depart</a>
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

<footer>
    <div class="footer-logo">✦ Celestia Bibliotheca</div>
    <div class="footer-links">
        <a href="#">Catalog</a>
        <a href="#">Collections</a>
        <a href="#">Reading Rooms</a>
        <a href="#">Privacy</a>
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
        const count = Math.floor(W * H / 3000);
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
        for (let i = 0; i < 18; i++) {
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
        const bg = ctx.createLinearGradient(0, 0, 0, H);
        bg.addColorStop(0, '#04060F'); bg.addColorStop(0.3, '#07091A');
        bg.addColorStop(0.7, '#060815'); bg.addColorStop(1, '#04060F');
        ctx.fillStyle = bg; ctx.fillRect(0, 0, W, H);

        const nebula = ctx.createRadialGradient(W*0.65, H*0.22, 0, W*0.65, H*0.22, W*0.35);
        nebula.addColorStop(0, 'rgba(80,40,120,0.07)');
        nebula.addColorStop(0.5, 'rgba(40,20,80,0.04)');
        nebula.addColorStop(1, 'transparent');
        ctx.fillStyle = nebula; ctx.fillRect(0, 0, W, H);

        t += 0.008;
        stars.forEach(s => {
            s.x += s.drift;
            if (s.x < 0) s.x = W;
            if (s.x > W) s.x = 0;
            const a = s.alpha * (0.5 + 0.5 * Math.sin(t * s.twinkleSpeed * 60 + s.twinklePhase));
            ctx.save();
            if (s.bright) {
                ctx.globalAlpha = a * 0.3;
                ctx.strokeStyle = '#E8C96A'; ctx.lineWidth = 0.5;
                ctx.beginPath();
                ctx.moveTo(s.x - s.r*4, s.y); ctx.lineTo(s.x + s.r*4, s.y);
                ctx.moveTo(s.x, s.y - s.r*4); ctx.lineTo(s.x, s.y + s.r*4);
                ctx.stroke();
            }
            ctx.globalAlpha = a;
            const grad = ctx.createRadialGradient(s.x, s.y, 0, s.x, s.y, s.r);
            grad.addColorStop(0, s.bright ? '#FFF8E0' : '#D4D0C8');
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