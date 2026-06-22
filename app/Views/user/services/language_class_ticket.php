<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
.ticket-bg {
    background: #0f172a; min-height: 100vh; padding: 100px 20px 50px;
    display: flex; justify-content: center; align-items: flex-start;
}
.ticket-card {
    background: #fff; width: 100%; max-width: 400px; border-radius: 16px; overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.5); position: relative;
}
.ticket-header {
    background: #1e293b; color: #fff; padding: 30px 20px; text-align: center;
    position: relative;
}
/* The jagged edge between header and body to look like a ticket */
.ticket-header::after {
    content: ''; position: absolute; bottom: -10px; left: 0; right: 0; height: 20px;
    background-image: radial-gradient(circle at 10px 0px, transparent 12px, #fff 13px);
    background-size: 20px 20px; background-position: -10px -10px;
}
.ticket-title { font-size: 24px; font-weight: bold; margin-bottom: 5px; color: var(--gold); }
.ticket-subtitle { font-size: 14px; color: #cbd5e1; }

.ticket-body {
    padding: 40px 30px 30px; color: #333; text-align: center;
}
.detail-row { display: flex; justify-content: space-between; margin-bottom: 20px; text-align: left;}
.detail-label { font-size: 12px; color: #888; text-transform: uppercase; margin-bottom: 4px; }
.detail-value { font-size: 16px; font-weight: bold; color: #111827; }

.qr-box {
    margin: 30px auto 0; padding: 20px; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px;
    display: inline-block;
}
.qr-code-img {
    width: 150px; height: 150px; background: url('https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= urlencode(base_url('scan/language/' . $ticket['id'])) ?>') no-repeat center; background-size: contain;
}
.qr-hash {
    margin-top: 10px; font-family: monospace; font-size: 14px; color: #64748b; letter-spacing: 2px;
}

.ticket-footer {
    padding: 20px; background: #f8fafc; text-align: center; border-top: 1px dashed #cbd5e1;
}
.btn-home {
    background: var(--deep-navy); color: var(--gold); padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="ticket-bg">
    <div class="ticket-card">
        <div class="ticket-header">
            <div style="font-size: 12px; letter-spacing: 2px; margin-bottom: 10px; color: #94a3b8;">E-TICKET KELAS BAHASA</div>
            <div class="ticket-title">Bahasa <?= esc($ticket['language']) ?></div>
            <div class="ticket-subtitle">Reguler Class</div>
        </div>
        <div class="ticket-body">
            
            <?php if(session()->getFlashdata('success')): ?>
                <div style="color: #10b981; font-weight: bold; margin-bottom: 20px; font-size: 14px;">
                    ✅ <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="detail-row">
                <div>
                    <div class="detail-label">Tanggal</div>
                    <div class="detail-value"><?= date('d M Y', strtotime($ticket['schedule_date'])) ?></div>
                </div>
                <div style="text-align: right;">
                    <div class="detail-label">Jam</div>
                    <div class="detail-value"><?= esc($ticket['session_time']) ?></div>
                </div>
            </div>
            
            <div class="detail-row">
                <div>
                    <div class="detail-label">Ruangan (Cinema)</div>
                    <div class="detail-value"><?= esc($ticket['room']) ?></div>
                </div>
                <div style="text-align: right;">
                    <div class="detail-label">Kursi</div>
                    <div class="detail-value" style="font-size: 24px; color: var(--gold);"><?= esc($ticket['seat_number']) ?></div>
                </div>
            </div>

            <div class="qr-box">
                <?php if($ticket['status'] === 'Attended'): ?>
                    <div style="font-size: 64px; margin-bottom: 10px;">✅</div>
                    <div style="color: #4caf50; font-weight: bold; font-size: 18px;">Check-In Berhasil</div>
                <?php else: ?>
                    <div class="qr-code-img"></div>
                    <div class="qr-hash"><?= esc($ticket['qr_code']) ?></div>
                <?php endif; ?>
            </div>
            
            <?php if($ticket['status'] !== 'Attended'): ?>
            <p id="qrStatusText" style="font-size: 12px; color: #ff9800; font-weight:bold; margin-top: 20px;">Menunggu Check-In...</p>
            <p style="font-size: 12px; color: #888; margin-top: 10px;">
                Tunjukkan QR Code ini kepada petugas perpustakaan sebelum memasuki ruangan kelas.
            </p>
            <?php endif; ?>
        </div>
        <div class="ticket-footer">
            <a href="<?= base_url('language-class') ?>" class="btn-home">Kembali ke Katalog</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if($ticket['status'] !== 'Attended'): ?>
<script>
    let qrPollInterval = setInterval(() => {
        fetch('<?= base_url('api/check-language/') . $ticket['id'] ?>')
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
</script>
<?php endif; ?>
<?= $this->endSection() ?>
