<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<link href="https://unpkg.com/@dearflip/dearflip-webgl@latest/dflip/css/dflip.min.css" rel="stylesheet">
<link href="https://unpkg.com/@dearflip/dearflip-webgl@latest/dflip/css/themify-icons.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<style>
  /* Styling untuk ruang baca */
  .reading-room {
    padding: 120px 56px 60px;
    max-width: 1300px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 2.5fr; /* Memperlebar area kanan untuk flipbook */
    gap: 40px;
    color: var(--moon-silver);
  }
  
  .book-identity h1 {
    font-family: 'Cinzel', serif;
    color: var(--ivory);
    font-size: 32px;
    margin-bottom: 8px;
  }
  
  .book-meta {
    font-family: 'Raleway', sans-serif;
    color: var(--gold);
    font-size: 14px;
    margin-bottom: 24px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
  }
  
  .book-synopsis {
    line-height: 1.8;
    color: var(--text-dim);
    margin-bottom: 24px;
    text-align: justify;
  }

  /* Wadah Flipbook */
  .archive-viewer {
    background: transparent;
    height: 85vh; /* Tinggi menyesuaikan layar */
    min-height: 600px;
  }

  /* Responsif untuk HP */
  @media (max-width: 900px) {
    .reading-room { grid-template-columns: 1fr; padding: 100px 24px; }
    .archive-viewer { height: 60vh; }
  }
</style>

<div class="reading-room">
    <div class="book-identity">
        <h1><?= esc($book['title']) ?></h1> 
        <div class="book-meta">
            Penulis: <?= esc($book['author']) ?> | Kategori: <?= esc($book['category']) ?>
        </div>
        <div class="book-synopsis">
            <?= esc($book['description']) ?>
        </div>
        <a href="<?= base_url('/') ?>" class="btn-ghost" style="text-decoration:none; display:inline-block; margin-top:20px;">
            &larr; Kembali ke Beranda
        </a>
    </div>

    <div class="archive-viewer">
        <div class="_df_book" 
             source="<?= base_url('assets/pdfs/The Song of Achilles - Miller_Madeline/' . $book['file_pdf']) ?>" 
             id="celestia_flipbook">
        </div>
    </div>
</div>

<script src="https://unpkg.com/@dearflip/dearflip-webgl@latest/dflip/js/dflip.min.js"></script>

<?= $this->endSection() ?>