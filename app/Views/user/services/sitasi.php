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

/* Upload Section */
.upload-card {
    background: var(--panel, rgba(30,35,45,0.4));
    border: 1px dashed var(--gold); border-radius: 12px; padding: 40px; margin-bottom: 40px;
    text-align: center; transition: 0.2s;
}
.upload-card:hover { background: rgba(30,35,45,0.6); }
.upload-icon { font-size: 48px; margin-bottom: 15px; }
.form-group { margin-bottom: 20px; text-align: left; max-width: 500px; margin-left: auto; margin-right: auto; }
.form-group label { display: block; margin-bottom: 8px; font-size: 14px; color: var(--text-dim); }
.form-group input[type="text"], .form-group input[type="file"] {
    width: 100%; padding: 12px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.2);
    background: rgba(0,0,0,0.2); color: var(--text); font-family: inherit;
}
.btn-submit { background: var(--gold); color: #1a1a2e; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 16px; margin-top: 20px; transition: 0.2s; }
.btn-submit:hover { background: #dfc16d; }

/* Status Table */
.status-title { font-family: 'Cinzel', serif; font-size: 24px; color: var(--gold); margin-bottom: 20px; border-bottom: 1px solid rgba(201,168,76,0.2); padding-bottom: 10px; }
.booking-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.booking-table th, .booking-table td { padding: 16px; text-align: left; border-bottom: 1px solid var(--border, rgba(255,255,255,0.1)); color: var(--text); }
.booking-table th { background: rgba(201,168,76,0.1); color: var(--gold); font-weight: bold; }

/* Badges & Progress */
.status-badge { padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; }
.status-Checking { background: rgba(255,152,0,0.2); color: #ff9800; }
.status-Approved { background: rgba(76,175,80,0.2); color: #4caf50; }
.status-Rejected { background: rgba(244,67,54,0.2); color: #f44336; }

.ai-bar-container { width: 100px; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden; display: inline-block; vertical-align: middle; margin-right: 10px; }
.ai-bar { height: 100%; }

/* Light Mode Overrides */
[data-theme="light"] .service-header { background: #F8F5F0; }
[data-theme="light"] .service-title { color: #A8752A; }
[data-theme="light"] .service-subtitle { color: #555; }
[data-theme="light"] .upload-card { background: #fff; border-color: #A8752A; }
[data-theme="light"] .form-group input { background: #fafafa; border-color: #ccc; color: #333; }
[data-theme="light"] .booking-table th { background: #f0f0f0; color: #333; }
[data-theme="light"] .booking-table td { border-bottom-color: #eee; color: #333; }
[data-theme="light"] .ai-bar-container { background: #e0e0e0; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="service-header">
    <h1 class="service-title"><?= esc($title) ?></h1>
    <p class="service-subtitle">Dapatkan verifikasi sitasi dari pustakawan dan pengecekan tingkat kontribusi AI pada karya Anda.</p>
</section>

<div class="container" style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px; align-items: start;">
    
    <!-- LEFT CONTENT: UPLOAD FORM -->
    <div class="upload-card">
        <div class="upload-icon">📄</div>
        <h3 style="color: var(--gold); margin-bottom: 20px;">Upload Karya untuk Pengecekan</h3>
        <form action="/sitasi/check" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Judul Karya / Dokumen</label>
                <input type="text" name="title" required placeholder="Contoh: Makalah Sejarah Nusantara">
            </div>
            <div class="form-group">
                <label>File Dokumen (PDF/Word)</label>
                <input type="file" name="document" required accept=".pdf,.doc,.docx">
            </div>
            <button type="submit" class="btn-submit">Mulai Pengecekan</button>
        </form>
    </div>

    <!-- RIGHT SIDEBAR: AI CHECKER RESULTS -->
    <div style="background: rgba(4, 6, 15, 0.4); border: 1px solid rgba(201,168,76,0.2); border-radius: 8px; padding: 20px;">
        <div class="status-title" style="font-size: 16px; margin-bottom: 20px;">Riwayat AI Checker & Sitasi</div>
        <?php if(empty($myChecks)): ?>
            <p style="text-align: center; color: var(--text-dim); padding: 20px;">Belum ada dokumen yang diajukan.</p>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <?php foreach($myChecks as $check): ?>
                <div style="padding: 15px; border: 1px solid rgba(255,255,255,0.05); border-radius: 6px; background: rgba(0,0,0,0.2);">
                    <div style="font-weight: bold; margin-bottom: 5px; color: var(--gold); font-size: 14px;"><?= esc($check['title']) ?></div>
                    <div style="font-size: 12px; color: var(--text-dim); margin-bottom: 10px;"><?= esc(date('d M Y, H:i', strtotime($check['created_at']))) ?></div>
                    
                    <div style="font-size: 12px; margin-bottom: 8px;">
                        Status: <span class="status-badge status-<?= esc($check['status']) ?>" style="font-size: 11px; padding: 2px 6px;">
                            <?= $check['status'] == 'Checking' ? '⏳ Diperiksa' : esc($check['status']) ?>
                        </span>
                    </div>

                    <?php 
                        $pct = $check['ai_percentage'] ?? 0; 
                        $color = '#4caf50'; // green if low
                        if($pct > 20) $color = '#ff9800'; // orange if medium
                        if($pct > 40) $color = '#f44336'; // red if high
                    ?>
                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12px;">
                        <span>AI Score:</span>
                        <span style="font-weight: bold; color: <?= $color ?>;"><?= $pct ?>%</span>
                    </div>
                    <div class="ai-bar-container" style="width: 100%; margin-top: 5px;">
                        <div class="ai-bar" style="width: <?= $pct ?>%; background: <?= $color ?>;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
