<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
.detail-header {
    padding: 100px 20px 40px;
    background: #0f172a;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}
.detail-container {
    max-width: 1000px; margin: 0 auto;
    display: flex; gap: 40px;
}
.poster-col {
    width: 250px; flex-shrink: 0;
}
.poster-img {
    width: 100%; aspect-ratio: 2/3; background: #3949AB; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 60px; color: rgba(255,255,255,0.5); font-weight: bold;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
}
.info-col {
    flex: 1; padding-top: 20px;
}
.movie-title { font-size: 36px; font-weight: bold; margin-bottom: 10px; color: #fff; }
.movie-meta { color: #94a3b8; font-size: 14px; margin-bottom: 20px; display: flex; gap: 15px; }
.meta-badge { border: 1px solid #94a3b8; padding: 2px 8px; border-radius: 4px; }

/* Date Slider */
.schedule-section {
    background: #fff;
    color: #333;
    min-height: 500px;
}
.date-slider {
    display: flex; overflow-x: auto; border-bottom: 1px solid #eee; padding: 0 20px;
    scrollbar-width: none; /* Firefox */
}
.date-slider::-webkit-scrollbar { display: none; }

.date-item {
    padding: 15px 20px;
    text-align: center;
    cursor: pointer;
    min-width: 80px;
    border-bottom: 3px solid transparent;
    transition: 0.2s;
    text-decoration: none;
    color: #666;
}
.date-item.active {
    color: #00897b; border-bottom-color: #00897b;
}
.date-day { font-size: 12px; text-transform: uppercase; margin-bottom: 5px; }
.date-num { font-size: 24px; font-weight: bold; }

/* Cinemas / Time Slots */
.cinemas-list {
    padding: 30px 20px; max-width: 1000px; margin: 0 auto;
}
.cinema-card {
    margin-bottom: 30px;
}
.cinema-name {
    font-size: 18px; font-weight: bold; display: flex; align-items: center; gap: 10px; margin-bottom: 15px;
    color: #333;
}
.cinema-info-icon {
    font-size: 12px; border: 1px solid #ccc; border-radius: 50%; width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center; color: #888;
}
.class-type { font-weight: bold; margin-bottom: 10px; color: #555; }
.times-grid {
    display: flex; gap: 15px; flex-wrap: wrap;
}
.time-btn {
    background: #e2e8f0; color: #475569; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; transition: 0.2s; border: none; cursor: pointer;
}
.time-btn:hover { background: #00897b; color: #fff; }

/* Light Mode Overrides handling */
[data-theme="dark"] .schedule-section { background: #1e293b; color: #fff; }
[data-theme="dark"] .date-slider { border-bottom-color: rgba(255,255,255,0.1); }
[data-theme="dark"] .date-item { color: #94a3b8; }
[data-theme="dark"] .date-item.active { color: #4ade80; border-bottom-color: #4ade80; }
[data-theme="dark"] .cinema-name { color: #fff; }
[data-theme="dark"] .class-type { color: #cbd5e1; }
[data-theme="dark"] .time-btn { background: #334155; color: #f8fafc; }
[data-theme="dark"] .time-btn:hover { background: #4ade80; color: #0f172a; }

</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// Ambil tanggal terpilih dari query string, atau gunakan tanggal pertama dari jadwal
$selectedDate = isset($_GET['date']) ? $_GET['date'] : (count($upcomingDates) > 0 ? $upcomingDates[0]['date'] : null);

// Cek apakah gambar spesifik ada (asumsi nama file misal: jepang.jpg)
$imgFile = 'assets/images/' . strtolower($lang) . '.jpg';
$bgImage = file_exists(FCPATH . $imgFile) ? "background-image: url('" . base_url($imgFile) . "'); background-size: cover; background-position: center;" : "background: #3949AB;";
?>

<section class="detail-header">
    <div class="detail-container">
        <div class="poster-col">
            <div class="poster-img" style="<?= $bgImage ?>">
                <?php if(!file_exists(FCPATH . $imgFile)): ?>
                <?= strtoupper(substr($lang, 0, 2)) ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="info-col">
            <h1 class="movie-title">Bahasa <?= esc($lang) ?></h1>
            <div class="movie-meta">
                <span class="meta-badge">REGULER</span>
                <span class="meta-badge">Beginner Friendly</span>
            </div>
            <p style="color: #cbd5e1; line-height: 1.6;">
                Tingkatkan kemampuan berbahasa <?= esc($lang) ?> Anda bersama instruktur berpengalaman. Kelas ini dirancang khusus untuk pemula hingga tingkat menengah dengan metode pembelajaran yang interaktif dan komprehensif.
            </p>
        </div>
    </div>
</section>

<section class="schedule-section">
    <!-- Date Slider -->
    <div style="background: rgba(0,0,0,0.02); box-shadow: inset 0 -1px 0 rgba(0,0,0,0.05);">
        <div class="date-slider">
            <div style="display:flex; max-width: 1000px; margin: 0 auto; width: 100%;">
                <?php foreach($upcomingDates as $d): ?>
                <a href="?date=<?= $d['date'] ?>" class="date-item <?= ($selectedDate === $d['date']) ? 'active' : '' ?>">
                    <div class="date-day"><?= $d['dayName'] ?></div>
                    <div class="date-num"><?= $d['dayNum'] ?></div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div style="max-width: 1000px; margin: 0 auto; padding: 20px 20px 0;">
        <div style="display: flex; gap: 30px; border-bottom: 1px solid rgba(128,128,128,0.3); padding-bottom: 10px;">
            <div id="tab-jadwal" onclick="switchTab('jadwal')" style="font-weight: bold; font-size: 18px; border-bottom: 3px solid #00897b; padding-bottom: 10px; margin-bottom: -11px; cursor: pointer; color: var(--gold);">Jadwal</div>
            <div id="tab-detail" onclick="switchTab('detail')" style="color: #888; font-size: 18px; cursor: pointer; padding-bottom: 10px; margin-bottom: -11px; border-bottom: 3px solid transparent;">Detail</div>
        </div>
    </div>

    <!-- Detail Content -->
    <div id="content-detail" style="display: none; padding: 30px 20px; max-width: 1000px; margin: 0 auto; color: #cbd5e1; line-height: 1.6;">
        <h3 style="color: var(--gold); margin-top: 0;">Tentang Kelas Ini</h3>
        <p>Kelas Bahasa <?= esc($lang) ?> dirancang untuk membekali Anda dengan keterampilan praktis dalam percakapan, membaca, dan menulis. Program ini dipandu oleh instruktur berpengalaman yang berfokus pada metode interaktif dan pemahaman budaya.</p>
        <br>
        <h3 style="color: var(--gold);">Syarat & Ketentuan</h3>
        <ul style="padding-left: 20px; margin-top: 10px;">
            <li>Beginner only, advance class masih dalam tahap pengembangan</li>
            <li>Harap hadir 15 menit sebelum kelas dimulai untuk registrasi ulang dengan QR Code.</li>
            <li>Kursi yang sudah dipesan tidak dapat dibatalkan atau dialihkan tanpa konfirmasi admin.</li>
        </ul>
    </div>

    <!-- Jadwal Content -->
    <div id="content-jadwal">
        <!-- Cinemas (Locations/Rooms) -->
        <div class="cinemas-list">
            <?php if(!$selectedDate): ?>
                <div style="padding: 50px; text-align: center; color: #888;">
                    <p>Jadwal tidak tersedia untuk beberapa hari ke depan.</p>
                </div>
            <?php else: ?>
                <div class="cinema-card">
                    <div class="cinema-name">
                        <?= esc($schedule['room']) ?> <span class="cinema-info-icon">i</span>
                    </div>
                    <div class="class-type">Reguler Class</div>
                    <div class="times-grid">
                        <!-- The time slot buttons -->
                        <a href="<?= base_url('language-class/seats?lang=' . urlencode($lang) . '&date=' . $selectedDate . '&time=' . urlencode($schedule['time'])) ?>" class="time-btn">
                            <?= esc($schedule['time']) ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
function switchTab(tab) {
    if (tab === 'jadwal') {
        document.getElementById('content-jadwal').style.display = 'block';
        document.getElementById('content-detail').style.display = 'none';
        
        document.getElementById('tab-jadwal').style.color = 'var(--gold)';
        document.getElementById('tab-jadwal').style.borderColor = '#00897b';
        document.getElementById('tab-detail').style.color = '#888';
        document.getElementById('tab-detail').style.borderColor = 'transparent';
    } else {
        document.getElementById('content-jadwal').style.display = 'none';
        document.getElementById('content-detail').style.display = 'block';
        
        document.getElementById('tab-detail').style.color = 'var(--gold)';
        document.getElementById('tab-detail').style.borderColor = '#00897b';
        document.getElementById('tab-jadwal').style.color = '#888';
        document.getElementById('tab-jadwal').style.borderColor = 'transparent';
    }
}
</script>

<?= $this->endSection() ?>
