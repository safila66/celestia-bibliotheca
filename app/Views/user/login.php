<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk — Bibliotheca Stellarum</title>
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

        /* Left: decorative panel */
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
                radial-gradient(circle, rgba(201,176,122,.3) 1px, transparent 1px);
            background-size: 80px 70px, 130px 110px;
            background-position: 15px 20px, 60px 40px;
            pointer-events: none;
        }
        .deco-content { position: relative; text-align: center; }
        .deco-symbol {
            font-size: 3rem; margin-bottom: 1.5rem; opacity: .7;
        }
        .deco-title {
            font-family: 'Cinzel', serif; font-size: 1.4rem;
            color: var(--gold); letter-spacing: .15em; margin-bottom: .75rem;
        }
        .deco-quote {
            font-style: italic; font-size: .88rem;
            color: var(--muted); line-height: 1.8; max-width: 280px;
        }
        .deco-divider {
            width: 60px; height: 1px; background: var(--border2);
            margin: 1.5rem auto;
        }
        .deco-links { display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; }
        .deco-link {
            font-family: 'Cinzel', serif; font-size: .6rem;
            letter-spacing: .1em; color: var(--muted);
            padding: .35rem .9rem; border: 1px solid var(--border);
            border-radius: 2px; transition: all .2s; text-decoration: none;
        }
        .deco-link:hover { border-color: var(--gold-dim); color: var(--gold); }

        /* Right: form panel */
        .auth-form-wrap {
            width: 420px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            padding: 2rem;
        }
        .auth-card { width: 100%; }
        .auth-header { margin-bottom: 2rem; }
        .auth-eyebrow {
            font-family: 'Cinzel', serif; font-size: .6rem;
            letter-spacing: .2em; color: var(--muted); margin-bottom: .5rem;
        }
        .auth-heading {
            font-family: 'Cinzel', serif; font-size: 1.5rem;
            color: var(--gold); letter-spacing: .08em;
        }

        .form-group { margin-bottom: 1.2rem; }
        .form-label {
            display: block; font-family: 'Cinzel', serif; font-size: .63rem;
            letter-spacing: .1em; color: var(--gold-dim); margin-bottom: .45rem;
        }
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
            font-family: 'Cinzel', serif; font-size: .75rem;
            letter-spacing: .12em; background: transparent;
            border: 1px solid var(--gold-dim); color: var(--gold);
            border-radius: 2px; cursor: pointer; transition: all .3s;
        }
        .btn-submit:hover { background: var(--gold); color: var(--cosmos); }

        .auth-footer {
            text-align: center; margin-top: 1.5rem;
            font-size: .8rem; color: var(--muted);
        }
        .auth-footer a { color: var(--blue); }
        .auth-footer a:hover { color: var(--gold); }

        .error-list { margin-bottom: 1rem; }
        .error-item {
            font-size: .75rem; color: #e07070;
            background: rgba(60,20,20,.4); border: 1px solid #3a1010;
            padding: .45rem .8rem; border-radius: 2px; margin-bottom: .4rem;
        }
        .flash-msg {
            padding: .55rem .8rem; border-radius: 2px; font-size: .78rem;
            margin-bottom: 1rem;
        }
        .flash-msg.success { background: rgba(20,50,20,.4); color: #70c080; border: 1px solid #1a3020; }
        .flash-msg.error   { background: rgba(50,15,15,.4); color: #e07070; border: 1px solid #3a1010; }
    </style>
</head>
<body>

<div class="auth-deco">
    <div class="deco-stars"></div>
    <div class="deco-content">
        <div class="deco-symbol">✦</div>
        <div class="deco-title">Bibliotheca<br>Stellarum</div>
        <div class="deco-divider"></div>
        <div class="deco-quote">
            "Ad astra per libros —<br>Menuju bintang<br>melalui buku."
        </div>
        <div class="deco-links">
            <a href="/katalog" class="deco-link">Katalog</a>
            <a href="/about" class="deco-link">Tentang</a>
        </div>
    </div>
</div>

<div class="auth-form-wrap">
    <div class="auth-card">

        <div class="auth-header">
            <div class="auth-eyebrow">PORTAL ANGGOTA</div>
            <div class="auth-heading">Masuk</div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-msg success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-msg error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
        <div class="error-list">
            <?php foreach ($errors as $e): ?>
            <div class="error-item">✗ <?= esc($e) ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form action="/login" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label class="form-label">EMAIL</label>
                <input type="email" name="email" class="form-control"
                       placeholder="email@domain.com"
                       value="<?= old('email') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">PASSWORD</label>
                <input type="password" name="password" class="form-control"
                       placeholder="••••••••">
            </div>

            <button type="submit" class="btn-submit">MASUK →</button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="/register">Daftar sekarang</a>
        </div>

    </div>
</div>

</body>
</html>