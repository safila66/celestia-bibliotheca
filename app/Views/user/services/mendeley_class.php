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
}

/* Main Container */
.container {
    max-width: 1000px; margin: 40px auto 100px;
    padding: 0 20px;
}

/* Layout Grid */
.mendeley-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: start;
}
@media(max-width: 800px) {
    .mendeley-grid { grid-template-columns: 1fr; }
}

/* Info Card */
.info-card {
    background: var(--panel, rgba(30,35,45,0.4));
    border: 1px solid var(--gold); border-radius: 8px; padding: 30px;
}
.info-card h3 { color: var(--gold); margin-top: 0; font-family: 'Cinzel', serif; margin-bottom: 20px; border-bottom: 1px solid rgba(201,168,76,0.3); padding-bottom: 10px; }
.schedule-list { list-style: none; padding: 0; margin: 0; }
.schedule-list li { margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); }
.schedule-list li:last-child { border: none; margin-bottom: 0; padding-bottom: 0; }
.sch-day { font-weight: bold; font-size: 18px; color: var(--text); display: flex; justify-content: space-between; margin-bottom: 5px; }
.sch-badge { background: rgba(33,150,243,0.2); color: #2196f3; font-size: 12px; padding: 2px 8px; border-radius: 4px; }
.sch-badge.online { background: rgba(76,175,80,0.2); color: #4caf50; }
.sch-time { color: var(--text-dim); font-size: 14px; }

/* Form Card */
.form-card {
    background: rgba(0,0,0,0.2); border: 1px dashed rgba(255,255,255,0.2); border-radius: 8px; padding: 30px;
}
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-size: 14px; color: var(--text-dim); }
.form-group input, .form-group select { width: 100%; padding: 12px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: var(--text); font-family: inherit; }
.btn-submit { background: var(--gold); color: #1a1a2e; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; font-size: 16px; margin-top: 10px; transition: 0.2s; }
.btn-submit:hover { background: #dfc16d; }

/* Classes Table */
.class-table { width: 100%; border-collapse: collapse; margin-top: 40px; }
.class-table th, .class-table td { padding: 16px; text-align: left; border-bottom: 1px solid var(--border, rgba(255,255,255,0.1)); color: var(--text); }
.class-table th { background: rgba(201,168,76,0.1); color: var(--gold); font-weight: bold; }
.btn-action { background: rgba(255,255,255,0.1); color: var(--text); padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; border: 1px solid rgba(255,255,255,0.2); cursor: pointer; }
.btn-action.zoom { background: rgba(33,150,243,0.2); color: #2196f3; border-color: #2196f3; }
.btn-action.qr { background: rgba(201,168,76,0.2); color: var(--gold); border-color: var(--gold); }

/* QR Modal */
.modal-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.8); display: none; align-items: center; justify-content: center; z-index: 1000;
}
.modal-content {
    background: var(--deep-navy); padding: 30px; border-radius: 8px; width: 100%; max-width: 300px;
    border: 1px solid var(--gold); text-align: center; color: var(--text);
}
.qr-placeholder {
    width: 200px; height: 200px; background: #fff; margin: 20px auto; border-radius: 8px; display: flex; align-items: center; justify-content: center;
}

/* Light Mode Overrides */
[data-theme="light"] .service-header { background: #F8F5F0; }
[data-theme="light"] .service-title { color: #A8752A; }
[data-theme="light"] .service-subtitle { color: #555; }
[data-theme="light"] .info-card { background: #fff; }
[data-theme="light"] .info-card h3 { color: #A8752A; border-bottom-color: #eee; }
[data-theme="light"] .sch-day { color: #333; }
[data-theme="light"] .form-card { background: #fff; border-color: #ccc; }
[data-theme="light"] .form-group input, [data-theme="light"] .form-group select { background: #fafafa; border-color: #ccc; color: #333; }
[data-theme="light"] .class-table th { background: #f0f0f0; color: #333; }
[data-theme="light"] .class-table td { border-bottom-color: #eee; color: #333; }
[data-theme="light"] .modal-content { background: #fff; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="service-header">
    <h1 class="service-title"><?= esc($title) ?></h1>
    <p class="service-subtitle">Kuasai manajemen referensi dan sitasi. Pilih jadwal yang sesuai untuk Anda.</p>
</section>

<div class="container">
    <div class="mendeley-grid">
        <!-- Info Timetable -->
        <div class="info-card">
            <h3>Jadwal Kelas Mingguan</h3>
            <ul class="schedule-list">
                <li>
                    <div class="sch-day">Senin & Rabu <span class="sch-badge">Tatap Muka</span></div>
                    <div class="sch-time">📍 Ruang Audio Visual, Lt. 2<br>Sesi Pagi: 09:00 - 12:00<br>Sesi Sore: 16:00 - 18:00</div>
                </li>
                <li>
                    <div class="sch-day">Jumat <span class="sch-badge online">Zoom Online</span></div>
                    <div class="sch-time">🌐 Link akan diberikan setelah mendaftar.<br>Sesi Pagi: 09:00 - 12:00<br>Sesi Sore: 16:00 - 18:00</div>
                </li>
            </ul>
        </div>

        <!-- Registration Form -->
        <div class="form-card">
            <h3 style="color: var(--gold); margin-top: 0; margin-bottom: 20px;">Formulir Pendaftaran</h3>
            <form action="/mendeley-class/register" method="POST">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label>Pilih Tanggal (Senin / Rabu / Jumat)</label>
                    <input type="date" name="schedule_date" required min="<?= date('Y-m-d') ?>">
                </div>
                <div class="form-group">
                    <label>Pilih Sesi</label>
                    <select name="session" required>
                        <option value="">-- Pilih Sesi --</option>
                        <option value="Pagi">Sesi Pagi (09:00 - 12:00)</option>
                        <option value="Sore">Sesi Sore (16:00 - 18:00)</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit">Daftar Sekarang</button>
            </form>
        </div>
    </div>

    <!-- My Classes Table -->
    <div style="margin-top: 60px;">
        <h3 style="font-family: 'Cinzel', serif; font-size: 24px; color: var(--gold);">Kelas Saya</h3>
        <?php if(empty($myClasses)): ?>
            <p style="color: var(--text-dim);">Anda belum mendaftar kelas Mendeley mana pun.</p>
        <?php else: ?>
            <table class="class-table">
                <thead>
                    <tr>
                        <th>Tanggal Kelas</th>
                        <th>Sesi</th>
                        <th>Format</th>
                        <th>Akses / Link</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($myClasses as $cls): ?>
                    <tr>
                        <td style="font-weight: bold;"><?= esc($cls['schedule_date']) ?></td>
                        <td><?= esc($cls['session']) ?></td>
                        <td>
                            <?php if($cls['format'] == 'Online'): ?>
                                <span class="sch-badge online">Online</span>
                            <?php else: ?>
                                <span class="sch-badge">Offline</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($cls['format'] == 'Online'): ?>
                                <a href="<?= esc($cls['zoom_link']) ?>" target="_blank" class="btn-action zoom">Join Zoom</a>
                                <div style="font-size: 11px; margin-top: 4px; color: var(--text-dim);">Pass: <?= esc($cls['zoom_passcode']) ?></div>
                            <?php else: ?>
                                <?php if($cls['status'] === 'Attended'): ?>
                                    <span class="sch-badge" style="background: rgba(76,175,80,0.2); color: #4caf50;">Check-In Berhasil</span>
                                <?php else: ?>
                                    <button class="btn-action qr" onclick="showQR('<?= esc($cls['qr_code']) ?>', <?= $cls['id'] ?>)">Lihat QR Code</button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- QR Modal -->
<div class="modal-overlay" id="qrModal" onclick="closeQR(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <h3 style="margin-top: 0; color: var(--gold); font-family: 'Cinzel', serif;">Akses Ruangan</h3>
        <p style="font-size: 14px; color: var(--text-dim);">Scan QR ini di pintu masuk Ruang Audio Visual.</p>
        <div class="qr-placeholder">
            <img src="" id="qrImage">
        </div>
        <div style="font-weight: bold; font-family: monospace; font-size: 18px;" id="qrText"></div>
        <p id="qrStatusText" style="font-size: 12px; color: #ff9800; font-weight:bold; margin-top: 10px;">Menunggu Check-In...</p>
        <button onclick="closeQR()" style="margin-top: 20px; background: transparent; border: 1px solid var(--text-dim); color: var(--text); padding: 8px 16px; border-radius: 4px; cursor: pointer;">Tutup</button>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let qrPollInterval;

function showQR(qrCodeStr, classId) {
    document.getElementById('qrModal').style.display = 'flex';
    document.getElementById('qrText').innerText = qrCodeStr;
    const scanUrl = '<?= base_url('scan/mendeley/') ?>' + classId;
    document.getElementById('qrImage').src = `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${encodeURIComponent(scanUrl)}`;
    
    document.getElementById('qrStatusText').innerText = "Menunggu Check-In...";
    document.getElementById('qrStatusText').style.color = "#ff9800";
    
    qrPollInterval = setInterval(() => {
        fetch('<?= base_url('api/check-mendeley/') ?>' + classId)
        .then(r => r.json())
        .then(data => {
            if (data.status === 'Attended') {
                clearInterval(qrPollInterval);
                document.getElementById('qrStatusText').innerText = "Check-In Berhasil! Memuat ulang...";
                document.getElementById('qrStatusText').style.color = "#4caf50";
                setTimeout(() => location.reload(), 1500);
            }
        });
    }, 3000);
}
function closeQR(e) {
    document.getElementById('qrModal').style.display = 'none';
    if(qrPollInterval) clearInterval(qrPollInterval);
}
</script>
<?= $this->endSection() ?>
