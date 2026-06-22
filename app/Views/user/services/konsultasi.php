<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
/* Header Styles */
.service-header {
    background: linear-gradient(180deg, var(--deep-navy) 0%, #0d1025 100%);
    padding: 120px 20px 60px;
    text-align: center;
    border-bottom: 1px solid rgba(201,168,76,0.15);
}
.service-title {
    font-family: 'Cinzel', serif; font-size: 36px;
    color: var(--gold); letter-spacing: 0.08em;
    margin-bottom: 16px;
}
.service-subtitle {
    color: var(--ivory); opacity: 0.8; font-size: 16px;
    max-width: 800px; margin: 0 auto; line-height: 1.6;
}

/* Tabs */
.tabs { display: flex; gap: 24px; margin-bottom: 30px; border-bottom: 1px solid rgba(201,168,76,0.2); }
.tab { padding: 12px 0; cursor: pointer; color: var(--text-dim); font-weight: 600; border-bottom: 2px solid transparent; transition: all 0.3s; }
.tab.active { color: var(--gold); border-bottom-color: var(--gold); }
.tab:hover:not(.active) { color: var(--text); }

/* Main Container */
.container {
    max-width: 1000px; margin: 40px auto 100px;
    padding: 0 20px;
}

/* Grid & Cards */
.grid-layout {
    display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: start;
}
@media(max-width: 800px) {
    .grid-layout { grid-template-columns: 1fr; }
}

.info-card, .form-card {
    background: var(--panel, rgba(30,35,45,0.4));
    border: 1px solid var(--border, rgba(255,255,255,0.1));
    border-radius: 12px; padding: 30px;
}
.info-card h3, .form-card h3 {
    font-family: 'Cinzel', serif; font-size: 24px; color: var(--gold); margin-top: 0; margin-bottom: 20px;
}

/* Form Styles */
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-size: 14px; color: var(--text-dim); font-weight: 600; }
.form-control {
    width: 100%; padding: 12px; border-radius: 6px;
    border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2);
    color: var(--text); font-family: inherit;
}
.btn-submit {
    background: var(--gold); color: #1a1a2e; padding: 12px 24px; border: none; border-radius: 6px;
    cursor: pointer; font-weight: bold; width: 100%; font-size: 16px; margin-top: 10px; transition: 0.3s;
}
.btn-submit:hover { background: #dfc16d; transform: translateY(-2px); }

/* Booking Table */
.booking-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.booking-table th, .booking-table td { padding: 16px; text-align: left; border-bottom: 1px solid var(--border, rgba(255,255,255,0.1)); color: var(--text); }
.booking-table th { background: rgba(201,168,76,0.1); color: var(--gold); font-weight: bold; }
.status-badge { padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block; }
.status-Pending { background: rgba(255,152,0,0.2); color: #ff9800; }
.status-Confirmed { background: rgba(33,150,243,0.2); color: #2196f3; }
.status-Completed { background: rgba(76,175,80,0.2); color: #4caf50; }

/* Light Mode Overrides */
[data-theme="light"] .service-header { background: #F8F5F0; }
[data-theme="light"] .service-title { color: #A8752A; }
[data-theme="light"] .service-subtitle { color: #555; }
[data-theme="light"] .info-card, [data-theme="light"] .form-card { background: #fff; border-color: #ddd; }
[data-theme="light"] .form-control { background: #fafafa; border-color: #ccc; color: #333; }
[data-theme="light"] .booking-table th { background: #f0f0f0; color: #333; }
[data-theme="light"] .booking-table td { border-bottom-color: #eee; color: #333; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="service-header">
    <h1 class="service-title">Konsultasi Pustakawan (Umum)</h1>
    <p class="service-subtitle">Layanan bimbingan awal dan konsultasi pustaka untuk segala jenis karya. Layaknya dokter umum, kami siap membantu mengarahkan Anda ke sumber referensi yang tepat.</p>
</section>

<div class="container">
    <div class="tabs">
        <div class="tab active" onclick="switchTab('booking', event)">Jadwalkan Konsultasi</div>
        <div class="tab" onclick="switchTab('history', event)">Riwayat Saya</div>
    </div>

    <div id="section-booking">
        <div class="grid-layout">
            <!-- Info -->
            <div class="info-card">
                <h3>Apa itu Konsultasi Umum?</h3>
                <p style="color: var(--text-dim); line-height: 1.8; margin-bottom: 20px;">
                    Layanan ini cocok untuk Anda yang baru memulai riset atau bingung mencari arah literatur yang tepat. Pustakawan kami akan membantu:
                </p>
                <ul style="color: var(--text-dim); line-height: 1.8; padding-left: 20px; margin-bottom: 30px;">
                    <li>Strategi penelusuran informasi dasar.</li>
                    <li>Identifikasi database jurnal yang sesuai topik.</li>
                    <li>Penyusunan kerangka literatur.</li>
                </ul>
                <div style="padding: 15px; background: rgba(33,150,243,0.1); border-left: 4px solid #2196f3; color: var(--text); font-size: 14px; border-radius: 0 8px 8px 0;">
                    <strong>Catatan:</strong> Jika Anda membutuhkan analisis mendalam terkait topik yang spesifik, kami sarankan menggunakan <a href="<?= base_url('referensi') ?>" style="color: #2196f3; text-decoration: underline;">Layanan Referensi (Pustakawan Spesialis)</a>.
                </div>
            </div>

            <!-- Booking Form -->
            <div class="form-card">
                <h3>Form Jadwal Konsultasi</h3>
                <form action="<?= base_url('konsultasi/book') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label>Topik Riset / Pertanyaan Utama</label>
                        <input type="text" name="topic" class="form-control" required placeholder="Contoh: Pencarian literatur sejarah pra-kemerdekaan">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="consultation_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="form-group">
                            <label>Waktu</label>
                            <input type="time" name="consultation_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Sebutkan secara singkat apa yang ingin dicapai..."></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Ajukan Jadwal</button>
                </form>
            </div>
        </div>
    </div>

    <!-- My Consultations -->
    <div id="section-history" style="display: none;">
        <?php if(empty($myConsultations)): ?>
            <div style="text-align: center; padding: 60px; color: var(--text-dim);">
                <div style="font-size: 48px; margin-bottom: 20px; opacity: 0.8;">💬</div>
                <p>Anda belum memiliki riwayat pengajuan konsultasi umum.</p>
            </div>
        <?php else: ?>
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Tanggal & Waktu</th>
                        <th>Topik / Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($myConsultations as $c): ?>
                    <tr>
                        <td style="font-weight: bold;"><?= esc($c['consultation_date']) ?> <br><span style="font-weight: normal; color: var(--text-dim); font-size: 13px;"><?= esc($c['consultation_time']) ?></span></td>
                        <td>
                            <div style="font-weight: bold; color: var(--gold);"><?= esc($c['topic']) ?></div>
                            <div style="font-size: 13px; color: var(--text-dim); margin-top: 4px;"><?= esc($c['notes']) ?></div>
                        </td>
                        <td>
                            <span class="status-badge status-<?= esc($c['status']) ?>"><?= esc($c['status']) ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script>
function switchTab(tab, event) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    event.target.classList.add('active');
    
    document.getElementById('section-booking').style.display = tab === 'booking' ? 'block' : 'none';
    document.getElementById('section-history').style.display = tab === 'history' ? 'block' : 'none';
}
</script>
<?= $this->endSection() ?>
