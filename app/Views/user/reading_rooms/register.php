<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<div style="max-width:600px;margin:60px auto;padding:40px;background:rgba(13,16,37,0.85);border:1px solid rgba(201,168,76,0.3);border-radius:12px;box-shadow:0 10px 40px rgba(0,0,0,0.5);">
    <h1 style="color:var(--gold);font-family:'Cinzel',serif;margin-bottom:10px;text-align:center;">Join Reading Room</h1>
    <p style="color:white;text-align:center;font-size:18px;margin-bottom:30px;"><?= esc($room['title']) ?></p>
    
    <div style="background:rgba(201,168,76,0.1);padding:15px;border-radius:8px;margin-bottom:30px;color:#e2e8f0;font-size:14px;line-height:1.6;">
        <strong>Deskripsi:</strong><br>
        <?= esc($room['description']) ?><br><br>
        <strong>Jadwal:</strong> <?= esc($room['schedule_time']) ?>
    </div>

    <form action="/reading-rooms/join/<?= $room['id'] ?>" method="post">
        <?= csrf_field() ?>
        <div style="margin-bottom:20px;">
            <label style="color:var(--gold-dim);display:block;margin-bottom:8px;font-weight:bold;">Alasan Bergabung / Pesan (Opsional):</label>
            <textarea name="join_reason" rows="4" style="width:100%;padding:12px;background:#131a26;border:1px solid rgba(201,168,76,0.5);color:white;border-radius:6px;font-family:'EB Garamond',serif;font-size:16px;" placeholder="Ceritakan ketertarikan Anda pada buku atau tema ini..."></textarea>
        </div>
        
        <div style="text-align:center;margin-top:30px;">
            <a href="/reading-rooms" style="color:var(--gold);text-decoration:none;margin-right:20px;">Batal</a>
            <button type="submit" style="background:var(--gold);color:#000;padding:12px 30px;font-size:16px;font-weight:bold;border:none;border-radius:6px;cursor:pointer;">Konfirmasi Pendaftaran</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
