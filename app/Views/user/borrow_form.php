<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
  .borrow-container {
    padding: 120px 5% 80px;
    max-width: 900px;
    margin: 0 auto;
    color: var(--text);
  }
  .borrow-header {
    text-align: center;
    margin-bottom: 40px;
  }
  .borrow-header h1 {
    font-family: 'Cinzel', serif;
    color: var(--gold);
    font-size: 32px;
    margin-bottom: 10px;
  }
  
  .borrow-layout {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 40px;
  }
  
  /* Book Summary */
  .book-summary {
    background: rgba(4,6,15,0.4);
    border: 1px solid rgba(201,168,76,0.15);
    padding: 24px;
    border-radius: 8px;
    text-align: center;
    height: fit-content;
  }
  .book-summary img {
    width: 100%;
    aspect-ratio: 2/3;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 16px;
  }
  .book-summary h3 {
    font-family: 'Cinzel', serif;
    color: var(--ivory);
    font-size: 16px;
    margin-bottom: 8px;
  }
  .book-summary p { font-size: 13px; color: var(--gold-light); }

  /* Form */
  .borrow-form-box {
    background: var(--panel, rgba(30,35,45,0.4));
    border: 1px solid var(--border, rgba(255,255,255,0.1));
    border-radius: 8px;
    padding: 40px;
  }

  .form-group { margin-bottom: 24px; }
  .form-label {
    display: block;
    font-family: 'Raleway', sans-serif;
    font-size: 12px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 12px;
    font-weight: 700;
  }

  /* Radio Cards */
  .radio-group {
    display: flex; gap: 20px;
  }
  .radio-card {
    flex: 1;
    position: relative;
    cursor: pointer;
  }
  .radio-card input { display: none; }
  .radio-card-content {
    border: 2px solid rgba(201,168,76,0.2);
    border-radius: 6px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s;
    background: rgba(0,0,0,0.2);
  }
  .radio-card input:checked + .radio-card-content {
    border-color: var(--gold);
    background: rgba(201,168,76,0.1);
  }
  .radio-icon { font-size: 32px; margin-bottom: 12px; display: block; }
  .radio-title { font-family: 'Cinzel', serif; font-size: 16px; color: var(--ivory); font-weight: bold; }
  .radio-desc { font-size: 12px; color: var(--text-dim); margin-top: 8px; }

  /* Text Inputs */
  .form-input {
    width: 100%;
    padding: 14px 16px;
    background: rgba(0,0,0,0.2);
    border: 1px solid rgba(201,168,76,0.3);
    border-radius: 4px;
    color: var(--ivory);
    font-family: 'EB Garamond', serif;
    font-size: 15px;
    outline: none;
    transition: border 0.3s;
  }
  .form-input:focus { border-color: var(--gold); }
  .form-input:disabled { opacity: 0.5; cursor: not-allowed; }

  /* Submit Button */
  .submit-btn {
    width: 100%;
    padding: 16px;
    background: var(--gold);
    color: var(--deep-navy);
    border: none;
    border-radius: 4px;
    font-family: 'Raleway', sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s;
    margin-top: 20px;
  }
  .submit-btn:hover { background: var(--gold-light); transform: translateY(-2px); }

  /* Conditional Sections */
  #physicalOptions {
    display: none;
    margin-top: 24px;
    padding-top: 24px;
    border-top: 1px dashed rgba(201,168,76,0.3);
  }
  #addressSection {
    display: none;
    margin-top: 24px;
  }

  /* Light Mode */
  [data-theme="light"] .borrow-container { color: #333; }
  [data-theme="light"] .book-summary { background: #fff; border-color: rgba(0,0,0,0.1); }
  [data-theme="light"] .book-summary h3 { color: #2C2416; }
  [data-theme="light"] .borrow-form-box { background: #F8F5F0; border-color: rgba(0,0,0,0.1); }
  [data-theme="light"] .radio-card-content { background: #fff; border-color: rgba(0,0,0,0.1); }
  [data-theme="light"] .radio-title { color: #2C2416; }
  [data-theme="light"] .form-input { background: #fff; color: #333; border-color: rgba(168,117,42,0.4); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="borrow-container">
  
  <div class="borrow-header">
    <h1>Formulir Peminjaman</h1>
    <p>Silakan lengkapi preferensi peminjaman koleksi di bawah ini.</p>
  </div>

  <div class="borrow-layout">
    
    <!-- Left: Book Summary -->
    <div class="book-summary">
      <img src="/assets/covers/<?= esc($book['cover_image'] ?? 'default-cover.jpg') ?>" alt="Cover">
      <h3><?= esc($book['title']) ?></h3>
      <p><?= esc($book['author']) ?></p>
    </div>

    <!-- Right: Form -->
    <div class="borrow-form-box">
      <form action="/buku/<?= $book['id'] ?>/process-loan" method="post">
        
        <div class="form-group">
          <label class="form-label">Data Peminjam</label>
          <input type="text" class="form-input" value="<?= esc($user['name']) ?>" disabled style="margin-bottom:12px;">
          <input type="text" class="form-input" value="<?= esc($user['email']) ?>" disabled>
        </div>

        <div class="form-group">
          <label class="form-label">Format Koleksi</label>
          <div class="radio-group">
            <label class="radio-card">
              <input type="radio" name="format" value="ebook" id="formatEbook" checked onchange="toggleOptions()">
              <div class="radio-card-content">
                <span class="radio-icon">📱</span>
                <div class="radio-title">E-Book</div>
                <div class="radio-desc">Akses digital instan via aplikasi</div>
              </div>
            </label>
            <label class="radio-card">
              <input type="radio" name="format" value="physical" id="formatPhysical" onchange="toggleOptions()">
              <div class="radio-card-content">
                <span class="radio-icon">📚</span>
                <div class="radio-title">Buku Fisik</div>
                <div class="radio-desc">Buku cetak asli dari perpustakaan</div>
              </div>
            </label>
          </div>
        </div>

        <div id="physicalOptions">
          <div class="form-group">
            <label class="form-label">Metode Pengambilan</label>
            <div class="radio-group">
              <label class="radio-card">
                <input type="radio" name="method" value="pickup" id="methodPickup" checked onchange="toggleAddress()">
                <div class="radio-card-content">
                  <span class="radio-icon">🏛️</span>
                  <div class="radio-title">Ambil di Perpustakaan</div>
                  <div class="radio-desc">Reservasi fisik 2x24 Jam</div>
                </div>
              </label>
              <label class="radio-card">
                <input type="radio" name="method" value="delivery" id="methodDelivery" onchange="toggleAddress()">
                <div class="radio-card-content">
                  <span class="radio-icon">🚚</span>
                  <div class="radio-title">Delivery</div>
                  <div class="radio-desc">Kirim langsung ke alamatmu</div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <div id="addressSection">
          <div class="form-group">
            <label class="form-label">Alamat Pengiriman Lengkap</label>
            <textarea name="address" class="form-input" rows="3" placeholder="Masukkan alamat pengiriman dengan lengkap (Sertakan Kodepos)..."></textarea>
          </div>
        </div>

        <button type="submit" class="submit-btn">Konfirmasi Peminjaman</button>
      </form>
    </div>

  </div>
</div>

<?= $this->section('scripts') ?>
<script>
  function toggleOptions() {
    const isPhysical = document.getElementById('formatPhysical').checked;
    const physOptions = document.getElementById('physicalOptions');
    if (isPhysical) {
      physOptions.style.display = 'block';
    } else {
      physOptions.style.display = 'none';
      document.getElementById('methodPickup').checked = true; // reset
    }
    toggleAddress();
  }

  function toggleAddress() {
    const isPhysical = document.getElementById('formatPhysical').checked;
    const isDelivery = document.getElementById('methodDelivery').checked;
    const addrSection = document.getElementById('addressSection');
    
    if (isPhysical && isDelivery) {
      addrSection.style.display = 'block';
    } else {
      addrSection.style.display = 'none';
    }
  }

  // Init
  toggleOptions();
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
