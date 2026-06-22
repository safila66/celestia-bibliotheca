<?php
$services = [
    'book_delivery' => 'Book Delivery',
    'room_booking' => 'Booking Ruang Baca',
    'referensi' => 'Layanan Referensi',
    'sitasi' => 'Panduan Sitasi',
    'konsultasi' => 'Konsultasi Pustakawan',
    'mendeley_class' => 'Mendeley Class',
    'language_class' => 'Language Class'
];

$dir = 'C:\xampp\htdocs\celestia-bibliotheca\app\Views\user\services';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

foreach ($services as $file => $title) {
    $content = <<<HTML
<?= \$this->extend('layouts/template') ?>

<?= \$this->section('styles') ?>
<style>
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
.service-content {
    max-width: 800px; margin: 60px auto 100px;
    padding: 40px; background: rgba(4,6,15,0.4);
    border: 1px solid rgba(201,168,76,0.15);
    border-radius: 6px; text-align: center;
}
.service-content p {
    font-size: 16px; line-height: 1.8; color: var(--ivory);
    margin-bottom: 24px;
}
.back-btn {
    display: inline-block; padding: 10px 24px;
    border: 1px solid var(--gold); color: var(--gold);
    text-decoration: none; font-family: 'Cinzel', serif;
    transition: all 0.2s;
}
.back-btn:hover { background: var(--gold); color: var(--deep-navy); }

/* Light Mode Overrides */
[data-theme="light"] .service-header { background: #F8F5F0; }
[data-theme="light"] .service-title { color: #A8752A; }
[data-theme="light"] .service-content { background: #FFFFFF; border-color: rgba(0,0,0,0.1); }
[data-theme="light"] .service-content p { color: #2C2416; }
</style>
<?= \$this->endSection() ?>

<?= \$this->section('content') ?>
<section class="service-header">
    <h1 class="service-title"><?= esc(\$title) ?></h1>
</section>

<div class="service-content">
    <p>Layanan <strong><?= esc(\$title) ?></strong> saat ini sedang dalam tahap pengembangan dan akan segera hadir.</p>
    <a href="/dashboard" class="back-btn">Kembali ke Dashboard</a>
</div>
<?= \$this->endSection() ?>
HTML;

    file_put_contents("$dir/$file.php", $content);
}

echo "Created " . count($services) . " service views.";
