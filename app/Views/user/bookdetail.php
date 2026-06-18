<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
  /* ── LAYOUT UTAMA ── */
  .catalog-container {
    padding: 120px 5% 80px;
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 340px 1fr;
    gap: 48px;
    color: #e0e0e0;
  }

  /* ── PANEL KIRI: IDENTITAS BUKU ── */
  .book-identity-panel {
    background: rgba(4, 6, 15, 0.5);
    border: 1px solid rgba(201, 168, 76, 0.2);
    padding: 32px;
    backdrop-filter: blur(12px);
    height: fit-content;
    position: sticky;
    top: 100px;
  }

  .badge-preview {
    display: inline-block;
    background: rgba(201, 168, 76, 0.15);
    color: #C9A84C;
    padding: 4px 14px;
    font-size: 10px;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    font-family: 'Raleway', sans-serif;
    border: 1px solid rgba(201,168,76,0.3);
    margin-bottom: 18px;
  }

  .book-identity-panel h1 {
    font-family: 'Cinzel', serif;
    color: #F4F1EA;
    font-size: 26px;
    line-height: 1.2;
    margin-bottom: 10px;
    font-weight: 400;
  }

  .book-author {
    color: #C9A84C;
    font-family: 'Raleway', sans-serif;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 24px;
    letter-spacing: 0.05em;
  }

  .book-meta-list {
    list-style: none;
    padding: 16px 0;
    margin: 0 0 20px 0;
    border-top: 1px solid rgba(201,168,76,0.15);
    border-bottom: 1px solid rgba(201,168,76,0.15);
    font-size: 13px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .book-meta-list li {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
  }

  .meta-label {
    color: #777;
    font-family: 'Raleway', sans-serif;
    font-size: 10px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    flex-shrink: 0;
    padding-top: 2px;
  }

  .meta-value { color: #ccc; text-align: right; font-size: 13px; }

  .stock-badge {
    display: inline-block;
    padding: 3px 10px;
    font-size: 11px;
    font-family: 'Raleway', sans-serif;
    letter-spacing: 0.1em;
  }
  .stock-badge.available   { background: rgba(126,200,160,0.1); color: #7ec8a0; border: 1px solid rgba(126,200,160,0.3); }
  .stock-badge.unavailable { background: rgba(224,112,112,0.1); color: #e07070; border: 1px solid rgba(224,112,112,0.3); }

  .book-synopsis {
    font-size: 13.5px;
    line-height: 1.8;
    color: #aaa;
    text-align: justify;
    margin-bottom: 28px;
    font-style: italic;
  }

  /* ── TOMBOL AKSI ── */
  .action-buttons { display: flex; flex-direction: column; gap: 10px; margin-bottom: 14px; }

  .btn-pinjam {
    display: block; width: 100%; padding: 12px; text-align: center;
    font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.18em;
    text-transform: uppercase; font-weight: 700;
    background: var(--gold, #C9A84C); color: #04060F;
    border: none; cursor: pointer; transition: all 0.25s; text-decoration: none;
  }
  .btn-pinjam:hover { background: #E8C96A; }
  .btn-pinjam.disabled, .btn-pinjam:disabled {
    background: rgba(201,168,76,0.2); color: #666; cursor: not-allowed;
  }

  .btn-wishlist {
    display: block; width: 100%; padding: 11px; text-align: center;
    font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.18em;
    text-transform: uppercase; background: none; color: #C9A84C;
    border: 1px solid rgba(201,168,76,0.35); cursor: pointer;
    transition: all 0.25s; text-decoration: none;
  }
  .btn-wishlist:hover { background: rgba(201,168,76,0.08); border-color: #C9A84C; }

  .btn-back {
    display: block; width: 100%; padding: 10px; text-align: center;
    font-family: 'Raleway', sans-serif; font-size: 10px; letter-spacing: 0.15em;
    text-transform: uppercase; background: none; color: #666;
    border: 1px solid rgba(255,255,255,0.08); cursor: pointer;
    transition: all 0.2s; text-decoration: none;
  }
  .btn-back:hover { color: #aaa; border-color: rgba(255,255,255,0.2); }

  .login-notice { font-size: 12px; color: #666; text-align: center; font-style: italic; margin-top: 8px; }
  .login-notice a { color: #C9A84C; text-decoration: none; }

  .flash-msg { padding: 12px 20px; margin-bottom: 20px; font-family: 'Raleway', sans-serif; font-size: 13px; border-left: 3px solid; }
  .flash-msg.success { background: rgba(126,200,160,0.08); border-color: #7ec8a0; color: #7ec8a0; }
  .flash-msg.error   { background: rgba(224,112,112,0.08); border-color: #e07070; color: #e07070; }

  /* ── PANEL KANAN ── */
  .preview-panel { display: flex; flex-direction: column; min-height: 700px; }

  .preview-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 18px; padding-bottom: 14px;
    border-bottom: 1px solid rgba(201, 168, 76, 0.2);
  }
  .preview-header h2 {
    font-family: 'Cinzel', serif; font-size: 20px; color: #C9A84C;
    margin: 0; font-weight: 400; letter-spacing: 0.08em;
  }
  .preview-hint { font-size: 11px; color: #666; font-family: 'Raleway', sans-serif; letter-spacing: 0.1em; }

  /* ── LIGHT MODE: panel kiri ── */
[data-theme="light"] .book-identity-panel {
    background: rgba(255, 252, 245, 0.85);
    border-color: rgba(168, 117, 42, 0.25);
}

[data-theme="light"] .book-identity-panel h1 { color: #2C2416; }
[data-theme="light"] .book-author            { color: #A8752A; }
[data-theme="light"] .meta-label             { color: #8B7355; }
[data-theme="light"] .meta-value             { color: #3D3020; }
[data-theme="light"] .book-synopsis          { color: #5A4E3A; }
[data-theme="light"] .badge-preview {
    background: rgba(168,117,42,0.12);
    color: #A8752A;
    border-color: rgba(168,117,42,0.3);
}
[data-theme="light"] .book-meta-list {
    border-color: rgba(168,117,42,0.2);
}

/* ── LIGHT MODE: panel kanan ── */
[data-theme="light"] .preview-header h2      { color: #A8752A; }
[data-theme="light"] .preview-hint           { color: #8B7355; }
[data-theme="light"] .preview-header         { border-color: rgba(168,117,42,0.25); }
[data-theme="light"] #flipbook-container {
    background: rgba(255,252,245,0.5);
    border-color: rgba(168,117,42,0.2);
}
[data-theme="light"] .flipbook-controls {
    background: rgba(245,240,232,0.9);
    border-color: rgba(168,117,42,0.2);
}
[data-theme="light"] .fb-btn  { border-color: rgba(168,117,42,0.4); color: #A8752A; }
[data-theme="light"] .fb-btn:hover:not(:disabled) { background: rgba(168,117,42,0.1); }
[data-theme="light"] .fb-page-info { color: rgba(44,36,22,0.6); }
[data-theme="light"] .fb-hint      { color: #8B7355; }

/* ── LIGHT MODE: loan section ── */
[data-theme="light"] .loan-section {
    background: rgba(255,252,245,0.7);
    border-color: rgba(168,117,42,0.2);
}
[data-theme="light"] .loan-info h3 { color: #2C2416; }
[data-theme="light"] .loan-info p  { color: #8B7355; }

/* ── LIGHT MODE: related cards ── */
[data-theme="light"] .related-card {
    background: rgba(255,252,245,0.8);
    border-color: rgba(168,117,42,0.15);
}
[data-theme="light"] .related-card:hover { border-color: rgba(168,117,42,0.4); }
[data-theme="light"] .related-card-title  { color: #2C2416; }
[data-theme="light"] .related-card-author { color: #8B7355; }
[data-theme="light"] .related-header {
    color: #A8752A;
    border-color: rgba(168,117,42,0.2);
}

/* ── LIGHT MODE: stock badge ── */
[data-theme="light"] .stock-badge.available {
    background: rgba(80,140,100,0.1);
    color: #3D7A52;
    border-color: rgba(80,140,100,0.3);
}

  /* ── PDF VIEWER (PDF.js) ── */
  #flipbook-container {
    width: 100%;
    min-height: 580px;
    background: rgba(4,6,15,0.3);
    border: 1px solid rgba(201,168,76,0.1);
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex: 1;
  }

  .page-canvas-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 20px;
    flex: 1;
  }

  #pageCanvas {
    max-width: 100%;
    max-height: 520px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.6);
    border: 1px solid rgba(201,168,76,0.15);
    background: #fff;
    transition: opacity 0.25s ease;
    cursor: zoom-in;
  }
  #pageCanvas.zoomed { cursor: zoom-out; }

  .flipbook-controls {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px 24px;
    background: rgba(4,6,15,0.7);
    border-top: 1px solid rgba(201,168,76,0.12);
    width: 100%;
    justify-content: center;
    backdrop-filter: blur(8px);
  }

  .fb-btn {
    background: none;
    border: 1px solid rgba(201,168,76,0.3);
    color: #C9A84C;
    width: 34px; height: 34px;
    cursor: pointer; font-size: 15px;
    transition: all 0.2s;
    display: flex; align-items: center; justify-content: center;
  }
  .fb-btn:hover:not(:disabled) { background: rgba(201,168,76,0.12); border-color: #C9A84C; }
  .fb-btn:disabled { opacity: 0.25; cursor: not-allowed; }

  .fb-page-info {
    font-family: 'Raleway', sans-serif; font-size: 11px;
    letter-spacing: 0.15em; color: rgba(240,235,224,0.5);
    min-width: 70px; text-align: center;
  }
  .fb-divider { width: 1px; height: 18px; background: rgba(201,168,76,0.2); }
  .fb-hint { font-family: 'Raleway', sans-serif; font-size: 10px; letter-spacing: 0.1em; color: #555; }

  .fb-loading {
    display: flex; flex-direction: column;
    align-items: center; gap: 14px;
    font-family: 'Raleway', sans-serif; font-size: 12px;
    letter-spacing: 0.15em; color: #555;
  }
  .fb-loading-star {
    font-size: 28px; color: rgba(201,168,76,0.5);
    animation: spinStar 2.5s linear infinite;
  }
  @keyframes spinStar { to { transform: rotate(360deg); } }

  /* ── BORROW SECTION ── */
  .loan-section {
    margin-top: 20px; padding: 22px 28px;
    background: rgba(4,6,15,0.4);
    border: 1px solid rgba(201,168,76,0.15);
    display: flex; align-items: center;
    justify-content: space-between; gap: 24px;
  }
  .loan-info h3 { font-family: 'Cinzel', serif; font-size: 16px; color: #F4F1EA; font-weight: 400; margin-bottom: 4px; }
  .loan-info p  { font-size: 12px; color: #666; font-style: italic; }
  .loan-actions { display: flex; gap: 12px; flex-shrink: 0; }
  .loan-actions .btn-pinjam   { width: auto; padding: 12px 28px; white-space: nowrap; }
  .loan-actions .btn-wishlist { width: auto; padding: 11px 20px; white-space: nowrap; }

  /* ── RELATED BOOKS ── */
  .related-section { padding: 48px 5%; max-width: 1400px; margin: 0 auto; }
  .related-header {
    font-family: 'Cinzel', serif; font-size: 18px; color: #C9A84C;
    font-weight: 400; letter-spacing: 0.1em; margin-bottom: 24px;
    padding-bottom: 12px; border-bottom: 1px solid rgba(201,168,76,0.15);
  }
  .related-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; }
  .related-card {
    background: rgba(4,6,15,0.4); border: 1px solid rgba(201,168,76,0.1);
    padding: 20px 16px; cursor: pointer; transition: all 0.3s;
    text-decoration: none; display: block;
  }
  .related-card:hover { border-color: rgba(201,168,76,0.3); transform: translateY(-4px); }
  .related-card-genre { font-family:'Raleway',sans-serif; font-size:10px; letter-spacing:0.15em; text-transform:uppercase; color:#C9A84C; margin-bottom:6px; }
  .related-card-title { font-family:'Cinzel',serif; font-size:13px; color:#F4F1EA; margin-bottom:4px; line-height:1.3; }
  .related-card-author { font-size:12px; color:#666; font-style:italic; }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<?php
  $isLoggedIn = session()->has('user_id');
  $stockOk    = ($book['stock_available'] ?? 0) > 0;
?>

<div class="catalog-container">

  <!-- ═══════════════════════ PANEL KIRI ═══════════════════════ -->
  <div class="book-identity-panel">

    <?php if (session()->getFlashdata('success')): ?>
      <div class="flash-msg success">✦ <?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="flash-msg error">✦ <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <span class="badge-preview"><?= esc(ucfirst($book['type'] ?? 'Buku')) ?></span>

    <h1><?= esc($book['title']) ?></h1>
    <div class="book-author">Oleh: <?= esc($book['author']) ?></div>

    <ul class="book-meta-list">
      <li><span class="meta-label">Kategori</span><span class="meta-value"><?= esc($book['category_name'] ?? '—') ?></span></li>
      <li><span class="meta-label">Penerbit</span><span class="meta-value"><?= esc($book['publisher'] ?? '—') ?></span></li>
      <li><span class="meta-label">Tahun</span><span class="meta-value"><?= esc($book['year'] ?? '—') ?></span></li>
      <?php if (!empty($book['isbn'])): ?>
      <li><span class="meta-label">ISBN</span><span class="meta-value"><?= esc($book['isbn']) ?></span></li>
      <?php endif; ?>
      <?php if (!empty($book['pages'])): ?>
      <li><span class="meta-label">Halaman</span><span class="meta-value"><?= esc($book['pages']) ?> hlm</span></li>
      <?php endif; ?>
      <?php if (!empty($book['call_number'])): ?>
      <li><span class="meta-label">Call No.</span><span class="meta-value"><?= esc($book['call_number']) ?></span></li>
      <?php endif; ?>
      <li>
        <span class="meta-label">Stok</span>
        <span class="meta-value">
          <?php if ($stockOk): ?>
            <span class="stock-badge available">✦ <?= $book['stock_available'] ?> Tersedia</span>
          <?php else: ?>
            <span class="stock-badge unavailable">✦ Tidak Tersedia</span>
          <?php endif; ?>
        </span>
      </li>
    </ul>

    <?php if (!empty($book['description'])): ?>
    <div class="book-synopsis"><?= esc($book['description']) ?></div>
    <?php endif; ?>

    <div class="action-buttons">
      <?php if ($isLoggedIn): ?>
        <?php if ($stockOk): ?>
          <form action="<?= base_url('buku/' . $book['id'] . '/pinjam') ?>" method="post">
            <?= csrf_field() ?>
            <button type="submit" class="btn-pinjam">✦ Pinjam Buku Ini</button>
          </form>
        <?php else: ?>
          <button class="btn-pinjam disabled" disabled>✦ Stok Habis</button>
        <?php endif; ?>
        <form action="<?= base_url('buku/' . $book['id'] . '/wishlist') ?>" method="post">
          <?= csrf_field() ?>
          <button type="submit" class="btn-wishlist">♡ Tambah ke Daftar Bacaan</button>
        </form>
      <?php else: ?>
        <a href="<?= base_url('login') ?>" class="btn-pinjam">✦ Login untuk Meminjam</a>
        <p class="login-notice">Belum punya akun? <a href="<?= base_url('register') ?>">Daftar gratis</a></p>
      <?php endif; ?>
    </div>

    <a href="<?= base_url('catalog') ?>" class="btn-back">&larr; Kembali ke Katalog</a>
  </div>

  <!-- ═══════════════════════ PANEL KANAN ═══════════════════════ -->
  <div class="preview-panel">

    <div class="preview-header">
      <h2>Archive Viewer</h2>
      <span class="preview-hint">
        <?= !empty($book['file_pdf']) ? '✦ Klik canvas untuk zoom · Arrow key untuk navigasi' : 'Preview tidak tersedia' ?>
      </span>
    </div>

    <?php if (!empty($book['file_pdf'])): ?>
      <!-- PDF.js Viewer -->
      <div id="flipbook-container">
        <div class="page-canvas-wrap">
          <div class="fb-loading" id="fbLoading">
            <div class="fb-loading-star">✦</div>
            <span>Membuka arsip...</span>
          </div>
          <canvas id="pageCanvas" style="display:none;"></canvas>
        </div>
        <div class="flipbook-controls" id="fbControls" style="display:none;">
          <button class="fb-btn" id="fbFirst" title="Halaman Pertama">«</button>
          <button class="fb-btn" id="fbPrev"  title="Sebelumnya">‹</button>
          <span class="fb-page-info" id="fbPageInfo">1 / ?</span>
          <button class="fb-btn" id="fbNext"  title="Berikutnya">›</button>
          <button class="fb-btn" id="fbLast"  title="Halaman Terakhir">»</button>
          <div class="fb-divider"></div>
          <span class="fb-hint">✦ Klik untuk zoom</span>
        </div>
      </div>

    <?php else: ?>
      <div style="flex:1; display:flex; align-items:center; justify-content:center; border:1px dashed rgba(201,168,76,0.15); min-height:400px;">
        <div style="text-align:center;">
          <div style="font-size:40px; margin-bottom:16px; opacity:0.3;">📜</div>
          <p style="font-family:'Cinzel',serif; font-size:14px; color:#555; letter-spacing:0.08em;">Preview tidak tersedia untuk koleksi ini</p>
        </div>
      </div>
    <?php endif; ?>

    <!-- Borrow Section -->
    <div class="loan-section">
      <div class="loan-info">
        <h3><?= esc($book['title']) ?></h3>
        <p>
          <?php if ($stockOk): ?>
            <?= $book['stock_available'] ?> dari <?= $book['stock'] ?? '?' ?> eksemplar tersedia · Durasi loan 7 hari
          <?php else: ?>
            Semua eksemplar sedang dipinjam · Tambahkan ke daftar bacaan untuk notifikasi
          <?php endif; ?>
        </p>
      </div>
      <div class="loan-actions">
        <?php if ($isLoggedIn): ?>
          <?php if ($stockOk): ?>
            <form action="<?= base_url('buku/' . $book['id'] . '/pinjam') ?>" method="post" style="margin:0;">
              <?= csrf_field() ?>
              <button type="submit" class="btn-pinjam">✦ Pinjam Sekarang</button>
            </form>
          <?php else: ?>
            <button class="btn-pinjam disabled" disabled>✦ Stok Habis</button>
          <?php endif; ?>
          <form action="<?= base_url('buku/' . $book['id'] . '/wishlist') ?>" method="post" style="margin:0;">
            <?= csrf_field() ?>
            <button type="submit" class="btn-wishlist">♡ Simpan</button>
          </form>
        <?php else: ?>
          <a href="<?= base_url('login?redirect=' . urlencode(current_url())) ?>" class="btn-pinjam">✦ Login untuk Meminjam</a>
        <?php endif; ?>
      </div>
    </div>

  </div><!-- /preview-panel -->
</div><!-- /catalog-container -->

<!-- Related Books -->
<?php if (!empty($related)): ?>
<div class="related-section">
  <div class="related-header">✦ Koleksi Serupa</div>
  <div class="related-grid">
    <?php foreach ($related as $r): ?>
    <a href="<?= base_url('book/' . $r['id']) ?>" class="related-card">
      <div class="related-card-genre"><?= esc($r['category_name'] ?? 'Koleksi') ?></div>
      <div class="related-card-title"><?= esc($r['title']) ?></div>
      <div class="related-card-author"><?= esc($r['author']) ?></div>
    </a>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if (!empty($book['file_pdf'])): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
(function() {
    const pdfUrl   = "<?= base_url('assets/pdfs/' . esc($book['file_pdf'])) ?>";
    const canvas   = document.getElementById('pageCanvas');
    const ctx      = canvas.getContext('2d');
    const loading  = document.getElementById('fbLoading');
    const controls = document.getElementById('fbControls');
    const pageInfo = document.getElementById('fbPageInfo');
    const btnFirst = document.getElementById('fbFirst');
    const btnPrev  = document.getElementById('fbPrev');
    const btnNext  = document.getElementById('fbNext');
    const btnLast  = document.getElementById('fbLast');

    pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    let pdfDoc      = null;
    let currentPage = 1;
    let totalPages  = 0;
    let isRendering = false;
    let scale       = 1.4;
    let zoomedIn    = false;

    // Load PDF
    pdfjsLib.getDocument(pdfUrl).promise
        .then(function(pdf) {
            pdfDoc     = pdf;
            totalPages = pdf.numPages;
            loading.style.display  = 'none';
            canvas.style.display   = 'block';
            controls.style.display = 'flex';
            renderPage(1);
        })
        .catch(function(err) {
            loading.innerHTML = '<span style="color:#e07070; font-size:13px; letter-spacing:0.1em;">✗ Gagal memuat dokumen</span>';
            console.error('PDF.js error:', err);
        });

    function renderPage(num) {
        if (isRendering || !pdfDoc) return;
        isRendering      = true;
        canvas.style.opacity = '0.3';

        pdfDoc.getPage(num).then(function(page) {
            const wrap     = document.querySelector('.page-canvas-wrap');
            const maxW     = wrap.offsetWidth - 48;
            const vp0      = page.getViewport({ scale: 1 });
            const autoScale = Math.min(scale, maxW / vp0.width);
            const vp       = page.getViewport({ scale: autoScale });

            canvas.width  = vp.width;
            canvas.height = vp.height;

            page.render({ canvasContext: ctx, viewport: vp }).promise.then(function() {
                isRendering          = false;
                currentPage          = num;
                canvas.style.opacity = '1';
                pageInfo.textContent = num + ' / ' + totalPages;
                btnFirst.disabled = btnPrev.disabled = (num <= 1);
                btnNext.disabled  = btnLast.disabled  = (num >= totalPages);
            });
        });
    }

    // Tombol navigasi
    btnFirst.addEventListener('click', () => renderPage(1));
    btnPrev.addEventListener('click',  () => { if (currentPage > 1) renderPage(currentPage - 1); });
    btnNext.addEventListener('click',  () => { if (currentPage < totalPages) renderPage(currentPage + 1); });
    btnLast.addEventListener('click',  () => renderPage(totalPages));

    // Keyboard navigasi
    document.addEventListener('keydown', function(e) {
        if (['ArrowRight','ArrowDown'].includes(e.key) && currentPage < totalPages) renderPage(currentPage + 1);
        if (['ArrowLeft','ArrowUp'].includes(e.key)    && currentPage > 1)          renderPage(currentPage - 1);
    });

    // === FITUR BARU: Klik Kiri / Kanan untuk Navigasi Halaman ===
    canvas.addEventListener('click', function(e) {
        // Ambil ukuran dan posisi canvas di layar
        const rect = canvas.getBoundingClientRect();
        // Hitung titik X tempat mouse diklik relatif terhadap canvas
        const clickX = e.clientX - rect.left;

        // Jika diklik di separuh kanan layar
        if (clickX > (rect.width / 2)) {
            if (currentPage < totalPages) renderPage(currentPage + 1);
        } 
        // Jika diklik di separuh kiri layar
        else {
            if (currentPage > 1) renderPage(currentPage - 1);
        }
    });

    // === FITUR MODIFIKASI: Double Click untuk Zoom ===
    canvas.addEventListener('dblclick', function() {
        zoomedIn = !zoomedIn;
        scale    = zoomedIn ? 2.2 : 1.4;
        canvas.classList.toggle('zoomed', zoomedIn);
        renderPage(currentPage);
    });
})();
</script>
<?php endif; ?>
<?= $this->endSection() ?>