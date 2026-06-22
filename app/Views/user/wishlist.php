<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
    .catalog-container {
        padding: 120px 56px 60px; 
        max-width: 1200px; 
        margin: 0 auto; 
        min-height: 80vh; 
    }
    .catalog-header { 
        text-align: center; 
        margin-bottom: 50px; 
    }
    .catalog-header h1 { 
        font-family: 'Cinzel', serif; 
        font-size: 38px; 
        color: var(--gold); 
        letter-spacing: 0.12em; 
        margin-bottom: 15px; 
        text-transform: uppercase; 
    }
    .catalog-header p { 
        font-family: 'Raleway', sans-serif; 
        font-size: 14px; 
        color: var(--moon-silver); 
        max-width: 600px; 
        margin: 0 auto; 
        line-height: 1.6; 
    }

    .collection-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); 
        gap: 35px; 
    }
    
    .book-card {
        background: transparent;
        display: flex; 
        flex-direction: column; 
        transition: transform 0.3s;
    }
    .book-card:hover { 
        transform: translateY(-5px); 
    }
    
    .book-cover-box { 
        width: 100%; 
        aspect-ratio: 2/3; 
        background: var(--bg-card); 
        border: 1px solid var(--border-gold); 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        margin-bottom: 18px; 
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.5);
    }
    .book-cover-box img { 
        opacity: 0.7; 
        transition: opacity 0.3s; 
    }
    .book-card:hover .book-cover-box img { 
        opacity: 1; 
    }
    
    .book-genre { 
        font-family: 'Raleway', sans-serif; 
        font-size: 10px; 
        letter-spacing: 0.15em; 
        text-transform: uppercase; 
        color: var(--gold); 
        margin-bottom: 6px; 
    }
    .book-title { 
        font-family: 'Cinzel', serif; 
        font-size: 16px; 
        color: var(--gold-light); 
        line-height: 1.3; 
        margin-bottom: 8px; 
        flex-grow: 1; 
    }
    .book-author { 
        font-family: 'Raleway', sans-serif; 
        font-size: 12px; 
        color: var(--moon-silver); 
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
        <h1><?= esc($title ?? 'Daftar Bacaan') ?></h1>
        <p>Buku-buku yang telah kamu tandai untuk dibaca nanti.</p>
    </div>

    <div class="collection-grid">
        <?php if (!empty($books)): ?>
            
            <?php foreach ($books as $item): ?>
                <div class="book-card">
                    <div class="book-cover-box">
                        <?php if (!empty($item['cover_image'])): ?>
                            <img src="<?= base_url('uploads/covers/' . $item['cover_image']) ?>" alt="<?= esc($item['title']) ?>" style="max-width:100%; max-height:100%; object-fit:cover; opacity:1;">
                        <?php else: ?>
                            <img src="<?= base_url('assets/images/icon-computer.png') ?>" alt="Book Icon">
                        <?php endif; ?>
                    </div> 
                    
                    <div class="book-title"><?= esc($item['title']) ?></div>
                    <div class="book-author"><?= esc($item['author'] ?? 'Unknown Scholar') ?></div>
                    
                    <div class="book-meta">
                        <span style="color: var(--gold); font-size: 11px; letter-spacing: 2px;">★★★★★</span>
                        <a href="<?= base_url('book/detail/' . $item['id']) ?>" class="book-btn">Lihat Detail</a>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="empty-state">
                <p>✦ Daftar bacaanmu masih kosong. Jelajahi katalog Celestia untuk menemukan buku-buku menarik! ✦</p>
                <a href="<?= base_url('catalog') ?>" style="color: var(--gold); text-decoration: underline; margin-top: 15px; display: inline-block;">Jelajahi Katalog</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
