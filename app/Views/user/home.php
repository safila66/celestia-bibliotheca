<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
  /* ── HERO SECTION & SWIPER ── */
  #hero {
    position: relative; 
    width: 100%; 
    height: 100vh; /* Kunci tinggi 100% layar */
    overflow: hidden; 
    margin-top: -80px; 
    background-color: var(--deep-navy); 
  }

  .swiper-hero {
    width: 100%; 
    height: 100%;
    position: absolute;
    top: 0; left: 0;
    z-index: 1; /* Posisi di paling belakang */
  }

  /* Overlay gelap untuk slide 1 agar teks terbaca */
<?php if (!session()->get('user_id')): ?>
.swiper-slide:first-child .slide-bg::before {
  content: '';
  cursor: pointer;
  position: absolute;
  inset: 0;
  z-index: 2;
  /* Gelap di kiri (area teks), transparan ke kanan */
  background: linear-gradient(
    to right,
    rgba(4, 6, 15, 0.72) 0%,
    rgba(4, 6, 15, 0.55) 40%,
    rgba(4, 6, 15, 0.15) 70%,
    transparent 100%
  ),
  /* Gelap di bawah untuk hero-cards */
  linear-gradient(
    to top,
    rgba(4, 6, 15, 0.85) 0%,
    transparent 30%
  );
}
<?php else: ?>
.swiper-slide:first-child .slide-bg::before {
  content: '';
  cursor: pointer;
  position: absolute;
  inset: 0;
  z-index: 2;
  /* Hanya gelap di bawah untuk hero-cards karena teks sudah dihilangkan */
  background: linear-gradient(
    to top,
    rgba(4, 6, 15, 0.85) 0%,
    transparent 30%
  );
}
<?php endif; ?>
  /* 1. GAMBAR UTAMA (Pastikan ukurannya full dan cerah) */
  .slide-bg {
    position: absolute; 
    inset: 0;
    background-size: cover; 
    background-position: center; 
    z-index: 1; 
    opacity: 1; /* Harus 1 agar gambarnya muncul penuh */
  }

  /* 2. EFEK KACA BURAM (Glassmorphism) */
  .slide-bg::after {
    content: '';
    position: absolute;
    inset: 0;
    z-index: 2;
    background: rgba(201, 168, 76, 0.08); 
    
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    
    /* MASKING BARU: Hanya Blur di area Bawah saja, yang Atas dibiarkan jernih */
    -webkit-mask-image: linear-gradient(to top, black 0%, transparent 35%);
    mask-image: linear-gradient(to top, black 0%, transparent 35%);
  }

header, nav, .navbar {
    background: rgba(4, 6, 15, 0.2) !important; /* Warna gelap transparan tipis */
    backdrop-filter: blur(0px) !important;
    -webkit-backdrop-filter: blur(0px) !important;
    border-bottom: 1px solid rgba(201,168,76,0.12) !important;
    font-weight: 600 !important;
    letter-spacing: 0.05em;
    text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.8), 0px 0px 8px rgba(0, 0, 0, 0.6);
  }

  .goddess-overlay {
    display: none !important; /* Sembunyikan default, akan diaktifkan di slide tertentu */
  }
  .goddess-overlay canvas {
    width: 100%; height: 100%;
    object-fit: contain; object-position: bottom center;
    opacity: 0.22; filter: brightness(1.1) contrast(1.05);
  }
  .goddess-overlay::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(to right, var(--deep-navy) 0%, transparent 30%, transparent 70%, var(--deep-navy) 100%),
                linear-gradient(to top, var(--deep-navy) 0%, transparent 20%);
  }

  .moon-glow {
    position: absolute; right: 18%; top: 12%;
    width: 180px; height: 180px; border-radius: 50%;
    background: radial-gradient(circle, rgba(212,208,200,0.12) 0%, transparent 70%);
    z-index: 1; animation: moonPulse 6s ease-in-out infinite;
  }
  @keyframes moonPulse {
    0%, 100% { opacity: 0.6; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.08); }
  }

  .crescent {
    position: absolute; right: 21.5%; top: 10%;
    z-index: 3; opacity: 0.75;
    animation: moonPulse 6s ease-in-out infinite;
  }

  .hero-content {
    position: relative; z-index: 10;
    padding: 0 56px; 
    max-width: 700px;
  }
  .hero-eyebrow {
    display: flex; align-items: center; gap: 18px;
    font-family: 'Raleway', sans-serif; font-size: 11px;
    letter-spacing: 0.22em; color: #E8C96A; text-transform: uppercase;
    margin-bottom: 24px;
    text-shadow: 0 4px 24px rgba(0,0,0,0.9);
  }
  .hero-eyebrow::after {
    content: ''; display: block; width: 60px; height: 1px;
    background: var(--gold); opacity: 0.5;
    text-shadow: 0 4px 24px rgba(0,0,0,0.9);
  }
  .hero-title {
    font-family: 'Cinzel', serif; 
    font-size: clamp(42px, 6vw, 86px); /* Ini mengembalikan ukuran besar aslinya */
    font-weight: 400; line-height: 1.0; letter-spacing: 0.02em;
    color: #F0EBE0; margin-bottom: 10px;
     text-shadow: 0 2px 20px rgba(0,0,0,0.8), 0 0 40px rgba(0,0,0,0.6);
  }
  .hero-title span { color: var(--gold-light); }
  .hero-subtitle {
    font-family: 'Cinzel', serif; 
    font-size: clamp(20px, 2.8vw, 36px); /* Kembali lebih besar */
    font-weight: 400; letter-spacing: 0.06em; color: #D4D0C8;
    margin-bottom: 24px; opacity: 100%;
    text-shadow: 0 1px 12px rgba(0,0,0,0.9);
  }
  .hero-desc {
    font-size: 16px; line-height: 1.75; color: rgba(240,235,224,0.85);
    max-width: 480px; margin-bottom: 32px; 
    font-style: italic;
    text-shadow: 0 1px 12px rgba(0,0,0,0.9);
  }
  .hero-cta { display: flex; align-items: center; gap: 24px; }

  /* ── QUICK CARDS ── */
  <?php if (!session()->get('user_id')): ?>
  .hero-cards {
    position: absolute !important;
    bottom: 0 !important;
    left: 0; right: 0; 
    z-index: 30;
    display: grid; 
    grid-template-columns: repeat(3, 1fr);
    border-top: 1px solid rgba(201,168,76,0.2);
    background: transparent;
  }
  .hero-card {
    padding: 28px 40px; 
    background: rgba(4, 6, 15, 0.2);
    backdrop-filter: blur(0px);
    -webkit-backdrop-filter: blur(0px);
    border-right: 1px solid rgba(201,168,76,0.12);
    cursor: pointer; 
    transition: all 0.3s ease;
  }
  .hero-card:hover { background: rgba(201, 168, 76, 0.15); }
  .card-eyebrow {
    font-family: 'Raleway', sans-serif; font-size: 10px;
    letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 8px;
  }
  .card-title {
    font-family: 'Cinzel', serif; font-size: 15px; font-weight: 600;
    color: #F0EBE0; margin-bottom: 4px;
  }
  .card-sub { font-size: 13px; color: rgba(240,235,224,0.7); font-style: italic; }
  <?php endif; ?>

  /* ── SECTION DIVIDER & HEADERS ── */
  .section-header { text-align: center; padding: 80px 56px 48px; position: relative; z-index: 10; }
  .section-header h2 {
    font-family: 'Cinzel', serif; font-size: clamp(22px, 3vw, 36px);
    font-weight: 400; letter-spacing: 0.12em; color: var(--ivory); margin-bottom: 12px;
  }
  .section-header p { font-style: italic; color: var(--text-dim); font-size: 15px; }
  .divider-rune { display: flex; align-items: center; justify-content: center; gap: 16px; margin-bottom: 18px; }
  .divider-rune::before, .divider-rune::after {
    content: ''; display: block; width: 80px; height: 1px;
    background: linear-gradient(to right, transparent, var(--gold));
  }
  .divider-rune::after { background: linear-gradient(to left, transparent, var(--gold)); }

  /* ── CATEGORY FRAMES ── */
  #categories { position: relative; z-index: 10; padding: 0 40px 100px; }
  .frames-row { display: flex; align-items: center; justify-content: center; gap: 0; flex-wrap: nowrap; }
  .frame-item { display: flex; flex-direction: column; align-items: center; cursor: pointer; transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1); position: relative; }
  .frame-item:hover { transform: translateY(-12px) scale(1.07); z-index: 20; }
  .frame-item.active { transform: translateY(-18px) scale(1.14); z-index: 21; }
  .frame-item.side { transform: scale(0.78); opacity: 0.6; }
  .frame-item.side:hover { transform: scale(0.85) translateY(-8px); opacity: 0.85; }
  .frame-item.near { transform: scale(0.9); opacity: 0.8; }
  .frame-item.near:hover { transform: scale(0.97) translateY(-10px); opacity: 0.95; }
  .frame-svg-wrap { position: relative; width: 160px; height: 200px; display: flex; align-items: center; justify-content: center; background: none !important; }
  .frame-label { font-family: 'Cinzel', serif; font-size: 12px; letter-spacing: 0.1em; color: var(--moon-silver); text-align: center; margin-top: 6px; transition: color 0.2s; }
  .frame-item:hover .frame-label, .frame-item.active .frame-label { color: var(--gold-light); }
  .frame-sub { font-size: 10px; letter-spacing: 0.08em; color: var(--text-dim); text-align: center; margin-top: 3px; font-family: 'Raleway', sans-serif; }
  .frame-info { text-align: center; margin-top: 40px; min-height: 60px; transition: opacity 0.3s; }
  .frame-info h3 { font-family: 'Cinzel', serif; font-size: 20px; font-weight: 600; color: var(--gold-light); margin-bottom: 6px; }
  .frame-info p { font-style: italic; color: var(--text-dim); font-size: 14px; }
  .frame-arrows { display: flex; align-items: center; justify-content: center; gap: 20px; margin-top: 18px; }
  .frame-arrows button { background: none; border: 1px solid rgba(201,168,76,0.3); color: var(--gold); width: 36px; height: 36px; cursor: pointer; font-size: 16px; transition: all 0.2s; }
  .frame-arrows button:hover { background: rgba(201,168,76,0.1); border-color: var(--gold); }
  .frame-arrows span { font-family: 'Raleway', sans-serif; font-size: 12px; letter-spacing: 0.1em; color: var(--text-dim); }
  .frame-item image { transition: filter 0.3s ease, opacity 0.3s ease, transform 0.3s ease; filter: drop-shadow(0 0 0px transparent); }
  .frame-item:hover image, .frame-item.active image { opacity: 1 !important; filter: drop-shadow(0 0 12px #E8C96A) drop-shadow(0 0 4px #C9A84C) !important; }

  /* ── VOLUME SLIDER ── */
  #collection { position: relative; z-index: 10; padding: 0 0 80px; }
  .volume-slider-wrap { position: relative; overflow: hidden; }
  .volume-slider {
    display: flex; overflow-x: auto; gap: 28px;
    padding: 20px 56px 40px 56px;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    scrollbar-width: none;
    -ms-overflow-style: none;
  }
  .volume-slider::-webkit-scrollbar { display: none; }
  .volume-card {
    scroll-snap-align: center;
    min-width: 300px; flex: 0 0 300px;
    background: var(--bg-card, rgba(4,6,15,0.5));
    border: 1px solid rgba(201,168,76,0.18);
    border-radius: 6px;
    position: relative; overflow: hidden;
    cursor: pointer;
    transition: all 0.35s ease;
    display: flex; flex-direction: column;
  }
  .volume-card:hover {
    border-color: rgba(201,168,76,0.5);
    transform: translateY(-6px);
    box-shadow: 0 8px 32px rgba(201,168,76,0.1);
  }
  .volume-card .vol-cover {
    width: 100%; height: 180px;
    object-fit: cover;
    display: block;
    border-bottom: 1px solid rgba(201,168,76,0.12);
    background: linear-gradient(135deg, rgba(15,18,38,0.3), rgba(201,168,76,0.08));
  }
  .volume-card .vol-body {
    padding: 24px 24px 28px;
  }
  .volume-card .vol-label {
    font-family: 'Raleway', sans-serif;
    font-size: 11px; letter-spacing: 0.15em;
    text-transform: uppercase; color: var(--gold);
    margin-bottom: 10px; font-weight: 700;
  }
  .volume-card .vol-title {
    font-family: 'Cinzel', serif;
    font-size: 18px; font-weight: 400;
    color: var(--ivory); margin-bottom: 8px;
    line-height: 1.25;
  }
  .volume-card .vol-desc {
    font-size: 13px; line-height: 1.6;
    color: var(--text-muted, rgba(240,235,224,0.6));
    font-style: italic;
  }
  .volume-arrows {
    display: flex; align-items: center; justify-content: center;
    gap: 20px; margin-top: 8px;
  }
  .volume-arrows button {
    background: none; border: 1px solid rgba(201,168,76,0.3);
    color: var(--gold); width: 36px; height: 36px;
    cursor: pointer; font-size: 16px; transition: all 0.2s;
  }
  .volume-arrows button:hover {
    background: rgba(201,168,76,0.1); border-color: var(--gold);
  }
  .volume-arrows span {
    font-family: 'Raleway', sans-serif; font-size: 12px;
    letter-spacing: 0.1em; color: var(--text-dim);
  }

  /* ── BOOK PREVIEW MODAL ── */
.book-modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 9999;
  background: rgba(4, 6, 15, 0.92);
  backdrop-filter: blur(8px);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  visibility: hidden;
  transition: all 0.4s ease;
}
.book-modal-overlay.active {
  opacity: 1;
  visibility: visible;
}

.book-modal {
  background: linear-gradient(135deg, rgba(15,18,38,0.98) 0%, rgba(8,10,22,0.99) 100%);
  border: 1px solid rgba(201,168,76,0.25);
  width: 90%;
  max-width: 860px;
  max-height: 88vh;
  overflow-y: auto;
  position: relative;
  display: grid;
  grid-template-columns: 260px 1fr;
}

.book-modal::-webkit-scrollbar { width: 4px; }
.book-modal::-webkit-scrollbar-track { background: transparent; }
.book-modal::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.3); }

/* Tutup */
.modal-close {
  position: absolute;
  top: 16px; right: 20px;
  background: none;
  border: 1px solid rgba(201,168,76,0.3);
  color: var(--gold);
  width: 32px; height: 32px;
  font-size: 18px;
  cursor: pointer;
  z-index: 10;
  transition: all 0.2s;
  display: flex; align-items: center; justify-content: center;
}
.modal-close:hover { background: rgba(201,168,76,0.15); }

/* Kiri — Cover */
.modal-left {
  padding: 40px 28px;
  border-right: 1px solid rgba(201,168,76,0.12);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
  background: rgba(4,6,15,0.4);
}
.modal-cover {
  width: 100%;
  aspect-ratio: 2/3;
  object-fit: cover;
  border: 1px solid rgba(201,168,76,0.2);
  background: linear-gradient(135deg, #1a1a2e, #16213e);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 56px;
}
.modal-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.modal-stock {
  font-family: 'Raleway', sans-serif;
  font-size: 11px;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  padding: 6px 16px;
  border: 1px solid;
  text-align: center;
  width: 100%;
}
.modal-stock.available { color: #7ec8a0; border-color: rgba(126,200,160,0.4); }
.modal-stock.unavailable { color: #e07070; border-color: rgba(224,112,112,0.4); }

.modal-cta {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.modal-cta a, .modal-cta button {
  width: 100%;
  text-align: center;
  font-family: 'Raleway', sans-serif;
  font-size: 11px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  padding: 10px;
  cursor: pointer;
  text-decoration: none;
  transition: all 0.2s;
  display: block;
}
.modal-btn-primary {
  background: var(--gold);
  color: var(--deep-navy);
  border: none;
  font-weight: 700;
}
.modal-btn-primary:hover { background: var(--gold-light); }
.modal-btn-ghost {
  background: none;
  color: var(--gold);
  border: 1px solid rgba(201,168,76,0.4);
}
.modal-btn-ghost:hover { background: rgba(201,168,76,0.1); }

/* Kanan — Detail */
.modal-right {
  padding: 40px 36px 40px 32px;
}
.modal-type-badge {
  font-family: 'Raleway', sans-serif;
  font-size: 10px;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: var(--gold);
  border: 1px solid rgba(201,168,76,0.3);
  padding: 3px 12px;
  display: inline-block;
  margin-bottom: 14px;
}
.modal-title {
  font-family: 'Cinzel', serif;
  font-size: clamp(20px, 3vw, 30px);
  font-weight: 400;
  color: var(--ivory);
  line-height: 1.15;
  margin-bottom: 6px;
}
.modal-author {
  font-size: 14px;
  color: var(--gold-light);
  font-style: italic;
  margin-bottom: 20px;
}

/* Metadata grid */
.modal-meta-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px 24px;
  border-top: 1px solid rgba(201,168,76,0.12);
  border-bottom: 1px solid rgba(201,168,76,0.12);
  padding: 18px 0;
  margin-bottom: 20px;
}
.meta-item {}
.meta-label {
  font-family: 'Raleway', sans-serif;
  font-size: 10px;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 4px;
}
.meta-value {
  font-size: 13px;
  color: var(--moon-silver);
}

.modal-desc-label {
  font-family: 'Raleway', sans-serif;
  font-size: 10px;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 10px;
}
.modal-desc {
  font-size: 14px;
  line-height: 1.8;
  color: var(--text-dim);
  font-style: italic;
}

/* Preview PDF */
.modal-preview {
  margin-top: 24px;
  border-top: 1px solid rgba(201,168,76,0.12);
  padding-top: 20px;
}
.modal-preview-label {
  font-family: 'Raleway', sans-serif;
  font-size: 10px;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 12px;
}
.modal-pdf-frame {
  width: 100%;
  height: 320px;
  border: 1px solid rgba(201,168,76,0.15);
  background: rgba(4,6,15,0.6);
}
.modal-pdf-placeholder {
  width: 100%;
  height: 120px;
  border: 1px dashed rgba(201,168,76,0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-dim);
  font-style: italic;
  font-size: 13px;
}

  /* ── NEBULA BAND ── */
  .nebula-band {
    position: relative; z-index: 10; padding: 60px 56px; text-align: center; margin-bottom: 0;
    background: linear-gradient(135deg, rgba(60,20,80,0.18) 0%, rgba(20,40,90,0.22) 50%, rgba(60,20,80,0.18) 100%);
    border-top: 1px solid rgba(201,168,76,0.1); border-bottom: 1px solid rgba(201,168,76,0.1);
  }
  .nebula-band h2 { font-family: 'Cinzel', serif; font-size: 28px; font-weight: 400; letter-spacing: 0.1em; color: var(--ivory); margin-bottom: 10px; }
  .nebula-band p { font-style: italic; color: var(--text-dim); margin-bottom: 28px; }
  .nebula-band input {
    background: rgba(255,255,255,0.04); border: 1px solid rgba(201,168,76,0.3); color: var(--ivory); font-family: 'EB Garamond', serif; font-size: 15px; padding: 12px 24px; width: 360px; max-width: 100%; margin-right: 12px; outline: none;
  }
  .nebula-band input::placeholder { color: var(--text-dim); font-style: italic; }
  .nebula-band input:focus { border-color: var(--gold); }

  /* ── SCROLL INDICATOR & COUNTER ── */
  .scroll-hint { 
    position: absolute; bottom: <?php echo (!session()->get('user_id')) ? '105px' : '40px'; ?>; left: 56px; 
    z-index: 20; display: flex; align-items: center; gap: 10px; 
    font-family: 'Raleway', sans-serif; font-size: 10px; letter-spacing: 0.2em; 
    color: var(--text-dim); text-transform: uppercase; animation: fadeUpDown 2.5s ease-in-out infinite; 
  }
  .scroll-hint::before { content: ''; width: 1px; height: 40px; background: linear-gradient(to bottom, transparent, var(--gold-dim)); }
  @keyframes fadeUpDown { 0%, 100% { opacity: 0.4; transform: translateY(0); } 50% { opacity: 0.9; transform: translateY(6px); } }
  
  .hero-content {
    position: relative; 
    z-index: 10;
    padding: 0 56px; 
    margin-top: 0; /* KUNCI: Hapus margin-top yang bikin berantakan sebelumnya */
    max-width: 700px;
  }

  .hero-counter { 
    position: absolute; bottom: <?php echo (!session()->get('user_id')) ? '105px' : '40px'; ?>; right: 56px; 
    z-index: 20; font-family: 'Raleway', sans-serif; font-size: 12px; 
    letter-spacing: 0.1em; color: var(--text-dim); display: flex; align-items: center; gap: 16px; 
  }

  .hero-counter button { 
    background: rgba(201,168,76,0.1); border: 1px solid rgba(201,168,76,0.3); 
    color: var(--gold); width: 36px; height: 36px; border-radius: 50%;
    font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: all 0.3s ease; pointer-events: auto; 
  }

 .hero-counter button:hover { 
    background: rgba(201,168,76,0.3); border-color: var(--gold); color: var(--ivory);
  }

 @media (max-height: 750px) {
    .swiper-slide { padding-top: 90px; }
    .hero-title { font-size: 42px; }
    .hero-subtitle { font-size: 20px; }
    .hero-desc { font-size: 14px; margin-bottom: 16px; line-height: 1.4; }
    .scroll-hint, .hero-counter { bottom: <?php echo (!session()->get('user_id')) ? '95px' : '20px'; ?>; }
    <?php if (!session()->get('user_id')): ?>
    .hero-cards .hero-card { padding: 18px 30px; }
    <?php endif; ?>
  }
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<section id="hero">
  
  <div class="swiper swiper-hero">
    <div class="swiper-wrapper">
      
      <div class="swiper-slide">
  <div class="slide-bg" style="background-image: url('<?= base_url('assets/images/bg-1-celestia-rev.png') ?>');"></div>

        <div class="moon-glow"></div>
        <svg class="crescent" width="70" height="50" viewBox="0 0 70 50">
          <path d="M55 10 C55 10 30 14 30 25 C30 36 55 40 55 40 C40 38 22 33 22 25 C22 17 40 12 55 10Z" fill="none" stroke="#C9A84C" stroke-width="1.5" opacity="0.8"/>
        </svg>
        <div class="goddess-overlay"><canvas id="goddessCanvas"></canvas></div>

        <div class="hero-content">
          <div class="hero-eyebrow">The Eternal Archive</div>
          <h1 class="hero-title">CELESTIA<br><span>BIBLIOTHECA</span></h1>
          <p class="hero-subtitle">Where Stars Write in Ink</p>
          <p class="hero-desc">A celestial sanctuary of knowledge, myth, and wonder. Explore thousands of volumes illuminated beneath an eternal night sky from ancient lore to the furthest reaches of imagination 🪶✨.</p>
          <div class="hero-cta">
            <a href="<?= base_url('register') ?>" class="btn-primary" style="text-decoration:none;">Enter the Archive</a>
            <a href="<?= base_url('catalog') ?>" class="btn-ghost">Browse Collections</a>
          </div>
        </div>
      </div>

      <div class="swiper-slide">
        <a href="<?= base_url('book/detail/1') ?>" style="position:absolute; inset:0; z-index:5; display:block;"></a> 
        <div class="slide-bg" style="background-image: url('<?= base_url('assets/images/the-song-of-achilles-revpng.png.png') ?>');"></div>
        
        <div class="hero-content">
          <div class="hero-eyebrow">New Arrival</div>
          <h1 class="hero-title">THE SONG OF<br><span>ACHILLES</span></h1>
          <p class="hero-subtitle">Fantasy · Vol. I</p>
          <p class="hero-desc">A tale of gods, kings, and immortal fame. Delve into the tragic and beautiful epic of the Trojan War hero.</p>
          <div class="hero-cta">
            <button onclick="openBookModal(1)" class="btn-primary" style="border:none; cursor:pointer; position:relative; z-index:10;">Read Now</button>
          </div>
        </div>
      </div>

      <div class="swiper-slide">
        <a href="<?= base_url('book/detail/2') ?>" style="position:absolute; inset:0; z-index:5; display:block;"></a>
        <div class="slide-bg" style="background-image: url('<?= base_url('assets/images/babel.png') ?>');"></div>
        
        <div class="hero-content">
          <div class="hero-eyebrow">Hot Topic</div>
          <h1 class="hero-title">BABEL, Or The<br><span>Necessity Of VIOLENCE</span></h1>
          <p class="hero-subtitle">Fantasy · Vol. I</p>
          <p class="hero-desc"> Language is not just communication, but a foundational tool that shapes reality and enforces colonial hierarchies.</p>
          <div class="hero-cta">
            <button onclick="openBookModal(2)" class="btn-primary" style="border:none; cursor:pointer; position:relative; z-index:10;">Read Now</button>
          </div>
        </div>
      </div>

      <div class="swiper-slide">
        <a href="<?= base_url('book/detail/3') ?>" style="position:absolute; inset:0; z-index:5; display:block;"></a>
        <div class="slide-bg" style="background-image: url('<?= base_url('assets/images/capitol-marx.png') ?>');"></div>
        
        <div class="hero-content">
          <div class="hero-eyebrow">PHILOSOPHY 101</div>
          <h1 class="hero-title">CAPITAL: A Critique of, Or The<br><span>Political Economy</span></h1>
          <p class="hero-subtitle">Philosophy and Social Theory</p>
          <p class="hero-desc">a critical analysis of political economy, meant to reveal the economic patterns underpinning the capitalist mode of production.</p>
          <div class="hero-cta">
            <button onclick="openBookModal(3)" class="btn-primary" style="border:none; cursor:pointer; position:relative; z-index:10;">Read Now</button>
          </div>
        </div>
      </div>

      <div class="swiper-slide">
         <a href="<?= base_url('book/detail/4') ?>" style="position:absolute; inset:0; z-index:5; display:block;"></a>
        <div class="slide-bg" style="background-image: url('<?= base_url('assets/images/white-nights.png') ?>');"></div>
        
        <div class="hero-content">
          <div class="hero-eyebrow">ODOC<br></span>One Day One Classic</div>
          <h1 class="hero-title">WHITE<br><span>Nights</span></h1>
          <p class="hero-subtitle">Ultimate Timeless Classics</p>
          <p class="hero-desc">“Your hand is cold, mine burns like fire. How blind you are, Nastenka!”</p>
          <div class="hero-cta">
            <button onclick="openBookModal(4)" class="btn-primary" style="border:none; cursor:pointer; position:relative; z-index:10;">Read Now</button>
          </div>
        </div>
      </div>

    </div>
  </div> <div class="scroll-hint">Scroll to discover</div>

  <!-- BOOK PREVIEW MODAL -->
<div class="book-modal-overlay" id="bookModal">
  <div class="book-modal">
    <button class="modal-close" id="modalClose">✕</button>

    <!-- Kiri: Cover + CTA -->
    <div class="modal-left">
      <div class="modal-cover" id="modalCover">📖</div>
      <div class="modal-stock" id="modalStock"></div>
      <div class="modal-cta" id="modalCta"></div>
    </div>

    <!-- Kanan: Detail -->
    <div class="modal-right">
      <span class="modal-type-badge" id="modalType"></span>
      <h2 class="modal-title" id="modalTitle"></h2>
      <p class="modal-author" id="modalAuthor"></p>

      <div class="modal-meta-grid" id="modalMeta"></div>

      <div class="modal-desc-label">Sinopsis</div>
      <p class="modal-desc" id="modalDesc"></p>

      <div class="modal-preview" id="modalPreview"></div>
    </div>
  </div>
</div>
  
  <div class="hero-counter">
    <button class="btn-hero-prev">←</button> 
    <span id="slideNum">1 / 5</span> 
    <button class="btn-hero-next">→</button>
  </div>

  <?php if (!session()->get('user_id')): ?>
  <div class="hero-cards">
    <a href="<?= base_url('buku/1') ?>" class="hero-card" style="text-decoration: none; display: block;">
      <div class="card-eyebrow">New Arrival</div>
      <div class="card-title">The Song Of Achilles</div>
      <div class="card-sub">Fantasy · Vol. I added to collection</div>
    </a>

    <a href="<?= base_url('reading-rooms') ?>" class="hero-card" style="text-decoration: none; display: block;">
      <div class="card-eyebrow">Reading Room</div>
      <div class="card-title">Moonlit Reading Session</div>
      <div class="card-sub">Every eve at 8 & 10 PM · Open to all</div>
    </a>

    <a href="<?= base_url('mini-journalism') ?>" class="hero-card" style="text-decoration: none; display: block;">
      <div class="card-eyebrow">What's New</div>
      <div class="card-title">Romance classic Discussion...</div>
      <div class="card-sub">Curator's choice · Minor Journalism</div>
    </a>
  </div>
  <?php endif; ?>

</section>

<!-- ═══════════════════════════════════════════
     SEARCH BAND (above Constellations)
════════════════════════════════════════════ -->
<div class="nebula-band">
  <h2>Search the Stars</h2>
  <p>Every star is a story. Find yours.</p>
  <form action="<?= base_url('catalog') ?>" method="get" style="display:inline-flex; align-items:center;">
    <input type="text" name="q" placeholder="Title, author, constellation…" />
    <button type="submit" class="btn-primary">Search</button>
  </form>
</div>

<!-- ═══════════════════════════════════════════
     EXPLORE THE CONSTELLATIONS
════════════════════════════════════════════ -->
<section>
  <div class="section-header">
    <div class="divider-rune">✦</div>
    <h2>Explore the Constellations</h2>
    <p>Each constellation guards a different realm of knowledge. Choose your path.</p>
  </div>
  <div id="categories">
    <div class="frames-row" id="framesRow"></div>
    <div class="frame-info" id="frameInfo"></div>
    <div class="frame-arrows">
      <button id="prevFrame">←</button> <span id="frameCounter">3 / 7</span> <button id="nextFrame">→</button>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     FEATURED VOLUMES (Hardcoded Journal Slider)
════════════════════════════════════════════ -->
<section>
  <div class="section-header">
    <div class="divider-rune">✦</div>
    <h2>Featured Volumes</h2>
    <p>Curated journals from across the celestial archive</p>
  </div>
  <div id="collection">
    <div class="volume-slider-wrap">
      <div class="volume-slider" id="volumeSlider">

        <!-- ODOC -->
        <a href="<?= base_url('odoc/latest') ?>" style="text-decoration:none; display:block;">
          <div class="volume-card">
            <img class="vol-cover" src="<?= base_url('assets/images/vol-odoc.png') ?>" alt="ODOC" onerror="this.style.display='none'">
            <div class="vol-body">
              <div class="vol-label">Classic</div>
              <div class="vol-title">ODOC (One Day One Classic)</div>
              <div class="vol-desc">A daily dive into the world's most timeless literature and ancient texts.</div>
            </div>
          </div>
        </a>

        <!-- New Arrival -->
        <a href="<?= base_url('catalog') ?>" style="text-decoration:none; display:block;">
          <div class="volume-card">
            <img class="vol-cover" src="<?= base_url('assets/images/vol-new-arrival.png') ?>" alt="New Arrival" onerror="this.style.display='none'">
            <div class="vol-body">
              <div class="vol-label">New Arrival</div>
              <div class="vol-title">New Arrival</div>
              <div class="vol-desc">The latest additions to our celestial collection — fresh off the cosmic press.</div>
            </div>
          </div>
        </a>

        <!-- Fantasy Volume I -->
        <a href="<?= base_url('catalog?q=fantasy') ?>" style="text-decoration:none; display:block;">
          <div class="volume-card">
            <img class="vol-cover" src="<?= base_url('assets/images/vol-fantasy.png') ?>" alt="Fantasy Volume I" onerror="this.style.display='none'">
            <div class="vol-body">
              <div class="vol-label">Chef on The Shelf</div>
              <div class="vol-title">Fantasy Volume I</div>
              <div class="vol-desc">Doraemon door to different world</div>
            </div>
          </div>
        </a>

        <!-- Mini Journalism of the Week -->
        <a href="<?= base_url('mini-journalism') ?>" style="text-decoration:none; display:block;">
          <div class="volume-card">
            <img class="vol-cover" src="<?= base_url('assets/images/vol-journalism.png') ?>" alt="Mini Journalism" onerror="this.style.display='none'">
            <div class="vol-body">
              <div class="vol-label">What's New</div>
              <div class="vol-title">Mini Journalism of the Week</div>
              <div class="vol-desc">Curator's choice — a weekly spotlight on minor journalism and literary gems.</div>
            </div>
          </div>
        </a>

      </div>
      <div class="volume-arrows">
        <button id="volPrev">←</button>
        <span id="volCounter">1 / 4</span>
        <button id="volNext">→</button>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
// ── GODDESS CANVAS ──
(function() {
  const canvas = document.getElementById('goddessCanvas');
  if (!canvas) return;
  function setSize() {
    canvas.width = canvas.offsetWidth * window.devicePixelRatio;
    canvas.height = canvas.offsetHeight * window.devicePixelRatio;
  }
  setSize();
  const ctx = canvas.getContext('2d');
  const w = canvas.width, h = canvas.height;
  ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
  const dw = canvas.offsetWidth, dh = canvas.offsetHeight;

  ctx.save();
  ctx.globalAlpha = 1;
  const fig = ctx.createLinearGradient(dw*0.35, 0, dw*0.65, dh);
  fig.addColorStop(0, 'rgba(212,208,200,0.28)');
  fig.addColorStop(0.4, 'rgba(212,208,200,0.22)');
  fig.addColorStop(1, 'rgba(212,208,200,0.04)');
  ctx.fillStyle = fig;

  const cx = dw * 0.5, cy = dh * 0.1;
  ctx.beginPath();
  ctx.ellipse(cx, cy + dh*0.055, dw*0.058, dh*0.072, 0, 0, Math.PI*2);
  ctx.fill();
  ctx.beginPath();
  ctx.arc(cx, cy + dh*0.005, dw*0.04, Math.PI*1.1, Math.PI*1.9, false);
  ctx.lineWidth = dw*0.012; ctx.strokeStyle = 'rgba(201,168,76,0.55)'; ctx.stroke();

  ctx.beginPath();
  ctx.moveTo(cx - dw*0.06, cy + dh*0.13);
  ctx.bezierCurveTo(cx - dw*0.14, cy + dh*0.22, cx - dw*0.22, cy + dh*0.38, cx - dw*0.18, cy + dh*0.6);
  ctx.bezierCurveTo(cx - dw*0.12, cy + dh*0.82, cx - dw*0.08, cy + dh*0.92, cx, cy + dh*0.97);
  ctx.bezierCurveTo(cx + dw*0.08, cy + dh*0.92, cx + dw*0.12, cy + dh*0.82, cx + dw*0.18, cy + dh*0.6);
  ctx.bezierCurveTo(cx + dw*0.22, cy + dh*0.38, cx + dw*0.14, cy + dh*0.22, cx + dw*0.06, cy + dh*0.13);
  ctx.closePath(); ctx.fillStyle = fig; ctx.fill();

  ctx.beginPath();
  ctx.moveTo(cx, cy + dh*0.12);
  ctx.bezierCurveTo(cx + dw*0.15, cy + dh*0.04, cx + dw*0.38, cy + dh*0.08, cx + dw*0.44, cy + dh*0.22);
  ctx.bezierCurveTo(cx + dw*0.46, cy + dh*0.35, cx + dw*0.32, cy + dh*0.42, cx + dw*0.18, cy + dh*0.44);
  ctx.bezierCurveTo(cx + dw*0.08, cy + dh*0.42, cx + dw*0.04, cy + dh*0.32, cx, cy + dh*0.2);
  ctx.fillStyle = 'rgba(200,195,185,0.13)'; ctx.fill();

  ctx.beginPath();
  ctx.moveTo(cx, cy + dh*0.12);
  ctx.bezierCurveTo(cx - dw*0.15, cy + dh*0.04, cx - dw*0.38, cy + dh*0.08, cx - dw*0.44, cy + dh*0.22);
  ctx.bezierCurveTo(cx - dw*0.46, cy + dh*0.35, cx - dw*0.32, cy + dh*0.42, cx - dw*0.18, cy + dh*0.44);
  ctx.bezierCurveTo(cx - dw*0.08, cy + dh*0.42, cx - dw*0.04, cy + dh*0.32, cx, cy + dh*0.2);
  ctx.fillStyle = 'rgba(200,195,185,0.13)'; ctx.fill();
  ctx.restore();
})();

// ── CATEGORY FRAMES ──
// Icon mapping berdasarkan nama kategori
const iconMap = {
  'computer': '<?= base_url("assets/images/icon computer.png") ?>',
  'philosophy': '<?= base_url("assets/images/icon philosophy-psychology.png") ?>',
  'religion': '<?= base_url("assets/images/icon religion.png") ?>',
  'social': '<?= base_url("assets/images/icon social-sciences.png") ?>',
  'language': '<?= base_url("assets/images/icon language.png") ?>',
  'science': '<?= base_url("assets/images/icon sciences.png") ?>',
  'technology': '<?= base_url("assets/images/icon technology.png") ?>',
  'art': '<?= base_url("assets/images/icon arts-recreation.png") ?>',
  'history': '<?= base_url("assets/images/icon history-geography.png") ?>',
  'literature': '<?= base_url("assets/images/icon literature.png") ?>',
};

function getIconForCategory(name) {
  const lower = name.toLowerCase();
  for (const [key, url] of Object.entries(iconMap)) {
    if (lower.includes(key)) return url;
  }
  return '<?= base_url("assets/images/icon computer.png") ?>';
}

// Bangun array kategori dari data database yang sesungguhnya
const categories = [
<?php if (!empty($categories)): ?>
  <?php foreach ($categories as $cat): ?>
  {
    icon: getIconForCategory(<?= json_encode($cat['name']) ?>),
    label: <?= json_encode($cat['name']) ?>,
    category_id: <?= (int)$cat['id'] ?>,
    sub: '',
    info: <?= json_encode($cat['description'] ?? 'Jelajahi koleksi di kategori ini.') ?>
  },
  <?php endforeach; ?>
<?php endif; ?>
];
let activeFrame = 3;

function renderFrames() {
  const row = document.getElementById('framesRow');
  row.innerHTML = '';
  const total = categories.length;
  
  const positions = [-4, -3, -2, -1, 0, 1, 2, 3, 4];

  positions.forEach(offset => {
    const idx = ((activeFrame + offset) % total + total) % total;
    const cat = categories[idx];
    const item = document.createElement('div');
    item.className = 'frame-item' + (offset === 0 ? ' active' : offset === -1 || offset === 1 ? ' near' : ' side');

    const frameColors = ['#7A5C28','#8B6914','#9E7A2C','#C9A84C','#9E7A2C','#8B6914','#7A5C28'];
    const fc = frameColors[offset + 3] || '#7A5C28';
    const fc2 = offset === 0 ? '#E8C96A' : '#C9A84C';

    item.innerHTML = `
      <div class="frame-svg-wrap">${getFrameSVG(fc, fc2, cat.icon, offset === 0)}</div>
      <div class="frame-label">${cat.label}</div>
    `;
    
    item.addEventListener('click', () => { 
      if (activeFrame === idx) {
        window.location.href = "<?= base_url('catalog?category=') ?>" + cat.category_id;
      } else {
        activeFrame = idx; 
        renderFrames(); 
      }
    });
    
    row.appendChild(item);
  });

  const activeCat = categories[activeFrame];
  document.getElementById('frameInfo').innerHTML = `
    <h3>${activeCat.label}</h3>
    <p>${activeCat.info}</p>
    <a href="<?= base_url('catalog?category=') ?>${activeCat.category_id}" class="btn-ghost" style="margin-top: 12px; display: inline-block;">
      Jelajahi Koleksi ${activeCat.label} ➔
    </a>
  `;
  document.getElementById('frameCounter').textContent = `${activeFrame + 1} / ${total}`;
}

function getFrameSVG(fc, fc2, iconUrl, active) {
  const imgSize = active ? 200 : 170;
  const xPos = 80 - (imgSize / 2);
  const yPos = 100 - (imgSize / 2);

  return `
  <svg viewBox="0 0 160 200" width="160" height="200" xmlns="http://www.w3.org/2000/svg">
    <image href="${iconUrl}" x="${xPos}" y="${yPos}" width="${imgSize}" height="${imgSize}" preserveAspectRatio="xMidYMid meet" opacity="${active ? 1 : 0.5}" />
  </svg>`;
}
renderFrames();
document.getElementById('prevFrame').addEventListener('click', () => { activeFrame = (activeFrame - 1 + categories.length) % categories.length; renderFrames(); });
document.getElementById('nextFrame').addEventListener('click', () => { activeFrame = (activeFrame + 1) % categories.length; renderFrames(); });

// ── VOLUME SLIDER ──
(function() {
  const slider = document.getElementById('volumeSlider');
  const cards = slider.querySelectorAll('.volume-card');
  const counter = document.getElementById('volCounter');
  const total = cards.length;
  let currentVol = 0;

  function scrollToVol(idx) {
    currentVol = ((idx % total) + total) % total;
    const cardWidth = cards[0].offsetWidth + 28; // card width + gap
    slider.scrollTo({ left: currentVol * cardWidth, behavior: 'smooth' });
    counter.textContent = (currentVol + 1) + ' / ' + total;
  }

  document.getElementById('volPrev').addEventListener('click', () => scrollToVol(currentVol - 1));
  document.getElementById('volNext').addEventListener('click', () => scrollToVol(currentVol + 1));

  // Update counter on manual scroll
  let scrollTimer;
  slider.addEventListener('scroll', function() {
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(function() {
      const scrollLeft = slider.scrollLeft;
      const cardWidth = cards[0].offsetWidth + 28;
      const idx = Math.round(scrollLeft / cardWidth);
      if (idx >= 0 && idx < total) {
        currentVol = idx;
        counter.textContent = (currentVol + 1) + ' / ' + total;
      }
    }, 100);
  });
})();


// ── INISIALISASI SWIPER HERO ──
document.addEventListener("DOMContentLoaded", function() {
  const heroSwiper = new Swiper('.swiper-hero', {
    loop: true,
    speed: 1000,
    effect: 'fade',
    fadeEffect: { crossFade: true },
    autoplay: {
      delay: 6000,
      disableOnInteraction: true,
    },
  });

  // Update slide number
  function updateSlideNumber() {
    const total = 5; // sesuaikan jumlah slide
    const current = heroSwiper.realIndex + 1;
    document.getElementById('slideNum').textContent = current + ' / ' + total;
  }

  // Hubungkan tombol ke Swiper
  document.querySelector('.btn-hero-prev').addEventListener('click', function() {
    heroSwiper.slidePrev();
  });

  document.querySelector('.btn-hero-next').addEventListener('click', function() {
    heroSwiper.slideNext();
  });

  // Update nomor saat slide berubah
  heroSwiper.on('slideChange', function() {
    updateSlideNumber();
  });

  // ── BOOK MODAL ──
function openBookModal(bookId) {
  fetch(`<?= base_url('buku/detail/') ?>${bookId}`)
    .then(res => res.json())
    .then(book => {
      // Type badge
      document.getElementById('modalType').textContent = book.type ?? 'Buku';

      // Cover
      const coverEl = document.getElementById('modalCover');
      if (book.cover_image) {
        coverEl.innerHTML = `<img src="<?= base_url('uploads/covers/') ?>${book.cover_image}" alt="${book.title}">`;
      } else {
        coverEl.innerHTML = '📖';
      }

      // Judul & Author
      document.getElementById('modalTitle').textContent = book.title;
      document.getElementById('modalAuthor').textContent = book.author;

      // Stock
      const stockEl = document.getElementById('modalStock');
      if (parseInt(book.stock_available) > 0) {
        stockEl.textContent = `✦ ${book.stock_available} Tersedia`;
        stockEl.className = 'modal-stock available';
      } else {
        stockEl.textContent = '✦ Tidak Tersedia';
        stockEl.className = 'modal-stock unavailable';
      }

      // Metadata
      document.getElementById('modalMeta').innerHTML = `
        <div class="meta-item">
          <div class="meta-label">Penerbit</div>
          <div class="meta-value">${book.publisher ?? '—'}</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Tahun</div>
          <div class="meta-value">${book.year ?? '—'}</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">ISBN</div>
          <div class="meta-value">${book.isbn ?? '—'}</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Bahasa</div>
          <div class="meta-value">${book.language ?? '—'}</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Halaman</div>
          <div class="meta-value">${book.pages ? book.pages + ' hlm' : '—'}</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Call Number</div>
          <div class="meta-value">${book.call_number ?? '—'}</div>
        </div>
      `;

      // Deskripsi
      document.getElementById('modalDesc').textContent = book.description ?? 'Tidak ada sinopsis.';

      // CTA
      let ctaHtml = '';
      if (book.file_pdf) {
        ctaHtml += `<a href="<?= base_url('uploads/pdf/') ?>${book.file_pdf}" target="_blank" class="modal-btn-primary">Baca Sekarang</a>`;
      }
      ctaHtml += `<a href="<?= base_url('buku/') ?>${book.id}" class="modal-btn-ghost">Lihat Halaman Buku</a>`;
      document.getElementById('modalCta').innerHTML = ctaHtml;

      // Preview PDF
      const previewEl = document.getElementById('modalPreview');
      if (book.file_pdf) {
        previewEl.innerHTML = `
          <div class="modal-preview-label">Preview Dokumen</div>
          <iframe class="modal-pdf-frame" src="<?= base_url('uploads/pdf/') ?>${book.file_pdf}#toolbar=0&navpanes=0&scrollbar=0&view=FitH" frameborder="0"></iframe>
        `;
      } else {
        previewEl.innerHTML = `
          <div class="modal-preview-label">Preview Dokumen</div>
          <div class="modal-pdf-placeholder">✦ Preview tidak tersedia untuk koleksi ini ✦</div>
        `;
      }

      // Buka modal
      document.getElementById('bookModal').classList.add('active');
      document.body.style.overflow = 'hidden';
    })
    .catch(err => console.error('Gagal memuat data buku:', err));
}

// Tutup modal
document.getElementById('modalClose').addEventListener('click', () => {
  document.getElementById('bookModal').classList.remove('active');
  document.body.style.overflow = '';
});
document.getElementById('bookModal').addEventListener('click', function(e) {
  if (e.target === this) {
    this.classList.remove('active');
    document.body.style.overflow = '';
  }
});

// Tutup dengan ESC
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    document.getElementById('bookModal').classList.remove('active');
    document.body.style.overflow = '';
  }
});

});
</script>
<?= $this->endSection() ?>
