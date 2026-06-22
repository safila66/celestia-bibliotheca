<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
.cinema-header {
    background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
    padding: 100px 20px 40px;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}
.cinema-title {
    font-size: 32px; color: #fff; font-weight: bold; margin-bottom: 10px;
}
.cinema-subtitle {
    color: #94a3b8; font-size: 16px;
}

.movies-container {
    max-width: 1200px; margin: 40px auto 100px; padding: 0 20px;
}
.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 30px;
}
.movie-card {
    background: #1e293b;
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    color: #fff;
    transition: transform 0.3s, box-shadow 0.3s;
    display: flex;
    flex-direction: column;
}
.movie-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
}
.movie-poster {
    width: 100%;
    aspect-ratio: 2/3;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.movie-poster-placeholder {
    font-size: 60px;
    font-weight: bold;
    color: rgba(255,255,255,0.5);
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
}
.movie-info {
    padding: 15px;
    flex: 1;
}
.movie-title {
    font-size: 16px; font-weight: bold; margin-bottom: 5px;
}
.movie-category {
    font-size: 12px; color: #94a3b8; display: inline-block; padding: 4px 8px; border-radius: 4px; background: rgba(255,255,255,0.1);
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="cinema-header">
    <h1 class="cinema-title">Sedang Tayang: Language Class</h1>
    <p class="cinema-subtitle">Pilih kelas bahasa favorit Anda dan pesan kursi sekarang juga.</p>
</section>

<div class="movies-container">
    <?php if(session()->getFlashdata('success')): ?>
        <div style="background: rgba(76, 175, 80, 0.2); color: #81c784; padding: 15px; border-radius: 8px; border: 1px solid #4caf50; margin-bottom: 20px;">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div style="background: rgba(220, 53, 69, 0.2); color: #ffcccc; padding: 15px; border-radius: 8px; border: 1px solid #dc3545; margin-bottom: 20px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <h2 style="font-size: 24px; border-left: 4px solid var(--gold); padding-left: 10px; margin-bottom: 30px;">Advance Ticket Sales</h2>
    
    <div class="movies-grid">
        <?php foreach($languages as $lang): ?>
        <?php 
        $imgFile = 'assets/images/' . $lang['image'];
        $bgImage = file_exists(FCPATH . $imgFile) ? "background-image: url('" . base_url($imgFile) . "');" : ""; 
        ?>
        <a href="<?= base_url('language-class/detail/' . esc($lang['id'])) ?>" class="movie-card">
            <div class="movie-poster" style="background-color: <?= $lang['color'] ?>; <?= $bgImage ?>">
                <?php if(!$bgImage): ?>
                <div class="movie-poster-placeholder"><?= strtoupper(substr($lang['id'], 0, 2)) ?></div>
                <?php endif; ?>
            </div>
            <div class="movie-info">
                <div class="movie-title"><?= esc($lang['name']) ?></div>
                <div class="movie-category">Kategori: <?= esc($lang['continent']) ?></div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>
