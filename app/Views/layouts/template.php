<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Celestia Bibliotheca' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Raleway:wght@300;400&display=swap" rel="stylesheet">
    <style>
        /* ── RESET & BASE ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold: #C9A84C;
            --gold-light: #E8C96A;
            --gold-dim: #7A6030;
            --ivory: #F0EBE0;
            --deep-navy: #04060F;
            --mid-navy: #0A0E20;
            --moon-silver: #D4D0C8;
            --text-dim: rgba(240,235,224,0.55);
        }

        html, body {
        width: 100%; 
        min-height: 100vh; /* Biarkan tumbuh menyesuaikan konten */
        background: var(--deep-navy);
        color: var(--ivory);
        font-family: 'EB Garamond', serif;
        overflow-x: hidden;
        display: flex;
        flex-direction: column;
   }

        /* ── STARFIELD BACKGROUND ── */
        #starfield {
            position: fixed; inset: 0; z-index: 0;
            pointer-events: none;
        }

        /* ── GLOBAL LAYOUT WRAPPER ── */
        main {
            flex: 1; /* Pushes footer to the bottom */
            position: relative;
            z-index: 10;
            padding-top: 80px; /* Space for fixed navbar */
            min-height: calc(100vh - 100px);
        }

        /* ── NAV ── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 22px 56px;
            background: linear-gradient(to bottom, rgba(4,6,15,0.95) 0%, rgba(4,6,15,0.8) 70%, transparent 100%);
            backdrop-filter: blur(8px);
        }
        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            font-family: 'Cinzel', serif; font-size: 13px; letter-spacing: 0.18em;
            color: var(--gold); text-transform: uppercase; text-decoration: none;
        }
        .nav-logo svg { width: 22px; height: 22px; }
        
        .nav-links { display: flex; gap: 36px; }
        .nav-links a {
            font-family: 'Raleway', sans-serif; font-size: 12px;
            letter-spacing: 0.12em; color: var(--ivory); text-decoration: none;
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
            color: var(--deep-navy); background: var(--gold);
            border: 1px solid var(--gold); padding: 10px 24px;
        }
        .btn-primary:hover { background: var(--gold-light); border-color: var(--gold-light); }
        
        .btn-outline {
            color: var(--ivory); background: rgba(4,6,15,0.5);
            border: 1px solid rgba(201,168,76,0.4); padding: 10px 24px;
        }
        .btn-outline:hover { border-color: var(--gold); color: var(--gold); }

        .btn-ghost {
            font-family: 'Raleway', sans-serif; font-size: 12px;
            letter-spacing: 0.16em; text-transform: uppercase; color: var(--ivory);
            background: none; border: none; cursor: pointer; text-decoration: none;
            opacity: 0.6; transition: opacity 0.2s;
        }
        .btn-ghost:hover { opacity: 1; color: var(--gold-light); }

        /* ── FOOTER ── */
        footer {
            position: relative; z-index: 10;
            padding: 40px 56px;
            border-top: 1px solid rgba(201,168,76,0.12);
            display: flex; justify-content: space-between; align-items: center;
            background: var(--deep-navy);
        }
        .footer-logo {
            font-family: 'Cinzel', serif; font-size: 14px;
            letter-spacing: 0.16em; color: var(--gold);
        }
        .footer-links { display: flex; gap: 28px; }
        .footer-links a {
            font-family: 'Raleway', sans-serif; font-size: 11px;
            letter-spacing: 0.1em; color: var(--text-dim);
            text-decoration: none; transition: color 0.2s;
        }
        .footer-links a:hover { color: var(--gold); }
        .footer-copy {
            font-size: 11px; color: var(--text-dim);
            font-family: 'Raleway', sans-serif;
        }

        /* ── FLASH MESSAGES GLOBAL ── */
        .alert {
            padding: 15px 20px; margin: 20px 56px; border-radius: 4px;
            font-family: 'Raleway', sans-serif; font-size: 13px; letter-spacing: 0.05em;
            border: 1px solid transparent;
        }
        .alert-success { background: rgba(40, 167, 69, 0.1); border-color: #28a745; color: #28a745; }
        .alert-error { background: rgba(220, 53, 69, 0.1); border-color: #dc3545; color: #ff6b6b; }

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

<?php 
    $session = session();
    $isLoggedIn = $session->get('logged_in');
    $role = $session->get('role'); // Expected: 'admin' or 'user'
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
        <?php if ($isLoggedIn): ?>
            <span class="btn-ghost" style="cursor:default;">✦ <?= esc($session->get('username')) ?></span>
            <a href="<?= base_url('logout') ?>" class="btn-outline" style="border-color: rgba(220,53,69,0.5); color: #ff6b6b;">Depart</a>
        <?php else: ?>
            <a href="<?= base_url('login') ?>" class="btn-ghost">Login</a>
            <a href="<?= base_url('register') ?>" class="btn-primary">Register Here</a>
        <?php endif; ?>
    </div>
</nav>

<main>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">✦ <?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
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
(function() {
    const canvas = document.getElementById('starfield');
    const ctx = canvas.getContext('2d');
    let W, H, stars = [], angle = 0;

    function resize() {
        W = canvas.width = window.innerWidth;
        H = canvas.height = window.innerHeight * 1.5; // Enough to cover standard scrolling
    }

    function createStars() {
        stars = [];
        const count = Math.floor(W * H / 3000);
        for (let i = 0; i < count; i++) {
            stars.push({
                x: Math.random() * W,
                y: Math.random() * H,
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
        bg.addColorStop(0, '#04060F');
        bg.addColorStop(0.3, '#07091A');
        bg.addColorStop(0.7, '#060815');
        bg.addColorStop(1, '#04060F');
        ctx.fillStyle = bg;
        ctx.fillRect(0, 0, W, H);

        const nebula = ctx.createRadialGradient(W*0.65, H*0.22, 0, W*0.65, H*0.22, W*0.35);
        nebula.addColorStop(0, 'rgba(80,40,120,0.07)');
        nebula.addColorStop(0.5, 'rgba(40,20,80,0.04)');
        nebula.addColorStop(1, 'transparent');
        ctx.fillStyle = nebula;
        ctx.fillRect(0, 0, W, H);

        t += 0.008;
        stars.forEach(s => {
            s.x += s.drift;
            if (s.x < 0) s.x = W;
            if (s.x > W) s.x = 0;

            const a = s.alpha * (0.5 + 0.5 * Math.sin(t * s.twinkleSpeed * 60 + s.twinklePhase));
            ctx.save();
            if (s.bright) {
                ctx.globalAlpha = a * 0.3;
                ctx.strokeStyle = '#E8C96A';
                ctx.lineWidth = 0.5;
                ctx.beginPath();
                ctx.moveTo(s.x - s.r * 4, s.y);
                ctx.lineTo(s.x + s.r * 4, s.y);
                ctx.moveTo(s.x, s.y - s.r * 4);
                ctx.lineTo(s.x, s.y + s.r * 4);
                ctx.stroke();
            }
            ctx.globalAlpha = a;
            const grad = ctx.createRadialGradient(s.x, s.y, 0, s.x, s.y, s.r);
            grad.addColorStop(0, s.bright ? '#FFF8E0' : '#D4D0C8');
            grad.addColorStop(1, 'transparent');
            ctx.fillStyle = grad;
            ctx.beginPath();
            ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        });
        requestAnimationFrame(draw);
    }

    resize();
    createStars();
    draw();
    window.addEventListener('resize', () => { resize(); createStars(); });
})();
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>