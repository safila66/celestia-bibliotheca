<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
  .track-container {
    padding: 120px 5% 80px;
    max-width: 1000px;
    margin: 0 auto;
    color: var(--text);
  }
  .track-header {
    text-align: center;
    margin-bottom: 40px;
  }
  .track-header h1 {
    font-family: 'Cinzel', serif;
    color: var(--gold);
    font-size: 32px;
    margin-bottom: 10px;
  }
  .track-resi {
    font-family: 'Raleway', sans-serif;
    font-size: 14px;
    letter-spacing: 0.15em;
    color: var(--ivory);
    background: rgba(201,168,76,0.15);
    padding: 8px 16px;
    border: 1px dashed var(--gold);
    display: inline-block;
    margin-top: 10px;
  }

  .track-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 30px;
  }

  /* Status Timeline */
  .status-panel {
    background: rgba(4,6,15,0.4);
    border: 1px solid rgba(201,168,76,0.15);
    padding: 30px;
    border-radius: 8px;
    height: fit-content;
  }
  .status-title {
    font-family: 'Cinzel', serif;
    font-size: 18px;
    color: var(--gold-light);
    margin-bottom: 24px;
  }
  
  .timeline {
    position: relative;
    padding-left: 24px;
    border-left: 2px solid rgba(201,168,76,0.2);
    display: flex;
    flex-direction: column;
    gap: 24px;
  }
  .time-item { position: relative; }
  .time-dot {
    position: absolute;
    left: -31px;
    top: 0;
    width: 14px; height: 14px;
    border-radius: 50%;
    background: var(--deep-navy);
    border: 2px solid rgba(201,168,76,0.5);
    transition: all 0.3s;
  }
  .time-item.active .time-dot {
    border-color: var(--gold);
    background: var(--gold);
    box-shadow: 0 0 10px var(--gold);
  }
  .time-label {
    font-family: 'Raleway', sans-serif;
    font-size: 11px;
    letter-spacing: 0.1em;
    color: var(--gold);
    text-transform: uppercase;
    margin-bottom: 4px;
  }
  .time-desc { font-size: 14px; color: var(--ivory); }
  .time-date { font-size: 11px; color: var(--text-dim); margin-top: 4px; font-style: italic; }

  /* Map Panel */
  .map-panel {
    background: var(--panel, rgba(30,35,45,0.4));
    border: 1px solid var(--border, rgba(255,255,255,0.1));
    border-radius: 8px;
    padding: 10px;
  }
  #map {
    width: 100%;
    height: 500px;
    border-radius: 6px;
    background: #1a1a2e;
  }

  /* Map custom marker */
  .courier-marker {
    background: var(--gold);
    border: 2px solid #fff;
    border-radius: 50%;
    box-shadow: 0 0 10px rgba(0,0,0,0.5);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
  }

  /* Light Mode */
  [data-theme="light"] .track-container { color: #333; }
  [data-theme="light"] .status-panel { background: #fff; border-color: rgba(0,0,0,0.1); }
  [data-theme="light"] .time-desc { color: #2C2416; }
  [data-theme="light"] .map-panel { background: #fff; border-color: rgba(0,0,0,0.1); }
  [data-theme="light"] .track-resi { color: #A8752A; border-color: #A8752A; background: rgba(168,117,42,0.1); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="track-container">
  
  <div class="track-header">
    <h1>Live Tracking Delivery</h1>
    <p>Pantau perjalanan buku pinjamanmu secara *real-time*.</p>
    <div class="track-resi">RESI: <?= esc($trackingCode) ?></div>
  </div>

  <div class="track-layout">
    
    <!-- Timeline -->
    <div class="status-panel">
      <div class="status-title">Status Pengiriman</div>
      <div class="timeline">
        <div class="time-item">
          <div class="time-dot"></div>
          <div class="time-label">Terkonfirmasi</div>
          <div class="time-desc">Pesanan disetujui pustakawan.</div>
          <div class="time-date">Hari ini, 08:30</div>
        </div>
        <div class="time-item">
          <div class="time-dot"></div>
          <div class="time-label">Dikemas</div>
          <div class="time-desc">Buku sedang disiapkan untuk pengiriman.</div>
          <div class="time-date">Hari ini, 09:15</div>
        </div>
        <div class="time-item active" id="statusTransit">
          <div class="time-dot"></div>
          <div class="time-label">Dalam Perjalanan</div>
          <div class="time-desc">Kurir Celestia sedang menuju lokasimu.</div>
          <div class="time-date">Hari ini, <span id="currentTime">10:00</span></div>
        </div>
        <div class="time-item" id="statusDelivered">
          <div class="time-dot"></div>
          <div class="time-label">Terkirim</div>
          <div class="time-desc">Buku telah sampai di tujuan.</div>
          <div class="time-date">Menunggu...</div>
        </div>
      </div>
    </div>

    <!-- Map -->
    <div class="map-panel">
      <div id="map"></div>
    </div>

  </div>
</div>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  // Titik Awal (Perpustakaan) & Titik Akhir (Rumah User) - Anggap di Jakarta
  const libLat = -6.175392, libLng = 106.827153; // Monas Area
  const userLat = -6.221586, userLng = 106.822286; // Kuningan Area

  // Inisialisasi Peta
  const map = L.map('map').setView([ (libLat+userLat)/2, (libLng+userLng)/2 ], 13);

  // Layer Map OpenStreetMap (Gratis & Bebas API Key)
  L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; OpenStreetMap contributors &copy; CARTO'
  }).addTo(map);

  // Marker Perpustakaan & Rumah
  L.marker([libLat, libLng]).addTo(map).bindPopup("<b>Celestia Bibliotheca</b><br>Titik Asal").openPopup();
  L.marker([userLat, userLng]).addTo(map).bindPopup("<b>Rumahmu</b><br>Titik Tujuan");

  // Rute Garis (Simulasi sederhana tanpa routing API)
  // Kita buat polyline zigzag buatan
  const routePoints = [
    [libLat, libLng],
    [-6.1850, 106.8260],
    [-6.1980, 106.8240],
    [-6.2100, 106.8235],
    [userLat, userLng]
  ];

  const routeLine = L.polyline(routePoints, {color: '#C9A84C', weight: 4, dashArray: '8, 8'}).addTo(map);

  // Marker Kurir Bergerak
  const courierIcon = L.divIcon({
    className: 'courier-marker',
    html: '🚚',
    iconSize: [32, 32],
    iconAnchor: [16, 16]
  });
  const courierMarker = L.marker([libLat, libLng], {icon: courierIcon}).addTo(map);

  // Animasi Kurir
  let currentStep = 0;
  const totalSteps = 100;
  
  function animateCourier() {
    if (currentStep > totalSteps) {
      // Sampai
      document.getElementById('statusTransit').classList.remove('active');
      document.getElementById('statusDelivered').classList.add('active');
      document.getElementById('statusDelivered').querySelector('.time-date').innerText = "Baru Saja";
      courierMarker.bindPopup("<b>Paket Tiba!</b>").openPopup();
      return;
    }

    // Hitung posisi (Simulasi interpolasi sederhana antara point pertama dan terakhir untuk demo)
    // Di dunia nyata pakai routing sepanjang array point. Untuk demo UI:
    const progress = currentStep / totalSteps;
    const currentLat = libLat + (userLat - libLat) * progress;
    const currentLng = libLng + (userLng - libLng) * progress;

    courierMarker.setLatLng([currentLat, currentLng]);

    // Update time
    const d = new Date();
    document.getElementById('currentTime').innerText = d.getHours().toString().padStart(2,'0') + ":" + d.getMinutes().toString().padStart(2,'0');

    currentStep++;
    setTimeout(animateCourier, 100); // Bergerak tiap 100ms
  }

  // Mulai animasi
  setTimeout(animateCourier, 1000);

</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
