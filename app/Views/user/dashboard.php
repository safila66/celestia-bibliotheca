<?= $this->extend('user/template') ?>

<?= $this->section('styles') ?>
<style>
    /* Hero */
    .hero {
        background: linear-gradient(180deg, #111830 0%, #0d1025 70%, var(--cosmos) 100%);
        padding: 5rem 2rem 4rem; text-align: center;
        position: relative; overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .hero-stars {
        position: absolute; inset: 0;
        background-image:
            radial-gradient(circle, rgba(255,255,255,.6) 1px, transparent 1px),
            radial-gradient(circle, rgba(201,176,122,.3) 1px, transparent 1px),
            radial-gradient(circle, rgba(106,159,216,.2) 1px, transparent 1px);
        background-size: 90px 80px, 150px 120px, 220px 180px;
        background-position: 20px 10px, 70px 40px, 110px 60px;
        pointer-events: none; animation: drift 40s linear infinite;
    }
    @keyframes drift { to { background-position: 110px 10px, 220px 40px, 330px 60px; } }

    .hero-content { position: relative; max-width: 680px; margin: 0 auto; }
    .hero-eyebrow {
        font-family: 'Cinzel', serif; font-size: .65rem;
        letter-spacing: .25em; color: var(--muted);
        text-transform: uppercase; margin-bottom: 1.2rem;
    }
    .hero-title {
        font-family: 'Cinzel', serif; font-size: 2.8rem;
        color: var(--gold); letter-spacing: .1em;
        line-height: 1.2; margin-bottom: 1rem;
    }
    .hero-subtitle {
        font-style: italic; font-size: 1.05rem;
        color: var(--muted); margin-bottom: 2rem;
    }
    .hero-search {
        max-width: 500px; margin: 0 auto;
        display: flex; gap: 0;
        background: var(--deep); border: 1px solid var(--border2);
        border-radius: 3px; overflow: hidden;
    }
    .hero-search input {
        flex: 1; background: none; border: none; outline: none;
        color: var(--text); font-family: 'EB Garamond', serif;
        font-size: .92rem; padding: .85rem 1.2rem;
    }
    .hero-search input::placeholder { color: var(--subtle); }
    .hero-search button {
        background: var(--gold-dim); border: none; cursor: pointer;
        color: var(--cosmos); font-family: 'Cinzel', serif;
        font-size: .68rem; letter-spacing: .1em;
        padding: 0 1.4rem; transition: background .2s;
    }
    .hero-search button:hover { background: var(--gold); }
    .hero-stats {
        display: flex; justify-content: center; gap: 3rem;
        margin-top: 2.5rem;
    }
    .hero-stat-val {
        font-family: 'Cinzel', serif; font-size: 1.6rem;
        color: var(--gold); display: block;
    }
    .hero-stat-lbl { font-size: .72rem; color: var(--muted); font-style: italic; }

    /* Section */
    .section { padding: 3rem 2rem; }
    .section-header-flex {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.8rem;
    }
    .section-title-main {
        font-family: 'Cinzel', serif; font-size: .9rem;
        color: var(--gold); letter-spacing: .1em;
    }
    .section-link {
        font-family: 'Cinzel', serif; font-size: .65rem;
        letter-spacing: .08em; color: var(--muted);
    }
    .section-link:hover { color: var(--gold); }

    /* Book Grid */
    .book-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 1.2rem;
    }
    .book-card {
        background: var(--panel); border: 1px solid var(--border);
        border-radius: 3px; overflow: hidden; transition: all .25s; cursor: pointer;
    }
    .book-card:hover { border-color: var(--border2); transform: translateY(-3px); }
    .book-cover {
        height: 90px; display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem;
    }
    .cover-cosmos { background: linear-gradient(135deg, #0d1030, #1a2050); }
    .cover-myth   { background: linear-gradient(135deg, #1a0d30, #2a1550); }
    .cover-sci    { background: linear-gradient(135deg, #0d2030, #0a3050); }
    .cover-lit    { background: linear-gradient(135deg, #201530, #302050); }
    .book-info { padding: .8rem; }
    .book-title {
        font-family: 'Cinzel', serif; font-size: .72rem;
        color: var(--gold); margin-bottom: .3rem; line-height: 1.4;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .book-author { font-size: .68rem; color: var(--muted); font-style: italic; }
    .book-meta { display: flex; justify-content: space-between; align-items: center; margin-top: .5rem; }
    .book-stock {
        font-size: .6rem; padding: 1px 6px; border-radius: 10px; border: 1px solid;
    }
    .stock-ok   { color: var(--ok);   border-color: #1a3a20; background: rgba(30,60,30,.4); }
    .stock-out  { color: var(--danger); border-color: #3a1010; background: rgba(50,15,15,.4); }

    /* Categories */
    .cat-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 1rem;
    }
    .cat-card {
        background: var(--panel); border: 1px solid var(--border);
        border-radius: 3px; padding: 1.2rem 1rem; text-align: center;
        transition: all .2s; cursor: pointer;
    }
    .cat-card:hover { border-color: var(--gold-dim); background: #141a35; }
    .cat-icon { font-size: 1.6rem; margin-bottom: .5rem; }
    .cat-name { font-family: 'Cinzel', serif; font-size: .68rem; color: var(--muted); letter-spacing: .06em; }
    .cat-count { font-size: .62rem; color: var(--subtle); margin-top: .2rem; font-style: italic; }

    /* Services quick links */
    .services-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: .8rem;
    }
    .svc-card {
        background: var(--panel); border: 1px solid var(--border);
        border-radius: 3px; padding: 1rem 1.2rem;
        display: flex; align-items: center; gap: .8rem;
        transition: all .2s; cursor: pointer;
    }
    .svc-card:hover { border-color: var(--border2); }
    .svc-icon { font-size: 1.3rem; }
    .svc-name { font-family: 'Cinzel', serif; font-size: .68rem; color: var(--muted); letter-spacing: .05em; }

    /* Section separator */
    .section-sep { border: none; border-top: 1px solid var(--border); margin: 0 2rem; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Hero -->
<section class="hero">
    <div class="hero-stars"></div>
    <div class="hero-content">
        <div class="hero-eyebrow">Perpustakaan Digital</div>
        <h1 class="hero-title">Bibliotheca<br>Stellarum</h1>
        <p class="hero-subtitle">Ad astra per libros — Menuju bintang melalui buku</p>

        <form action="/catalog" method="get" class="hero-search">
            <input type="text" name="q" placeholder="Cari judul, pengarang, atau ISBN...">
            <button type="submit">TELUSURI →</button>
        </form>

        <div class="hero-stats">
            <div>
                <span class="hero-stat-val">1.200+</span>
                <span class="hero-stat-lbl">Koleksi</span>
            </div>
            <div>
                <span class="hero-stat-val">400+</span>
                <span class="hero-stat-lbl">Anggota Aktif</span>
            </div>
            <div>
                <span class="hero-stat-val">8</span>
                <span class="hero-stat-lbl">Layanan</span>
            </div>
        </div>
    </div>
</section>

<!-- Koleksi Unggulan -->
<section class="section">
    <div class="section-header-flex">
        <div class="section-title-main">✦ Koleksi Unggulan</div>
        <a href="/catalog" class="section-link">Lihat semua →</a>
    </div>

    <div class="book-grid">
        <?php if (!empty($featured)): ?>
            <?php
            $covers = ['cover-cosmos','cover-myth','cover-sci','cover-lit'];
            $icons  = ['🌌','⚡','🦉','🔱','☀️','🌙','⭐','🏺'];
            foreach ($featured as $i => $book): ?>
            <a href="/buku/<?= $book['id'] ?>" class="book-card" style="text-decoration:none">
                <div class="book-cover <?= $covers[$i % 4] ?>">
                    <?= $icons[$i % 8] ?>
                </div>
                <div class="book-info">
                    <div class="book-title"><?= esc($book['title']) ?></div>
                    <div class="book-author"><?= esc($book['author']) ?></div>
                    <div class="book-meta">
                        <span class="book-stock <?= $book['stock'] > 0 ? 'stock-ok' : 'stock-out' ?>">
                            <?= $book['stock'] > 0 ? 'Tersedia' : 'Habis' ?>
                        </span>
                        <span style="font-size:.6rem;color:var(--subtle)"><?= $book['year'] ?? '' ?></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--subtle);font-style:italic">
                Belum ada koleksi tersedia.
            </div>
        <?php endif; ?>
    </div>
</section>

<hr class="section-sep">

<!-- Kategori -->
<section class="section">
    <div class="section-header-flex">
        <div class="section-title-main">🏛️ Telusuri Kategori</div>
    </div>
    <div class="cat-grid">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
            <a href="/catalog?kategori=<?= $cat['id'] ?>" class="cat-card" style="text-decoration:none">
                <div class="cat-icon"><?= $cat['icon'] ?? '📚' ?></div>
                <div class="cat-name"><?= esc($cat['name']) ?></div>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <?php $defaults = [['icon'=>'📚','name'=>'Umum'],['icon'=>'🔬','name'=>'Sains'],['icon'=>'🏺','name'=>'Sejarah'],['icon'=>'🎭','name'=>'Sastra'],['icon'=>'📐','name'=>'Teknik'],['icon'=>'🧬','name'=>'Kedokteran']];
            foreach ($defaults as $d): ?>
            <div class="cat-card"><div class="cat-icon"><?= $d['icon'] ?></div><div class="cat-name"><?= $d['name'] ?></div></div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<hr class="section-sep">

<!-- Layanan -->
<?php if (session()->get('user_id')): ?>
<section class="section">
    <div class="section-header-flex">
        <div class="section-title-main">⚡ Layanan Anggota</div>
    </div>
    <div class="services-grid">
        <a href="/book-delivery" class="svc-card" style="text-decoration:none">
            <span class="svc-icon">🚚</span>
            <span class="svc-name">Book Delivery</span>
        </a>
        <a href="/room-booking" class="svc-card" style="text-decoration:none">
            <span class="svc-icon">🏛️</span>
            <span class="svc-name">Room Booking</span>
        </a>
        <a href="/libcafe" class="svc-card" style="text-decoration:none">
            <span class="svc-icon">☕</span>
            <span class="svc-name">LibCafé</span>
        </a>
        <a href="/referensi" class="svc-card" style="text-decoration:none">
            <span class="svc-icon">🔍</span>
            <span class="svc-name">Layanan Referensi</span>
        </a>
        <a href="/sitasi" class="svc-card" style="text-decoration:none">
            <span class="svc-icon">📝</span>
            <span class="svc-name">Panduan Sitasi</span>
        </a>
        <a href="/mendeley-class" class="svc-card" style="text-decoration:none">
            <span class="svc-icon">📖</span>
            <span class="svc-name">Mendeley Class</span>
        </a>
        <a href="/konsultasi" class="svc-card" style="text-decoration:none">
            <span class="svc-icon">💬</span>
            <span class="svc-name">Konsultasi</span>
        </a>
        <a href="/language-class" class="svc-card" style="text-decoration:none">
            <span class="svc-icon">🌐</span>
            <span class="svc-name">Language Class</span>
        </a>
    </div>
</section>
<?php else: ?>
<section class="section" style="text-align:center; padding: 4rem 2rem;">
    <div style="font-family:'Cinzel',serif; font-size:.8rem; color:var(--gold); letter-spacing:.1em; margin-bottom:1rem;">
        ✦ Akses Penuh untuk Anggota
    </div>
    <p style="color:var(--muted); font-size:.9rem; margin-bottom:1.5rem;">
        Login untuk mengakses peminjaman, book delivery, room booking, dan layanan lainnya.
    </p>
    <a href="/login" style="font-family:'Cinzel',serif; font-size:.72rem; letter-spacing:.1em; padding:.7rem 2rem; border:1px solid var(--gold-dim); color:var(--gold); border-radius:2px; margin-right:.75rem;">
        MASUK
    </a>
    <a href="/register" style="font-family:'Cinzel',serif; font-size:.72rem; letter-spacing:.1em; padding:.7rem 2rem; background:var(--gold-dim); color:var(--cosmos); border-radius:2px;">
        DAFTAR GRATIS
    </a>
</section>
<?php endif; ?>

<?= $this->endSection() ?>