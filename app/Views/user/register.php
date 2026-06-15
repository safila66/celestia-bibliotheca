<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar — Bibliotheca Stellarum</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --cosmos: #08091a; --deep: #0d1025; --panel: #111830;
            --border: #1e2a50; --border2: #2a3560;
            --gold: #c9b07a; --gold-dim: #7a6840;
            --blue: #6a9fd8; --text: #e8dfc8;
            --muted: #7788aa; --subtle: #3a4468;
        }
        body {
            font-family: 'EB Garamond', serif;
            background: var(--cosmos); color: var(--text);
            min-height: 100vh; display: flex;
        }
        .auth-deco {
            flex: 1; background: var(--deep);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 3rem; position: relative; overflow: hidden;
        }
        .deco-stars {
            position: absolute; inset: 0;
            background-image:
                radial-gradient(circle, rgba(255,255,255,.5) 1px, transparent 1px),
                radial-gradient(circle, rgba(106,159,216,.3) 1px, transparent 1px);
            background-size: 80px 70px, 130px 110px;
            background-position: 15px 20px, 60px 40px;
            pointer-events: none;
        }
        .deco-content { position: relative; text-align: center; }
        .deco-symbol { font-size: 2.5rem; margin-bottom: 1.5rem; opacity: .7; }
        .deco-title {
            font-family: 'Cinzel', serif; font-size: 1.4rem;
            color: var(--gold); letter-spacing: .15em; margin-bottom: .75rem;
        }
        .deco-quote {
            font-style: italic; font-size: .88rem;
            color: var(--muted); line-height: 1.8; max-width: 260px;
        }
        .deco-divider { width: 60px; height: 1px; background: var(--border2); margin: 1.5rem auto; }
        .steps { text-align: left; }
        .step { display: flex; gap: .8rem; margin-bottom: .85rem; align-items: flex-start; }
        .step-num {
            font-family: 'Cinzel', serif; font-size: .65rem; color: var(--gold);
            border: 1px solid var(--border2); border-radius: 50%;
            width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: .1rem;
        }
        .step-text { font-size: .8rem; color: var(--muted); line-height: 1.5; }
        .auth-form-wrap {
            width: 440px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            padding: 2rem;
        }
        .auth-card { width: 100%; }
        .auth-header { margin-bottom: 2rem; }
        .auth-eyebrow { font-family: 'Cinzel', serif; font-size: .6rem; letter-spacing: .2em; color: var(--muted); margin-bottom: .5rem; }
        .auth-heading { font-family: 'Cinzel', serif; font-size: 1.5rem; color: var(--gold); letter-spacing: .08em; }
        .form-group { margin-bottom: 1.1rem; }
        .form-label { display: block; font-family: 'Cinzel', serif; font-size: .63rem; letter-spacing: .1em; color: var(--gold-dim); margin-bottom: .4rem; }
        .form-control {
            width: 100%; background: var(--deep); border: 1px solid var(--border);
            color: var(--text); padding: .6rem .9rem;
            font-family: 'EB Garamond', serif; font-size: .9rem;
            border-radius: 2px; transition: border-color .2s;
        }
        .form-control:focus { outline: none; border-color: var(--gold-dim); }
        .form-control::placeholder { color: var(--subtle); }
        .btn-submit {
            width: 100%; padding: .75rem; margin-top: .5rem;
            font-family: 'Cinzel', serif; font-size: .75rem; letter-spacing: .12em;
            background: transparent; border: 1px solid var(--gold-dim); color: var(--gold);
            border-radius: 2px; cursor: pointer; transition: all .3s;
        }
        .btn-submit:hover { background: var(--gold); color: var(--cosmos); }
        .auth-footer { text-align: center; margin-top: 1.5rem; font-size: .8rem; color: var(--muted); }
        .auth-footer a { color: var(--blue); }
        .auth-footer a:hover { color: var(--gold); }
        .error-list { margin-bottom: 1rem; }
        .error-item {
            font-size: .75rem; color: #e07070;
            background: rgba(60,20,20,.4); border: 1px solid #3a1010;
            padding: .45rem .8rem; border-radius: 2px; margin-bottom: .4rem;
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    </style>
</head>
<body>

<div class="auth-deco">
    <div class="deco-stars"></div>
    <div class="deco-content">
        <div class="deco-symbol">🌟</div>
        <div class="deco-title">Bergabunglah<br>Bersama Kami</div>
        <div class="deco-divider"></div>
        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-text">Daftar akun anggota secara gratis</div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-text">Jelajahi ribuan koleksi buku & jurnal</div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-text">Pinjam, reservasi, dan nikmati layanan</div>
            </div>
        </div>
    </div>
</div>

<div class="auth-form-wrap">
    <div class="auth-card">

        <div class="auth-header">
            <div class="auth-eyebrow">KEANGGOTAAN BARU</div>
            <div class="auth-heading">Buat Akun</div>
        </div>

        <?php if (!empty($errors)): ?>
        <div class="error-list">
            <?php foreach ($errors as $e): ?>
            <div class="error-item">✗ <?= esc($e) ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form action="/register" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label class="form-label">NAMA LENGKAP</label>
                <input type="text" name="name" class="form-control"
                       placeholder="Nama Lengkap Anda"
                       value="<?= old('name') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">EMAIL</label>
                <input type="email" name="email" class="form-control"
                       placeholder="email@domain.com"
                       value="<?= old('email') ?>">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">PASSWORD</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Min. 6 karakter">
                </div>
                <div class="form-group">
                    <label class="form-label">KONFIRMASI</label>
                    <input type="password" name="confirm_password" class="form-control"
                           placeholder="Ulangi password">
                </div>
            </div>

            <button type="submit" class="btn-submit">DAFTAR →</button>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="/login">Masuk di sini</a>
        </div>

    </div>
</div>

</body>
</html>