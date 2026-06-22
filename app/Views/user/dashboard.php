<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>

  /* ── HERO SECTION & SWIPER ── */
  #hero {
    position: relative; 
    width: 100%; 
    height: 80vh; /* Kunci tinggi 100% layar */
    overflow: hidden; 
     
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

  /* ── HERO SECTION & SWIPER ── */
  #hero {
    position: relative; 
    width: 100%; 
    height: 80vh; /* Kunci tinggi 100% layar */
    overflow: hidden; 
     
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
  );
}
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
    position: absolute; bottom: 40px; left: 56px; 
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
    position: absolute; bottom: 40px; right: 56px; 
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
    .scroll-hint, .hero-counter { bottom: 20px; }
  }


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
<?= $this->endSection() ?>

<?= $this->section('content') ?>

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
            <span class="dash-stat-val"><?= number_format($total_buku, 0, ',', '.') ?>+</span>
            <span class="dash-stat-lbl">Koleksi</span>
        </div>
        <div>
            <span class="dash-stat-val"><?= number_format($total_anggota, 0, ',', '.') ?>+</span>
            <span class="dash-stat-lbl">Anggota Aktif</span>
        </div>
        <div>
            <span class="dash-stat-val"><?= $total_layanan ?></span>
            <span class="dash-stat-lbl">Layanan</span>
        </div>
    </div>
</section>

<!-- 2. STARRY NIGHT HERO -->
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

      <div class="modal-desc-label">Preview</div>
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

</section>

<!-- 3. KOLEKSI UNGGULAN -->
<section class="section">
    <div class="section-header-flex">
        <div class="section-title-main">✦ Koleksi Unggulan</div>
        <a href="/catalog" class="section-link">Lihat semua →</a>
    </div>

    <div class="book-grid">
        <?php if (!empty($featured)): ?>
            <?php
            $covers = ['cover-cosmos','cover-myth','cover-sci','cover-lit'];
            foreach ($featured as $i => $book): ?>
            <a href="/book/detail/<?= $book['id'] ?>" class="book-card" style="text-decoration:none">
                <div class="book-cover <?= $covers[$i % 4] ?>" style="padding: 0; display: block;">
                    <img src="<?= base_url('uploads/covers/' . ($book['cover_image'] ?? 'placeholder.jpg')) ?>" alt="<?= esc($book['title']) ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px 6px 0 0;">
                </div>
                <div class="book-info">
                    <div class="book-title"><?= esc($book['title']) ?></div>
                    <div class="book-author"><?= esc($book['author']) ?></div>
                    <div class="book-meta">
                        <span class="book-stock <?= $book['stock_available'] > 0 ? 'stock-ok' : 'stock-out' ?>">
                            <?= $book['stock_available'] > 0 ? 'Tersedia' : 'Habis' ?>
                        </span>
                        <span style="font-size:11px;color:var(--text-dim)"><?= $book['year'] ?? '' ?></span>
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

<!-- 5. FEATURED VOLUMES -->
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

<!-- 6. LAYANAN TERPADU -->
<section class="section" style="padding-top: 0;">
    <div class="section-header-flex">
        <div class="section-title-main">⚡ Layanan Anggota</div>
    </div>
    <div class="volume-slider-wrap">
      <div class="volume-slider" id="servicesSlider">
        <a href="/book-delivery" style="text-decoration:none; display:block;">
          <div class="volume-card">
            <div style="font-size: 40px; text-align: center; margin-top: 20px;">🚚</div>
            <div class="vol-body">
              <div class="vol-label">Physical Service</div>
              <div class="vol-title">Book Delivery</div>
              <div class="vol-desc">Pesan buku fisik langsung ke alamat Anda.</div>
            </div>
          </div>
        </a>
        <a href="/room-booking" style="text-decoration:none; display:block;">
          <div class="volume-card">
            <div style="font-size: 40px; text-align: center; margin-top: 20px;">🏛️</div>
            <div class="vol-body">
              <div class="vol-label">Facility</div>
              <div class="vol-title">Room Booking</div>
              <div class="vol-desc">Reservasi ruang baca dan diskusi eksklusif.</div>
            </div>
          </div>
        </a>
        <a href="/referensi" style="text-decoration:none; display:block;">
          <div class="volume-card">
            <div style="font-size: 40px; text-align: center; margin-top: 20px;">🔍</div>
            <div class="vol-body">
              <div class="vol-label">Academic</div>
              <div class="vol-title">Layanan Referensi</div>
              <div class="vol-desc">Akses literatur spesialis dan ensiklopedia tingkat lanjut.</div>
            </div>
          </div>
        </a>
        <a href="/sitasi" style="text-decoration:none; display:block;">
          <div class="volume-card">
            <div style="font-size: 40px; text-align: center; margin-top: 20px;">📝</div>
            <div class="vol-body">
              <div class="vol-label">Academic</div>
              <div class="vol-title">Panduan Sitasi & AI Checker</div>
              <div class="vol-desc">Cek gaya kutipan dan level AI karya tulismu.</div>
            </div>
          </div>
        </a>
        <a href="/mendeley-class" style="text-decoration:none; display:block;">
          <div class="volume-card">
            <div style="font-size: 40px; text-align: center; margin-top: 20px;">📖</div>
            <div class="vol-body">
              <div class="vol-label">Course</div>
              <div class="vol-title">Mendeley Class</div>
              <div class="vol-desc">Kelas khusus manajemen referensi dengan jadwal cerdas.</div>
            </div>
          </div>
        </a>
        <a href="/konsultasi" style="text-decoration:none; display:block;">
          <div class="volume-card">
            <div style="font-size: 40px; text-align: center; margin-top: 20px;">💬</div>
            <div class="vol-body">
              <div class="vol-label">Consultation</div>
              <div class="vol-title">Konsultasi Umum</div>
              <div class="vol-desc">Bimbingan dasar penelusuran sumber referensi yang relevan.</div>
            </div>
          </div>
        </a>
        <a href="/language-class" style="text-decoration:none; display:block;">
          <div class="volume-card">
            <div style="font-size: 40px; text-align: center; margin-top: 20px;">🌐</div>
            <div class="vol-body">
              <div class="vol-label">Course</div>
              <div class="vol-title">Language Class</div>
              <div class="vol-desc">Asah kemampuan multibahasamu bersama instruktur terverifikasi.</div>
            </div>
          </div>
        </a>
      </div>
      <div class="volume-arrows">
        <button id="svcPrev">←</button>
        <button id="svcNext">→</button>
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

  // ── SERVICES SLIDER ──
  const servicesSlider = document.getElementById('servicesSlider');
  if (servicesSlider) {
    document.getElementById('svcPrev').addEventListener('click', () => {
      servicesSlider.scrollBy({ left: -300, behavior: 'smooth' });
    });
    document.getElementById('svcNext').addEventListener('click', () => {
      servicesSlider.scrollBy({ left: 300, behavior: 'smooth' });
    });
  }

});
</script>
<?= $this->endSection() ?>
