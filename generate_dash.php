<?php
$home = file_get_contents('C:\xampp\htdocs\celestia-bibliotheca\app\Views\user\home.php');

// Extract all <style> contents from home.php
preg_match('/<style>(.*?)<\/style>/s', $home, $mStyles);
$homeStyles = $mStyles[1] ?? '';

// Modify homeStyles slightly:
// 1. Remove margin-top: -80px from #hero
$homeStyles = str_replace('margin-top: -80px;', '', $homeStyles);
// 2. Change #hero height from 100vh to 80vh
$homeStyles = str_replace('height: 100vh;', 'height: 80vh;', $homeStyles);

// Get Constellation & Featured Volumes HTML
preg_match('/<section id="hero">.*?<\/section>/s', $home, $mHero);
$heroHtml = $mHero[0] ?? '';

preg_match('/<section>\s*<div class="section-header">\s*<div class="divider-rune">✦<\/div>\s*<h2>Explore the Constellations.*?<\/section>/s', $home, $mConst);
$constHtml = $mConst[0] ?? '';

preg_match('/<section>\s*<div class="section-header">\s*<div class="divider-rune">✦<\/div>\s*<h2>Featured Volumes.*?<\/section>/s', $home, $mVol);
$volHtml = $mVol[0] ?? '';

// Get Swiper JS from home.php
preg_match('/<script src="https:\/\/cdn\.jsdelivr\.net\/npm\/swiper@11\/swiper-bundle\.min\.js"><\/script>.*?<\/script>/s', $home, $mJs);
$homeJs = $mJs[0] ?? '';

$newDash = <<<HTML
<?= \$this->extend('layouts/template') ?>

<?= \$this->section('styles') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
$homeStyles

/* ── SEARCH & STATS SECTION (DASHBOARD) ── */
.dash-header {
    background: linear-gradient(180deg, var(--deep-navy) 0%, #0d1025 100%);
    padding: 120px 20px 60px;
    text-align: center;
    border-bottom: 1px solid rgba(201,168,76,0.15);
    position: relative;
    overflow: hidden;
}
/* Faint crosses pattern from screenshot */
.dash-header::before {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px);
    background-size: 40px 40px;
    opacity: 0.5;
    pointer-events: none;
}
.dash-eyebrow {
    font-family: 'Raleway', sans-serif; font-size: 11px;
    letter-spacing: 0.25em; color: var(--gold-dim);
    text-transform: uppercase; margin-bottom: 16px;
    position: relative; z-index: 2;
}
.dash-title {
    font-family: 'Cinzel', serif; font-size: 48px;
    color: var(--gold); letter-spacing: 0.08em;
    line-height: 1.2; margin-bottom: 12px;
    position: relative; z-index: 2;
    text-shadow: 0 4px 12px rgba(0,0,0,0.5);
}
.dash-subtitle {
    font-style: italic; font-size: 16px;
    color: var(--text-dim); margin-bottom: 40px;
    position: relative; z-index: 2;
}
.dash-search {
    max-width: 540px; margin: 0 auto;
    display: flex; gap: 0;
    background: rgba(4,6,15,0.6); border: 1px solid rgba(201,168,76,0.3);
    border-radius: 4px; overflow: hidden;
    position: relative; z-index: 2;
    transition: border-color 0.3s;
}
.dash-search:focus-within { border-color: var(--gold); }
.dash-search input {
    flex: 1; background: none; border: none; outline: none;
    color: var(--ivory); font-family: 'EB Garamond', serif;
    font-size: 16px; padding: 14px 20px;
}
.dash-search input::placeholder { color: rgba(240,235,224,0.4); }
.dash-search button {
    background: rgba(201,168,76,0.15); border: none; cursor: pointer;
    color: var(--gold); font-family: 'Cinzel', serif; font-weight: 600;
    font-size: 13px; letter-spacing: 0.1em;
    padding: 0 24px; transition: all 0.2s;
}
.dash-search button:hover { background: var(--gold); color: var(--deep-navy); }
.dash-stats {
    display: flex; justify-content: center; gap: 60px;
    margin-top: 50px; position: relative; z-index: 2;
}
.dash-stat-val {
    font-family: 'Cinzel', serif; font-size: 32px;
    color: var(--gold-light); display: block; margin-bottom: 4px;
}
.dash-stat-lbl { font-size: 13px; color: var(--text-dim); font-style: italic; font-family: 'EB Garamond', serif; }

/* ── KOLEKSI UNGGULAN & LAYANAN (DASHBOARD) ── */
.section { padding: 60px 56px; }
.section-header-flex {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 30px; border-bottom: 1px solid rgba(201,168,76,0.2);
    padding-bottom: 10px;
}
.section-title-main {
    font-family: 'Cinzel', serif; font-size: 20px;
    color: var(--gold); letter-spacing: 0.1em;
}
.section-link {
    font-family: 'Raleway', sans-serif; font-size: 11px;
    letter-spacing: 0.1em; color: var(--text-dim); text-transform: uppercase;
    text-decoration: none; transition: color 0.2s;
}
.section-link:hover { color: var(--gold); }

.book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 24px;
}
.book-card {
    background: rgba(4,6,15,0.4); border: 1px solid rgba(201,168,76,0.15);
    border-radius: 6px; overflow: hidden; transition: all 0.3s; cursor: pointer;
}
.book-card:hover { border-color: var(--gold); transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
.book-cover {
    height: 120px; display: flex; align-items: center; justify-content: center;
    font-size: 40px;
}
.cover-cosmos { background: linear-gradient(135deg, #0d1030, #1a2050); }
.cover-myth   { background: linear-gradient(135deg, #1a0d30, #2a1550); }
.cover-sci    { background: linear-gradient(135deg, #0d2030, #0a3050); }
.cover-lit    { background: linear-gradient(135deg, #201530, #302050); }
.book-info { padding: 16px; }
.book-title {
    font-family: 'Cinzel', serif; font-size: 15px;
    color: var(--ivory); margin-bottom: 6px; line-height: 1.3;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.book-author { font-size: 13px; color: var(--text-dim); font-style: italic; }
.book-meta { display: flex; justify-content: space-between; align-items: center; margin-top: 12px; }
.book-stock {
    font-size: 10px; padding: 2px 8px; border-radius: 12px; border: 1px solid; text-transform: uppercase; letter-spacing: 0.1em;
}
.stock-ok   { color: #7ec8a0; border-color: rgba(126,200,160,0.4); background: rgba(126,200,160,0.1); }
.stock-out  { color: #e07070; border-color: rgba(224,112,112,0.4); background: rgba(224,112,112,0.1); }

/* Layanan */
.services-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
}
.svc-card {
    background: rgba(4,6,15,0.4); border: 1px solid rgba(201,168,76,0.15);
    border-radius: 6px; padding: 20px;
    display: flex; align-items: center; gap: 16px;
    transition: all 0.3s; cursor: pointer; text-decoration: none;
}
.svc-card:hover { border-color: var(--gold); background: rgba(201,168,76,0.05); transform: translateY(-3px); }
.svc-icon { font-size: 24px; }
.svc-name { font-family: 'Cinzel', serif; font-size: 14px; color: var(--ivory); letter-spacing: 0.05em; }

/* ── LIGHT MODE OVERRIDES ── */
[data-theme="light"] .dash-header {
    background: #F8F5F0;
}
[data-theme="light"] .dash-header::before {
    background-image: radial-gradient(rgba(0,0,0,0.08) 1px, transparent 1px);
}
[data-theme="light"] .dash-title { color: #A8752A; text-shadow: none; }
[data-theme="light"] .dash-subtitle, [data-theme="light"] .dash-eyebrow { color: #5A4E3A; }
[data-theme="light"] .dash-stat-val { color: #A8752A; }
[data-theme="light"] .dash-stat-lbl { color: #2C2416; }
[data-theme="light"] .dash-search { background: #FFFFFF; border-color: rgba(168,117,42,0.3); }
[data-theme="light"] .dash-search input { color: #2C2416; }
[data-theme="light"] .dash-search input::placeholder { color: rgba(44,36,22,0.4); }

[data-theme="light"] .book-card, [data-theme="light"] .svc-card {
    background: #FFFFFF; border-color: rgba(0,0,0,0.1);
}
[data-theme="light"] .book-title, [data-theme="light"] .svc-name { color: #2C2416; }
[data-theme="light"] .book-author { color: #5A4E3A; }
[data-theme="light"] .section-title-main { color: #A8752A; }
[data-theme="light"] .section-link { color: #A8752A; }
[data-theme="light"] .section-header-flex { border-bottom-color: rgba(0,0,0,0.1); }
</style>
<?= \$this->endSection() ?>

<?= \$this->section('content') ?>

<!-- 1. SEARCH & STATS -->
<section class="dash-header">
    <div class="dash-eyebrow">Perpustakaan Digital</div>
    <h1 class="dash-title">Bibliotheca Stellarum</h1>
    <p class="dash-subtitle">Ad astra per libros — Menuju bintang melalui buku</p>

    <form action="/catalog" method="get" class="dash-search">
        <input type="text" name="q" placeholder="Cari judul, pengarang, atau ISBN...">
        <button type="submit">TELUSURI →</button>
    </form>

    <div class="dash-stats">
        <div>
            <span class="dash-stat-val"><?= number_format(\$total_buku, 0, ',', '.') ?>+</span>
            <span class="dash-stat-lbl">Koleksi</span>
        </div>
        <div>
            <span class="dash-stat-val"><?= number_format(\$total_anggota, 0, ',', '.') ?>+</span>
            <span class="dash-stat-lbl">Anggota Aktif</span>
        </div>
        <div>
            <span class="dash-stat-val"><?= \$total_layanan ?></span>
            <span class="dash-stat-lbl">Layanan</span>
        </div>
    </div>
</section>

<!-- 2. STARRY NIGHT HERO -->
$heroHtml

<!-- 3. KOLEKSI UNGGULAN -->
<section class="section">
    <div class="section-header-flex">
        <div class="section-title-main">✦ Koleksi Unggulan</div>
        <a href="/catalog" class="section-link">Lihat semua →</a>
    </div>

    <div class="book-grid">
        <?php if (!empty(\$featured)): ?>
            <?php
            \$covers = ['cover-cosmos','cover-myth','cover-sci','cover-lit'];
            \$icons  = ['🌌','⚡','🦉','🔱','☀️','🌙','⭐','🏺'];
            foreach (\$featured as \$i => \$book): ?>
            <a href="/book/detail/<?= \$book['id'] ?>" class="book-card" style="text-decoration:none">
                <div class="book-cover <?= \$covers[\$i % 4] ?>">
                    <?= \$icons[\$i % 8] ?>
                </div>
                <div class="book-info">
                    <div class="book-title"><?= esc(\$book['title']) ?></div>
                    <div class="book-author"><?= esc(\$book['author']) ?></div>
                    <div class="book-meta">
                        <span class="book-stock <?= \$book['stock_available'] > 0 ? 'stock-ok' : 'stock-out' ?>">
                            <?= \$book['stock_available'] > 0 ? 'Tersedia' : 'Habis' ?>
                        </span>
                        <span style="font-size:11px;color:var(--text-dim)"><?= \$book['year'] ?? '' ?></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--text-dim);font-style:italic">
                Belum ada koleksi tersedia.
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- 4. EXPLORE THE CONSTELLATIONS -->
$constHtml

<!-- 5. FEATURED VOLUMES -->
$volHtml

<!-- 6. LAYANAN TERPADU -->
<section class="section" style="padding-top: 0;">
    <div class="section-header-flex">
        <div class="section-title-main">⚡ Layanan Anggota</div>
    </div>
    <div class="services-grid">
        <a href="/book-delivery" class="svc-card">
            <span class="svc-icon">🚚</span>
            <span class="svc-name">Book Delivery</span>
        </a>
        <a href="/room-booking" class="svc-card">
            <span class="svc-icon">🏛️</span>
            <span class="svc-name">Room Booking</span>
        </a>
        <a href="/libcafe" class="svc-card">
            <span class="svc-icon">☕</span>
            <span class="svc-name">LibCafé</span>
        </a>
        <a href="/referensi" class="svc-card">
            <span class="svc-icon">🔍</span>
            <span class="svc-name">Layanan Referensi</span>
        </a>
        <a href="/sitasi" class="svc-card">
            <span class="svc-icon">📝</span>
            <span class="svc-name">Panduan Sitasi</span>
        </a>
        <a href="/mendeley-class" class="svc-card">
            <span class="svc-icon">📖</span>
            <span class="svc-name">Mendeley Class</span>
        </a>
        <a href="/konsultasi" class="svc-card">
            <span class="svc-icon">💬</span>
            <span class="svc-name">Konsultasi</span>
        </a>
        <a href="/language-class" class="svc-card">
            <span class="svc-icon">🌐</span>
            <span class="svc-name">Language Class</span>
        </a>
    </div>
</section>

<?= \$this->endSection() ?>

<?= \$this->section('scripts') ?>
$homeJs
<?= \$this->endSection() ?>
HTML;

file_put_contents('C:\xampp\htdocs\celestia-bibliotheca\app\Views\user\dashboard.php', $newDash);
echo "Dashboard generated successfully!";
