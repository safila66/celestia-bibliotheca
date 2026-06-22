<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
    .journal-detail-header {
        background: #394855; 
        padding: 60px 56px 40px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .journal-detail-type {
        font-family: 'Raleway', sans-serif;
        font-weight: 800;
        font-size: 14px;
        letter-spacing: 0.2em;
        color: var(--gold);
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .journal-detail-title {
        font-family: 'Cinzel', serif;
        font-size: 48px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .journal-detail-meta {
        font-family: 'EB Garamond', serif;
        font-size: 16px;
        color: rgba(255,255,255,0.7);
        font-style: italic;
    }
    .journal-detail-meta span {
        font-family: 'Raleway', sans-serif;
        font-weight: bold;
        font-style: normal;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 12px;
    }

    .journal-detail-cover {
        width: 100%;
        max-width: 1000px;
        margin: -40px auto 40px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0,0,0,0.5);
    }
    .journal-detail-cover img {
        width: 100%;
        height: auto;
        display: block;
        aspect-ratio: 21/9;
        object-fit: cover;
    }

    .journal-detail-content {
        max-width: 800px;
        margin: 0 auto 80px;
        padding: 0 40px;
        font-family: 'EB Garamond', serif;
        font-size: 21px;
        line-height: 1.8;
        color: var(--text);
    }
    .journal-detail-content p {
        margin-bottom: 24px;
    }
    .journal-detail-content h2, .journal-detail-content h3 {
        font-family: 'Cinzel', serif;
        color: var(--gold);
        margin: 40px 0 20px;
    }
    .journal-detail-content blockquote {
        border-left: 4px solid var(--gold);
        padding-left: 20px;
        margin: 30px 0;
        font-style: italic;
        color: var(--text-muted);
        font-size: 24px;
    }

    .journal-two-column {
        max-width: 1200px;
        margin: 0 auto 80px;
        padding: 0 40px;
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 60px;
        align-items: start;
    }

    .book-sidebar {
        background: var(--bg-card);
        border: 1px solid rgba(201,168,76,0.2);
        border-radius: 8px;
        padding: 30px;
        position: sticky;
        top: 100px;
    }
    .book-sidebar-cover {
        width: 100%;
        border-radius: 4px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.4);
        margin-bottom: 20px;
    }
    .book-sidebar-title {
        font-family: 'Cinzel', serif;
        font-size: 24px;
        color: var(--ivory);
        line-height: 1.2;
        margin-bottom: 5px;
    }
    .book-sidebar-author {
        font-family: 'Raleway', sans-serif;
        color: var(--gold);
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 20px;
    }
    .book-sidebar-table {
        width: 100%;
        font-family: 'EB Garamond', serif;
        font-size: 14px;
        color: var(--text-dim);
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 15px;
    }
    .book-sidebar-table td {
        padding: 6px 0;
    }
    .book-sidebar-table td:first-child {
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-family: 'Raleway', sans-serif;
        font-size: 11px;
    }
    .book-sidebar-table td:last-child {
        text-align: right;
        color: var(--ivory);
    }
    .btn-borrow-sidebar {
        display: block;
        width: 100%;
        text-align: center;
        background: var(--gold);
        color: #000;
        padding: 12px;
        border: none;
        border-radius: 4px;
        font-family: 'Raleway', sans-serif;
        font-weight: bold;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        cursor: pointer;
        text-decoration: none;
        margin-top: 20px;
        transition: background 0.3s;
    }
    .btn-borrow-sidebar:hover {
        background: var(--gold-dim);
    }

    /* ── LIGHT MODE OVERRIDES ── */
    [data-theme="light"] .journal-detail-header {
        background: #E8E2D5;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    [data-theme="light"] .journal-detail-title {
        color: #2C2416;
    }
    [data-theme="light"] .journal-detail-type {
        color: #A8752A;
    }
    [data-theme="light"] .journal-detail-meta {
        color: #5A4E3A;
    }
    [data-theme="light"] .journal-detail-meta span {
        color: #2C2416;
    }
    [data-theme="light"] .journal-detail-content {
        color: #2C2416;
    }
    [data-theme="light"] .journal-detail-content h2,
    [data-theme="light"] .journal-detail-content h3 {
        color: #A8752A;
    }
    [data-theme="light"] .journal-detail-content blockquote {
        border-color: #A8752A;
        color: #5A4E3A;
    }
    [data-theme="light"] .book-sidebar {
        background: #F8F5F0;
        border-color: rgba(0,0,0,0.1);
    }
    [data-theme="light"] .book-sidebar-title {
        color: #2C2416;
    }
    [data-theme="light"] .book-sidebar-table td:last-child {
        color: #2C2416;
    }
    [data-theme="light"] .book-sidebar-table {
        border-top-color: rgba(0,0,0,0.1);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="journal-detail-header">
    <div class="journal-detail-type"><?= esc($journal['type']) ?></div>
    <div class="journal-detail-title"><?= esc($journal['title']) ?></div>
    <div class="journal-detail-meta">
        Written by <span><?= esc($journal['author']) ?></span> &nbsp;&nbsp;|&nbsp;&nbsp; Published on <?= date('F j, Y', strtotime($journal['created_at'])) ?>
    </div>
</div>

<?php if(empty($book)): ?>
    <!-- STANDALONE JOURNAL LAYOUT -->
    <?php if(!empty($journal['cover_image'])): ?>
    <div class="journal-detail-cover">
        <?php $heroImg = $journal['user_id'] ? 'uploads/journals/' . $journal['cover_image'] : 'assets/images/' . $journal['cover_image']; ?>
        <img src="<?= base_url($heroImg) ?>" alt="Cover Image" onerror="this.src='https://images.unsplash.com/photo-1455390582262-044cdead27d8?auto=format&fit=crop&q=80&w=1200';">
    </div>
    <?php else: ?>
        <div style="height: 60px;"></div>
    <?php endif; ?>

    <div class="journal-detail-content">
        <?= $journal['content'] ?>
    </div>
<?php else: ?>
    <!-- 2-COLUMN BOOK REVIEW LAYOUT -->
    <div style="height: 60px;"></div>
    <div class="journal-two-column">
        <!-- Sidebar Book Details -->
        <div class="book-sidebar">
            <img class="book-sidebar-cover" src="<?= base_url('uploads/covers/' . $book['cover_image']) ?>" alt="Book Cover" onerror="this.src='https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&q=80&w=400';">
            
            <div class="book-sidebar-title"><?= esc($book['title']) ?></div>
            <div class="book-sidebar-author">Oleh: <?= esc($book['author']) ?></div>
            
            <table class="book-sidebar-table">
                <tr><td>Kategori</td><td><?= esc($book['category_name']) ?></td></tr>
                <tr><td>Penerbit</td><td><?= esc($book['publisher']) ?></td></tr>
                <tr><td>Tahun</td><td><?= esc($book['year']) ?></td></tr>
                <tr><td>ISBN</td><td><?= esc($book['isbn']) ?></td></tr>
                <tr><td>Halaman</td><td><?= esc($book['pages']) ?> hlm</td></tr>
                <tr><td>Call No.</td><td><?= esc($book['call_number']) ?></td></tr>
                <tr>
                    <td>Stok</td>
                    <td>
                        <?php if($book['stock_available'] > 0): ?>
                            <span style="color:#7ec8a0;">✦ <?= $book['stock_available'] ?> Tersedia</span>
                        <?php else: ?>
                            <span style="color:#e07070;">✗ Habis</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <div style="font-family:'EB Garamond',serif; font-style:italic; font-size:15px; margin-top:20px; line-height:1.4; color:var(--text-dim);">
                <?= esc($book['description']) ?>
            </div>

            <?php if(session()->get('user_id')): ?>
                <a href="#" class="btn-borrow-sidebar">✦ Pinjam Buku</a>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="btn-borrow-sidebar">✦ Login untuk Meminjam</a>
                <div style="text-align:center; font-family:'EB Garamond',serif; font-size:12px; margin-top:10px; font-style:italic;">Belum punya akun? <a href="<?= base_url('register') ?>" style="color:var(--gold);">Daftar gratis</a></div>
            <?php endif; ?>
        </div>

        <!-- Main Journal Content -->
        <div>
            <?php if(!empty($journal['cover_image'])): ?>
            <div style="border-radius: 8px; overflow: hidden; margin-bottom: 40px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                <?php $heroImg2 = $journal['user_id'] ? 'uploads/journals/' . $journal['cover_image'] : 'assets/images/' . $journal['cover_image']; ?>
                <img src="<?= base_url($heroImg2) ?>" alt="Journal Header" style="width:100%; aspect-ratio:16/9; object-fit:cover; display:block;" onerror="this.src='https://images.unsplash.com/photo-1455390582262-044cdead27d8?auto=format&fit=crop&q=80&w=1200';">
            </div>
            <?php endif; ?>

            <div class="journal-detail-content" style="max-width:none; padding:0; margin:0;">
                <?= $journal['content'] ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div style="text-align: center; margin-bottom: 80px;">
    <a href="<?= base_url('mini-journalism') ?>" class="btn-outline">← Back to Journals</a>
</div>

<?= $this->endSection() ?>
