<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 70vh; text-align: center;">
    <div style="font-size: 80px; color: var(--gold); margin-bottom: 20px;">
        🚧
    </div>
    <h2 style="font-family: 'Cinzel', serif; color: var(--gold); font-size: 32px; font-weight: bold; margin-bottom: 15px;">
        Modul Sedang Dalam Pengembangan
    </h2>
    <p style="color: var(--moon-silver); font-size: 16px; max-width: 500px; line-height: 1.6;">
        Fitur <?= esc($title ?? 'ini') ?> saat ini sedang dikembangkan oleh tim Bibliotheca Stellarum. Silakan kembali lagi nanti untuk melihat pembaruannya.
    </p>
    <a href="<?= base_url('admin/dashboard') ?>" style="margin-top: 30px; padding: 10px 20px; background: var(--gold); color: #04060f; border-radius: 4px; text-decoration: none; font-weight: bold;">
        Kembali ke Beranda
    </a>
</div>

<?= $this->endSection() ?>
