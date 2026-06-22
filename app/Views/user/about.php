<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
    .about-container {
        max-width: 800px;
        margin: 60px auto;
        padding: 50px;
        background: rgba(13, 16, 37, 0.85);
        border: 1px solid rgba(201, 168, 76, 0.3);
        border-radius: 16px;
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        text-align: center;
    }
    .about-title {
        font-family: 'Cinzel', serif;
        font-size: 2.8rem;
        color: var(--gold, #c9b07a);
        margin-bottom: 15px;
        text-shadow: 0 2px 10px rgba(201,168,76,0.3);
    }
    .about-subtitle {
        font-family: 'Cinzel', serif;
        font-size: 1.1rem;
        color: var(--gold-dim, #7a6840);
        margin-bottom: 40px;
        letter-spacing: 3px;
        text-transform: uppercase;
    }
    .about-text {
        font-size: 1.1rem;
        line-height: 1.9;
        color: #e2e8f0;
        margin-bottom: 25px;
        text-align: justify;
    }
    .about-divider {
        width: 150px;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
        margin: 50px auto;
        opacity: 0.7;
    }
    .contact-section {
        margin-top: 30px;
    }
    .contact-title {
        font-family: 'Cinzel', serif;
        font-size: 1.8rem;
        color: var(--gold, #c9b07a);
        margin-bottom: 25px;
    }
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 15px;
        font-size: 1.1rem;
        color: #e2e8f0;
    }
    .contact-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 10px;
        background: rgba(255,255,255,0.03);
        border-radius: 8px;
        transition: 0.3s;
    }
    .contact-item:hover {
        background: rgba(201,168,76,0.1);
        transform: translateY(-2px);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="about-container">
    <h1 class="about-title">Bibliotheca Stellarum</h1>
    <div class="about-subtitle">Ad astra per libros &mdash; Menuju bintang melalui buku</div>
    
    <div class="about-text">
        Selamat datang di <strong>Bibliotheca Stellarum</strong>, sebuah perpustakaan modern yang didedikasikan untuk menghubungkan para pencari ilmu dengan literatur klasik maupun kontemporer dari seluruh penjuru dunia. Kami percaya bahwa setiap buku adalah sebuah konstelasi cerita, pengetahuan, dan gagasan yang menunggu untuk dijelajahi.
    </div>
    
    <div class="about-text">
        Didirikan dengan visi untuk menyediakan ruang baca yang tenang, koleksi buku yang komprehensif, dan fasilitas kelas modern, perpustakaan kami tidak hanya menjadi tempat menyimpan buku, melainkan pusat kebudayaan dan intelektual bagi semua kalangan.
    </div>
    
    <div class="about-divider"></div>
    
    <div class="contact-section">
        <h2 class="contact-title">Hubungi Kami (Contact Admin)</h2>
        <div class="contact-info">
            <div class="contact-item">
                <span style="font-size: 1.4rem;">📍</span> 
                <span><strong>Alamat:</strong> Jl. Bintang Kejora No. 42, Galaksi Andromeda, Bumi</span>
            </div>
            <div class="contact-item">
                <span style="font-size: 1.4rem;">✉️</span> 
                <span><strong>Email:</strong> admin@bibliothecastellarum.com</span>
            </div>
            <div class="contact-item">
                <span style="font-size: 1.4rem;">📞</span> 
                <span><strong>Telepon:</strong> +62 812 3456 7890</span>
            </div>
            <div class="contact-item">
                <span style="font-size: 1.4rem;">🕒</span> 
                <span><strong>Jam Operasional:</strong> Senin - Jumat (08:00 - 20:00 WIB)</span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
