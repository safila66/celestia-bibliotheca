<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
    /* CSS spesifik khusus untuk form login saja */
    .auth-container {
        max-width: 400px;
        margin: 60px auto;
        background: rgba(4,6,15,0.72);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(201,168,76,0.2);
        padding: 40px;
        border-radius: 8px;
        position: relative;
        z-index: 20; /* Memastikan form berada di atas starfield */
    }
    /* ── EFEK TOMBOL LIHAT SANDI ── */
    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .password-wrapper input {
        /* Memberikan bantalan ekstra di kanan agar teks tidak menabrak ikon mata */
        padding-right: 40px; 
    }
    .toggle-password {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        color: var(--gold-dim);
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
        transition: color 0.2s;
        outline: none;
    }
    .toggle-password:hover { 
        color: var(--gold); 
    }
    .auth-title { font-family: 'Cinzel', serif; color: var(--gold); text-align: center; margin-bottom: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--text-dim); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.1em; }
    .form-control { width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(201,168,76,0.3); color: var(--ivory); font-family: 'EB Garamond', serif; outline: none; }
    .form-control:focus { border-color: var(--gold); }
    .btn-submit { width: 100%; margin-top: 10px; padding: 12px; font-family: 'Cinzel', serif; font-weight: bold; background: var(--gold); color: var(--deep-navy); border: none; cursor: pointer; transition: 0.3s; }
    .btn-submit:hover { background: #e8c898; }
    .auth-links { text-align: center; margin-top: 20px; }
    .auth-links a { color: var(--gold-dim); font-size: 13px; text-decoration: none; transition: color 0.2s; }
    .auth-links a:hover { color: var(--gold); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="auth-container">
    <h2 class="auth-title">Enter The Archive</h2>
    
    <?php if(session()->getFlashdata('error')): ?>
        <div style="color: #ff6b6b; font-size: 13px; margin-bottom: 15px; text-align: center; border: 1px solid #ff6b6b; padding: 8px; background: rgba(220,53,69,0.1);">
            ✗ <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('success')): ?>
        <div style="color: #70c080; font-size: 13px; margin-bottom: 15px; text-align: center; border: 1px solid #70c080; padding: 8px; background: rgba(30,60,30,0.4);">
            ✦ <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('login/process') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Scholar Name (Email)</label>
            <input type="email" name="email" class="form-control" value="<?= set_value('email') ?>" required autofocus>
        </div>
        <div class="form-group">
        <label>Secret Rune (Password)</label>
        <div class="password-wrapper">
            <input type="password" name="password" id="loginPass" class="form-control" required>
            
            <button type="button" class="toggle-password" onclick="toggleVisibility('loginPass', this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
        </div>
    </div>
        </div>
        <button type="submit" class="btn-submit">Unlock Knowledge</button>
    </form>

    <div class="auth-links">
        <a href="<?= base_url('register') ?>">New to the Archive? Join us here.</a>
    </div>
</div>
<script>
    function toggleVisibility(inputId, btnElement) {
        const input = document.getElementById(inputId);
        const svg = btnElement.querySelector('svg');

        if (input.type === 'password') {
            // Ubah jadi teks biasa agar terbaca
            input.type = 'text';
            
            // Mengubah ikon menjadi mata tercoret (Eye-Off) dan warna lebih terang
            svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            btnElement.style.color = 'var(--gold)';
        } else {
            // Kembalikan menjadi titik-titik rahasia
            input.type = 'password';
            
            // Mengembalikan ikon mata normal
            svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            btnElement.style.color = 'var(--gold-dim)';
        }
    }
</script>
<?= $this->endSection() ?>