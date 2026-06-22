<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
    .journal-header-band {
        background: #394855; /* Letterboxd-style slate blue/gray */
        padding: 20px 56px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        margin-top: 20px;
    }
    
    .journal-header-title {
        font-family: 'Raleway', sans-serif;
        font-weight: 800;
        font-size: 16px;
        letter-spacing: 0.3em;
        color: #F0EBE0;
    }

    .journal-header-nav {
        display: flex;
        gap: 30px;
    }
    .journal-header-nav a {
        font-family: 'Raleway', sans-serif;
        font-size: 12px;
        color: rgba(240,235,224,0.7);
        text-decoration: none;
        letter-spacing: 0.05em;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .journal-header-nav a:hover {
        color: #fff;
    }

    .journal-hero-section {
        background: #475865; /* Match the Letterboxd featured background */
        padding: 60px 56px;
        display: flex;
        gap: 60px;
        align-items: center;
        min-height: 500px;
    }

    .journal-hero-image {
        flex: 1.2;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    .journal-hero-image img {
        width: 100%;
        height: auto;
        display: block;
        aspect-ratio: 16/9;
        object-fit: cover;
    }

    .journal-hero-content {
        flex: 1;
        text-align: center;
        color: #fff;
        padding-right: 40px;
    }

    .journal-hero-eyebrow {
        font-family: 'EB Garamond', serif;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .journal-hero-title {
        font-family: 'Cinzel', serif;
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .journal-hero-excerpt {
        font-family: 'EB Garamond', serif;
        font-size: 24px;
        line-height: 1.4;
        color: rgba(255,255,255,0.85);
        margin-bottom: 30px;
    }

    .journal-hero-author {
        font-family: 'Raleway', sans-serif;
        font-size: 11px;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.6);
    }

    /* ── LIGHT MODE OVERRIDES ── */
    [data-theme="light"] .journal-header-band {
        background: #E8E2D5;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    [data-theme="light"] .journal-header-title {
        color: #2C2416;
    }
    [data-theme="light"] .journal-header-nav a {
        color: #5A4E3A;
    }
    [data-theme="light"] .journal-hero-section {
        background: #F0EAE0;
    }
    [data-theme="light"] .journal-hero-content {
        color: #2C2416;
    }
    [data-theme="light"] .journal-hero-excerpt {
        color: #4A4030;
    }
    [data-theme="light"] .journal-hero-author {
        color: #7A6A50;
    }
    [data-theme="light"] .journal-hero-title {
        text-shadow: none;
    }

    /* ── LATEST ARTICLES GRID ── */
    .journal-grid-section {
        padding: 60px 56px;
        background: var(--bg-body);
    }
    
    .journal-grid-title {
        font-family: 'Cinzel', serif;
        color: var(--gold);
        font-size: 24px;
        margin-bottom: 30px;
        text-align: center;
        letter-spacing: 0.1em;
    }

    .journal-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }

    .journal-card {
        background: var(--bg-card);
        border: 1px solid rgba(201,168,76,0.15);
        border-radius: 4px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }
    .journal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        border-color: var(--gold);
    }

    .journal-card-img {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .journal-card-body {
        padding: 20px;
    }

    .journal-card-eyebrow {
        font-family: 'EB Garamond', serif;
        font-size: 13px;
        color: var(--gold);
        font-weight: bold;
        margin-bottom: 8px;
    }

    .journal-card-title {
        font-family: 'Cinzel', serif;
        font-size: 18px;
        color: var(--ivory);
        line-height: 1.3;
        margin-bottom: 10px;
    }

    .journal-card-author {
        font-family: 'Raleway', sans-serif;
        font-size: 10px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-dim);
    }

    [data-theme="light"] .journal-card-title {
        color: #2C2416;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Band -->
<div class="journal-header-band">
    <div class="journal-header-title">JOURNAL</div>
    <div class="journal-header-nav">
        <a href="#">Sections <span style="font-size:10px;">▼</span></a>
        <a href="#">Newsletter <span style="font-size:10px;">▼</span></a>
    </div>
</div>

<!-- Featured Hero Article -->
<?php 
$hero = !empty($journals) ? $journals[0] : null; 
if($hero):
?>
<div class="journal-hero-section">
    <div class="journal-hero-image">
        <a href="<?= base_url('mini-journalism/' . $hero['id']) ?>">
            <?php $heroImg = $hero['user_id'] ? 'uploads/journals/' . $hero['cover_image'] : 'assets/images/' . ($hero['cover_image'] ?: 'tides.png'); ?>
            <img src="<?= base_url($heroImg) ?>" alt="<?= esc($hero['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1455390582262-044cdead27d8?auto=format&fit=crop&q=80&w=1000';">
        </a>
    </div>
    <div class="journal-hero-content">
        <div class="journal-hero-eyebrow"><?= esc($hero['type']) ?></div>
        <a href="<?= base_url('mini-journalism/' . $hero['id']) ?>" style="text-decoration:none; color:inherit;">
            <div class="journal-hero-title"><?= esc($hero['title']) ?></div>
        </a>
        <div class="journal-hero-excerpt">
            <?= esc($hero['excerpt']) ?>
        </div>
        <div class="journal-hero-author"><?= esc($hero['author']) ?></div>
    </div>
</div>
<?php endif; ?>

<!-- Latest Articles Grid -->
<div class="journal-grid-section">
    <h2 class="journal-grid-title">LATEST REVIEWS & ARTICLES</h2>
    
    <div class="journal-grid">
        <?php if(!empty($journals)): ?>
            <?php 
            // Skip the first one if it's already shown as hero
            $gridJournals = array_slice($journals, 1);
            foreach($gridJournals as $j): 
            ?>
            <a href="<?= base_url('mini-journalism/' . $j['id']) ?>" class="journal-card">
                <?php $jImg = $j['user_id'] ? 'uploads/journals/' . $j['cover_image'] : 'assets/images/' . ($j['cover_image'] ?: 'vol-fantasy.png'); ?>
                <img class="journal-card-img" src="<?= base_url($jImg) ?>" alt="Article" onerror="this.src='https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&q=80&w=600';">
                <div class="journal-card-body">
                    <div class="journal-card-eyebrow" <?= $j['user_id'] ? 'style="color: #4caf50;"' : '' ?>><?= esc($j['type']) ?></div>
                    <div class="journal-card-title"><?= esc($j['title']) ?></div>
                    <div class="journal-card-author">By <?= esc($j['author']) ?></div>
                </div>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color:var(--text-muted); grid-column: 1 / -1; text-align: center;">Tidak ada artikel untuk saat ini.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
