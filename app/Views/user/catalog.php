<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
    .catalog-container {
        padding: 40px 56px 120px;
        position: relative;
        z-index: 10;
    }
    .catalog-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .catalog-header h1 {
        font-family: 'Cinzel', serif;
        color: var(--gold-light);
        font-size: 36px;
        margin-bottom: 10px;
    }
    .catalog-header p {
        font-family: 'EB Garamond', serif;
        font-style: italic;
        color: var(--text-dim);
    }
    
    /* ── GRID KOLEKSI BUKU ── */
    .collection-grid { 
        display: grid; 
        grid-template-columns: repeat(4, 1fr); 
        gap: 24px; 
    }
    .book-card {
        background: linear-gradient(135deg, rgba(15,18,38,0.9) 0%, rgba(8,10,22,0.95) 100%);
        border: 1px solid rgba(201,168,76,0.12); 
        padding: 28px 22px 22px; 
        cursor: pointer; 
        transition: all 0.3s; 
        position: relative; 
        overflow: hidden;
    }
    .book-card:hover { 
        border-color: rgba(201,168,76,0.35); 
        transform: translateY(-4px); 
    }
    .book-cover-box {
        width: 100%; 
        aspect-ratio: 2/3; 
        margin-bottom: 16px;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        display: flex; 
        align-items: center; 
        justify-content: center;
        border: 1px solid rgba(201,168,76,0.15);
    }
    .book-cover-box img {
        max-width: 50%;
        max-height: 50%;
        object-fit: contain;
        opacity: 0.7;
    }
    .book-genre { 
        font-family: 'Raleway', sans-serif; 
        font-size: 10px; 
        letter-spacing: 0.18em; 
        text-transform: uppercase; 
        color: var(--gold); 
        margin-bottom: 6px; 
    }
    .book-title { 
        font-family: 'Cinzel', serif; 
        font-size: 14px; 
        font-weight: 600; 
        color: var(--ivory); 
        margin-bottom: 4px; 
        line-height: 1.3; 
    }
    .book-author { 
        font-size: 12px; 
        color: var(--text-dim); 
        font-style: italic; 
        margin-bottom: 12px; 
    }
    .book-meta { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
    }
    .book-btn {
        font-family: 'Raleway', sans-serif; 
        font-size: 10px; 
        letter-spacing: 0.14em; 
        text-transform: uppercase; 
        text-decoration: none;
        color: var(--gold); 
        background: none; 
        border: 1px solid rgba(201,168,76,0.3); 
        padding: 5px 14px; 
        cursor: pointer; 
        transition: all 0.2s;
    }
    .book-btn:hover { 
        background: rgba(201,168,76,0.1); 
        border-color: var(--gold); 
    }
    
    .empty-state { 
        text-align: center; 
        padding: 80px 20px; 
        color: var(--moon-silver); 
        font-style: italic; 
        grid-column: 1 / -1; 
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="catalog-container">
    
    <div class="catalog-header">
        <h1>
            <?php 
                // Membersihkan teks title agar rapi saat dipajang sebagai h1
                echo esc(str_replace(' | Celestia Bibliotheca', '', $title)); 
            ?>
        </h1>
        <?php if (!empty($keyword)): ?>
            <p>Menampilkan hasil pencarian bintang untuk kata kunci: "<?= esc($keyword) ?>"</p>
        <?php elseif (!empty($kategori_aktif)): ?>
            <p>Arsip volume yang tersimpan di dalam konstelasi <?= esc(ucfirst($kategori_aktif)) ?>.</p>
        <?php else: ?>
            <p>Menjelajahi seluruh lembar ilmu yang tertulis di semesta Celestia.</p>
        <?php endif; ?>
    </div>

    <div class="collection-grid">
        <?php if (!empty($buku)): ?>
            
            <?php foreach ($buku as $item): ?>
                <div class="book-card">
                    <div class="book-cover-box">
                        <?php if (!empty($item['cover_image'])): ?>
                            <img src="<?= base_url('uploads/covers/' . $item['cover_image']) ?>" alt="<?= esc($item['title']) ?>" style="max-width:100%; max-height:100%; object-fit:cover; opacity:1;">
                        <?php else: ?>
                            <img src="<?= base_url('assets/images/icon-computer.png') ?>" alt="Book Icon">
                        <?php endif; ?>
                    </div> 
                    
                    <!-- category removed per user request -->
                    <div class="book-title" style="color: #F0EBE0; font-family: 'Cinzel', serif; font-size: 15px; text-transform: uppercase; margin-bottom: 4px;"><?= esc($item['title']) ?></div>
                    <div class="book-author" style="color: var(--gold); font-weight: bold; font-style: normal; font-size: 11px;">Oleh: <?= esc($item['author'] ?? 'Unknown Scholar') ?></div>
                    
                    <div class="book-meta">
                        <span style="color: var(--gold); font-size: 11px; letter-spacing: 2px;">★★★★★</span>
                        
                        <a href="<?= base_url('book/detail/' . $item['id']) ?>" class="book-btn">Read</a>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="empty-state">
                <p>✦ Buku/data tidak ditemukan. ✦</p>
                <?php if (empty($keyword) || empty($rekomendasi)): ?>
                    <a href="<?= base_url('/') ?>" style="color: var(--gold); text-decoration: underline; margin-top: 15px; display: inline-block;">Kembali ke Beranda</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (empty($buku) && !empty($keyword) && isset($rekomendasi)): ?>
        <?php if (!empty($rekomendasi)): ?>
            <div class="catalog-header" style="margin-top: 40px; text-align: left;">
                <h2 style="font-family: 'Cinzel', serif; color: var(--gold); margin-bottom: 5px;">Rekomendasi Buku Serupa</h2>
                <p>Berdasarkan genre atau deskripsi dari pencarian Anda.</p>
            </div>
            <div class="collection-grid">
                <?php foreach ($rekomendasi as $item): ?>
                    <div class="book-card">
                        <div class="book-cover-box">
                            <?php if (!empty($item['cover_image'])): ?>
                                <img src="<?= base_url('uploads/covers/' . $item['cover_image']) ?>" alt="<?= esc($item['title']) ?>" style="max-width:100%; max-height:100%; object-fit:cover; opacity:1;">
                            <?php else: ?>
                                <img src="<?= base_url('assets/images/icon-computer.png') ?>" alt="Book Icon">
                            <?php endif; ?>
                        </div> 
                        
                            <!-- category removed per user request -->
                            <div class="book-title" style="color: #F0EBE0; font-family: 'Cinzel', serif; font-size: 15px; text-transform: uppercase; margin-bottom: 4px;"><?= esc($item['title']) ?></div>
                            <div class="book-author" style="color: var(--gold); font-weight: bold; font-style: normal; font-size: 11px;">Oleh: <?= esc($item['author'] ?? 'Unknown Scholar') ?></div>
                        
                        <div class="book-meta">
                            <span style="color: var(--gold); font-size: 11px; letter-spacing: 2px;">★★★★★</span>
                            <a href="<?= base_url('book/detail/' . $item['id']) ?>" class="book-btn">Read</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state" style="margin-top: 20px;">
                <p>✦ Tidak ada buku yang serupa. ✦</p>
                <a href="<?= base_url('/') ?>" style="color: var(--gold); text-decoration: underline; margin-top: 15px; display: inline-block;">Kembali ke Beranda</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
