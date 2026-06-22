<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<div style="max-width:800px;margin:60px auto;padding:40px;background:rgba(13,16,37,0.85);border:1px solid rgba(201,168,76,0.3);border-radius:12px;box-shadow:0 10px 40px rgba(0,0,0,0.5);text-align:center;">
    <div style="font-size:40px;margin-bottom:20px;">📖</div>
    <h1 style="color:var(--gold);font-family:'Cinzel',serif;margin-bottom:10px;">Welcome to <?= esc($room['title']) ?></h1>
    <p style="color:#e2e8f0;margin-bottom:40px;font-size:16px;">Anda telah berhasil terdaftar dalam sesi Reading Room ini.</p>

    <div style="background:#131a26;padding:30px;border-radius:8px;border:1px solid rgba(201,168,76,0.2);margin-bottom:40px;">
        <h3 style="color:var(--gold);margin-bottom:15px;">Akses Ruangan</h3>
        <p style="color:#aaa;margin-bottom:25px;">Klik tombol di bawah ini untuk bergabung ke dalam panggilan video (Zoom/GMeet) bersama partisipan lainnya.</p>
        
        <?php if(!empty($room['zoom_link'])): ?>
            <a href="<?= esc($room['zoom_link']) ?>" target="_blank" style="background:#40a060;color:#fff;padding:15px 35px;font-size:18px;font-weight:bold;text-decoration:none;border-radius:8px;display:inline-block;box-shadow:0 4px 15px rgba(64,160,96,0.4);">Mulai Bergabung (Video Call)</a>
        <?php else: ?>
            <span style="color:#c09040;font-style:italic;">Tautan ruangan belum tersedia. Silakan cek kembali mendekati waktu jadwal.</span>
        <?php endif; ?>
    </div>

    <a href="/reading-rooms" style="color:var(--gold);text-decoration:none;font-weight:bold;">&larr; Kembali ke Daftar Ruangan</a>
</div>
<?= $this->endSection() ?>
