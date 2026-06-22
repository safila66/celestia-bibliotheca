<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
    .auth-container {
        max-width: 450px;
        margin: 40px auto 80px;
        background: rgba(4,6,15,0.72);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(201,168,76,0.2);
        padding: 40px;
        border-radius: 8px;
        position: relative;
        z-index: 20;
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
    .auth-title { font-family: 'Cinzel', serif; color: var(--gold); text-align: center; margin-bottom: 8px; }
    .auth-subtitle { text-align: center; color: var(--text-dim); font-size: 13px; font-style: italic; margin-bottom: 24px; }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--text-dim); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.1em; }
    .form-control { width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(201,168,76,0.3); color: var(--ivory); font-family: 'EB Garamond', serif; outline: none; }
    .form-control:focus { border-color: var(--gold); }
    .btn-submit { width: 100%; margin-top: 15px; padding: 12px; font-family: 'Cinzel', serif; font-weight: bold; background: var(--gold); color: var(--deep-navy); border: none; cursor: pointer; transition: 0.3s; }
    .btn-submit:hover { background: #e8c898; }
    .auth-links { text-align: center; margin-top: 20px; }
    .auth-links a { color: var(--gold-dim); font-size: 13px; text-decoration: none; transition: color 0.2s; }
    .auth-links a:hover { color: var(--gold); }

    /* ── LIGHT MODE ── */
    [data-theme="light"] .auth-container {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(168, 117, 42, 0.25);
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.1);
    }
    [data-theme="light"] .auth-title {
        color: #A8752A;
    }
    [data-theme="light"] .auth-subtitle {
        color: #5A4E3A;
    }
    [data-theme="light"] .form-group label {
        color: #5A4E3A;
    }
    [data-theme="light"] .form-control {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(168, 117, 42, 0.3);
        color: #2C2416;
    }
    [data-theme="light"] .form-control::placeholder {
        color: rgba(44, 36, 22, 0.4);
    }
    [data-theme="light"] .form-control:focus {
        border-color: #A8752A;
        background: #fff;
    }
    [data-theme="light"] .btn-submit {
        background: #A8752A;
        color: #fff;
    }
    [data-theme="light"] .btn-submit:hover {
        background: #C9943E;
    }
    [data-theme="light"] .auth-links a {
        color: #7A6030;
    }
    [data-theme="light"] .auth-links a:hover {
        color: #A8752A;
    }
    [data-theme="light"] .toggle-password {
        color: #A8752A;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="auth-container">
    <h2 class="auth-title">REGISTER</h2>
    <p class="auth-subtitle">Your Name Engraved Herein.</p>

   <?php if(session()->getFlashdata('errors')): ?>
    <div style="color: #ff6b6b; font-size: 13px; margin-bottom: 15px; border: 1px solid #ff6b6b; padding: 10px; background: rgba(220,53,69,0.1);">
        <?php foreach(session()->getFlashdata('errors') as $error): ?>
            ✗ <?= esc($error) ?><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div style="color: #ff6b6b; font-size: 13px; margin-bottom: 15px; border: 1px solid #ff6b6b; padding: 10px; background: rgba(220,53,69,0.1);">
        ✗ <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

    <div id="ajaxAlert" style="display:none; color: #ff6b6b; font-size: 13px; margin-bottom: 15px; border: 1px solid #ff6b6b; padding: 10px; background: rgba(220,53,69,0.1);"></div>

    <form id="registerForm" action="<?= base_url('register/process') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label>Scholar Name (Full Name)</label>
            <input type="text" name="name" class="form-control" value="<?= set_value('name') ?>" required autofocus>
        </div>
        
        <div class="form-group">
            <label>Stellar Address (Email)</label>
            <input type="email" name="email" class="form-control" value="<?= set_value('email') ?>" required>
        </div>
        
        <div class="form-group">
        <label>Secret Rune (Password)</label>
        <div class="password-wrapper">
            <input type="password" name="password" id="regPass" class="form-control" required>
            <button type="button" class="toggle-password" onclick="toggleVisibility('regPass', this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
        </div>
    </div>
    
    <div class="form-group">
        <label>Verify Rune (Confirm Password)</label>
        <div class="password-wrapper">
            <input type="password" name="password_confirmation" id="regPassConf" class="form-control" required>
            <button type="button" class="toggle-password" onclick="toggleVisibility('regPassConf', this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
        </div>
    </div>
        <div class="form-group">
            <label>Planet (Address)</label>
            <input type="text" name="address" class="form-control" value="<?= set_value('address') ?>" required>
        </div>
        
         <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" class="form-control" value="<?= set_value('phone') ?>" required>
        </div>

        <!-- Dropdown Pemilihan Role -->
    <div class="form-group">
         <label>CHOOSE YOUR PATH (ROLE)</label>
          <select name="role" id="roleSelect" class="form-control">
        <option value="member">Scholar (Member)</option>
        <option value="admin">Librarian (Admin)</option>
    </select>
    <small style="color: var(--text-dim); font-size: 11px; font-style: italic; margin-top: 5px; display: block;">
        *only admin can access the Librarian role. If you are a Scholar, please select the Member role.
    </small>
</div>
        
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let form = document.getElementById('registerForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let btn = form.querySelector('.btn-submit');
                let alertBox = document.getElementById('ajaxAlert');
                
                if (btn) {
                    btn.innerHTML = 'Forging Key...';
                    btn.disabled = true;
                }
                
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alertBox.style.display = 'block';
                        alertBox.style.color = '#70c080';
                        alertBox.style.borderColor = '#70c080';
                        alertBox.style.background = 'rgba(30,60,30,0.4)';
                        alertBox.innerHTML = '✦ ' + data.message;
                        setTimeout(() => { window.location.href = data.redirect; }, 1000);
                    } else {
                        alertBox.style.display = 'block';
                        alertBox.style.color = '#ff6b6b';
                        alertBox.style.borderColor = '#ff6b6b';
                        alertBox.style.background = 'rgba(220,53,69,0.1)';
                        if (data.error) {
                            alertBox.innerHTML = '✗ ' + data.error;
                        } else if (data.errors) {
                            let errs = Object.values(data.errors).join('<br>✗ ');
                            alertBox.innerHTML = '✗ ' + errs;
                        } else {
                            alertBox.innerHTML = '✗ Validasi gagal.';
                        }
                        if (btn) {
                            btn.innerHTML = 'Forge Archive Key';
                            btn.disabled = false;
                        }
                    }
                }).catch(err => {
                    alertBox.style.display = 'block';
                    alertBox.style.color = '#ff6b6b';
                    alertBox.style.borderColor = '#ff6b6b';
                    alertBox.style.background = 'rgba(220,53,69,0.1)';
                    alertBox.innerHTML = '✗ Terjadi kesalahan jaringan / server.';
                    if (btn) {
                        btn.innerHTML = 'Forge Archive Key';
                        btn.disabled = false;
                    }
                });
            });
        }
    });

    function toggleVisibility(inputId, btnElement) {
        const input = document.getElementById(inputId);
        const svg = btnElement.querySelector('svg');

        if (input.type === 'password') {
            input.type = 'text';
            svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            btnElement.style.color = 'var(--gold)';
        } else {
            input.type = 'password';
            svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            btnElement.style.color = 'var(--gold-dim)';
        }
    }
</script>
<?= $this->endSection() ?>
