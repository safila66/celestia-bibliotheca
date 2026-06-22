<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<div style="max-width:900px;margin:40px auto;padding:20px;">
    <h1 style="color:var(--gold);font-family:'Cinzel',serif;margin-bottom:10px;">Virtual Reading Rooms</h1>
    <p style="color:var(--text-dim);margin-bottom:40px;font-size:16px;">Bergabunglah dengan sesi baca bersama atau klub buku virtual kami di Bibliotheca Stellarum.</p>

    <div style="display:grid;gap:20px;">
    <?php if(empty($rooms)): ?>
        <p style="color:#aaa;font-style:italic;">Belum ada jadwal Reading Room saat ini.</p>
    <?php else: ?>
        <?php foreach($rooms as $r): ?>
            <div style="background:rgba(13,16,37,0.8);border:1px solid rgba(201,168,76,0.3);padding:25px;border-radius:12px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 10px 30px rgba(0,0,0,0.5);">
                <div>
                    <h3 style="color:white;font-family:'Cinzel',serif;margin-bottom:10px;font-size:22px;"><?= esc($r['title']) ?></h3>
                    <p style="color:#e2e8f0;font-size:15px;margin-bottom:15px;line-height:1.6;"><?= esc($r['description']) ?></p>
                    <span style="color:var(--gold);font-size:14px;font-weight:bold;background:rgba(201,168,76,0.1);padding:5px 10px;border-radius:4px;">🕒 Jadwal: <?= esc($r['schedule_time']) ?></span>
                </div>
                <a href="/reading-rooms/join/<?= $r['id'] ?>" style="background:var(--gold);color:#000;padding:12px 25px;border-radius:6px;font-weight:bold;text-decoration:none;transition:0.3s;white-space:nowrap;margin-left:20px;">Ikut Bergabung</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
