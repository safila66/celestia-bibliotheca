<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin') ?> — Bibliotheca Stellarum</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
    --bg:       #f4ecd8;
    --deep:     #ece1c4;
    --panel:    #e3d4ad;
    --border:   #c9b384;
    --border2:  #b09660;
    --gold:     #8a6420;
    --gold-dim: #a07830;
    --gold-sub: #6e5018;
    --text:     #2e2410;
    --muted:    #5a4828;
    --subtle:   #8a7048;
    --ok:       #4a7a3a;
    --warn:     #b85a20;
    --danger:   #a03030;
}

        body {
            font-family: 'EB Garamond', serif;
            background: var(--bg);
            color: var(--text);
            display: flex; min-height: 100vh;
        }

        a { color: var(--gold); text-decoration: none; transition: color .2s; }
        a:hover { color: #e8c898; }

        /* ── Admin Sidebar ───────────────────────────── */
        .admin-sidebar {
            width: 220px; flex-shrink: 0;
            background: var(--deep);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            position: fixed; top: 0; bottom: 0; left: 0;
            overflow-y: auto; z-index: 100;
        }

        .sidebar-logo {
            padding: 1.4rem 1.2rem 1.2rem;
            border-bottom: 1px solid var(--border);
            text-align: center;
        }
        .sidebar-logo .logo-text {
            font-family: 'Cinzel', serif; font-size: .82rem;
            color: var(--gold); letter-spacing: .1em; line-height: 1.6;
        }
        .sidebar-logo .logo-sub {
            font-size: .58rem; color: var(--gold-dim);
            font-style: italic; letter-spacing: .05em;
        }

        .nav-group { padding: 1rem 0; border-bottom: 1px solid var(--border); }
        .nav-group-label {
            font-family: 'Cinzel', serif; font-size: .52rem;
            letter-spacing: .18em; color: var(--gold-sub);
            text-transform: uppercase; padding: 0 1.2rem .6rem;
        }

        .nav-item {
            display: flex; align-items: center; gap: .7rem;
            padding: .55rem 1.2rem; font-size: .78rem; color: var(--muted);
            transition: all .2s; cursor: pointer; position: relative;
        }
        .nav-item:hover, .nav-item.active {
            background: var(--panel); color: var(--gold);
        }
        .nav-item.active::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0;
            width: 2px; background: var(--gold);
        }

        .nav-badge {
            margin-left: auto; font-size: .58rem;
            background: #3a2000; color: var(--gold);
            border: 1px solid var(--border2);
            padding: 1px 6px; border-radius: 10px;
        }
        .nav-badge.warn { background: #2a1000; color: var(--warn); border-color: #502010; }

        /* ── Main area ───────────────────────────────── */
        .admin-main { margin-left: 220px; flex: 1; display: flex; flex-direction: column; }

        /* ── Topbar ──────────────────────────────────── */
        .admin-topbar {
            position: sticky; top: 0; z-index: 50;
            background: var(--deep); border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 1.5rem; height: 56px; gap: 1rem;
        }

        .topbar-title {
            font-family: 'Cinzel', serif; font-size: .9rem;
            color: var(--gold); letter-spacing: .08em; flex: 1;
        }

        .topbar-right { display: flex; align-items: center; gap: .75rem; }

        .topbar-notif {
            width: 32px; height: 32px; border-radius: 50%;
            border: 1px solid var(--border2);
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem; cursor: pointer; color: var(--muted);
            position: relative; transition: all .2s;
        }
        .topbar-notif:hover { border-color: var(--gold-dim); color: var(--gold); }

        .notif-dot {
            width: 7px; height: 7px; background: var(--warn);
            border-radius: 50%; position: absolute; top: 4px; right: 4px;
            border: 1px solid var(--deep);
        }

        .topbar-info { font-size: .72rem; color: var(--gold-dim); font-style: italic; }

        .topbar-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, #c9a060, #8a6420);
            border: 1px solid var(--border2);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cinzel', serif; font-size: .6rem; color: var(--gold);
        }

        /* ── Content ─────────────────────────────────── */
        .admin-content { padding: 1.5rem; flex: 1; }

        /* ── Flash ───────────────────────────────────── */
        .flash {
            padding: .65rem 1.5rem; font-size: .78rem;
            display: flex; align-items: center; gap: .6rem;
        }
        .flash.success { background: rgba(74,122,58,.12); border-bottom: 1px solid #4a7a3a; color: #3a6030; }
        .flash.error   { background: rgba(160,48,48,.12); border-bottom: 1px solid #a03030; color: #8a2828; }

        /* ── Utilities ───────────────────────────────── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .page-header h2 {
            font-family: 'Cinzel', serif; font-size: 1rem;
            color: var(--gold); letter-spacing: .08em;
        }

        .btn {
            font-family: 'Cinzel', serif; font-size: .68rem;
            letter-spacing: .08em; padding: .45rem 1.1rem;
            border: 1px solid; border-radius: 2px;
            cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: .4rem;
        }
        .btn-primary { border-color: var(--gold-dim); color: var(--gold); background: var(--panel); }
        .btn-primary:hover { background: var(--gold); color: var(--bg); }
        .btn-danger  { border-color: #4a1818; color: var(--danger); background: transparent; }
        .btn-danger:hover  { background: var(--danger); color: #fff; border-color: var(--danger); }
        .btn-sm { padding: .25rem .7rem; font-size: .6rem; }

        .card {
            background: var(--deep); border: 1px solid var(--border);
            border-radius: 4px; overflow: hidden;
        }
        .card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: .85rem 1.2rem; border-bottom: 1px solid var(--border);
        }
        .card-title {
            font-family: 'Cinzel', serif; font-size: .72rem;
            color: var(--gold); letter-spacing: .08em;
        }

        /* Table */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: .75rem; }
        th {
            background: var(--panel); color: var(--gold-dim);
            font-family: 'Cinzel', serif; font-weight: 400;
            font-size: .62rem; letter-spacing: .1em;
            padding: .65rem 1rem; text-align: left;
            border-bottom: 1px solid var(--border);
        }
        td {
            padding: .65rem 1rem; color: var(--muted);
            border-bottom: 1px solid var(--border);
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--panel); color: var(--text); }

        /* Form */
        .form-group { margin-bottom: 1.2rem; }
        .form-label {
            display: block; font-family: 'Cinzel', serif;
            font-size: .65rem; letter-spacing: .08em;
            color: var(--gold-dim); margin-bottom: .4rem;
        }
        .form-control {
            width: 100%; background: var(--deep); border: 1px solid var(--border);
            color: var(--text); padding: .55rem .9rem;
            font-family: 'EB Garamond', serif; font-size: .82rem;
            border-radius: 2px; transition: border-color .2s;
        }
        .form-control:focus { outline: none; border-color: var(--gold-dim); }
        .form-control::placeholder { color: var(--subtle); }

        /* Badges */
        .badge {
            font-size: .6rem; padding: 2px 7px; border-radius: 10px; border: 1px solid;
        }
        .badge-ok     { background: rgba(74,122,58,.15); color: var(--ok);     border-color: #4a7a3a; }
.badge-warn   { background: rgba(184,90,32,.15); color: var(--warn);   border-color: #b85a20; }
.badge-danger { background: rgba(160,48,48,.15); color: var(--danger); border-color: #a03030; }
.badge-subtle { background: var(--panel);        color: var(--muted);  border-color: var(--border); }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

<!-- Sidebar -->
<aside class="admin-sidebar">
    <div class="sidebar-logo">
        <div class="logo-text">☽ BIBLIOTHECA<br>STELLARUM</div>
        <div class="logo-sub">Administrator Console</div>
    </div>

    <nav>
        <div class="nav-group">
            <div class="nav-group-label">Utama</div>
            <a href="/admin" class="nav-item <?= current_url() === base_url('admin') ? 'active' : '' ?>">
                📊 Dashboard
            </a>
            <a href="/admin/books" class="nav-item <?= str_contains(current_url(),'admin/books') ? 'active' : '' ?>">
                📚 Koleksi Buku
            </a>
            <a href="/admin/users" class="nav-item <?= str_contains(current_url(),'admin/users') ? 'active' : '' ?>">
                👥 Anggota
            </a>
            <?php if (session()->get('role') === 'superadmin'): ?>
            <a href="<?= base_url('admin/list/superadmin') ?>" class="nav-item <?= str_contains(current_url(),'admin/list/superadmin') ? 'active' : '' ?>">
                🛡️ Manajemen Admin
            </a>
            <?php endif; ?>
            <a href="<?= base_url('admin/list/journals') ?>" class="nav-item <?= str_contains(current_url(),'admin/list/journals') ? 'active' : '' ?>">
                📰 Manajemen Jurnal
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-group-label">Sirkulasi</div>
            <a href="/admin/loan" class="nav-item <?= str_contains(current_url(),'admin/loan') ? 'active' : '' ?>">
                📋 Peminjaman
            </a>
            <a href="/admin/delivery" class="nav-item <?= str_contains(current_url(),'admin/delivery') ? 'active' : '' ?>">
                🚚 Book Delivery
            </a>
            <a href="/admin/fines" class="nav-item <?= str_contains(current_url(),'admin/fines') ? 'active' : '' ?>">
                💰 Denda
            </a>
            <a href="/admin/room-bookings" class="nav-item <?= str_contains(current_url(),'room-bookings') ? 'active' : '' ?>">
                🏛️ Room Booking
            </a>
            <a href="/admin/services" class="nav-item <?= str_contains(current_url(),'admin/services') ? 'active' : '' ?>">
                📡 Monitor Layanan
            </a>
            <a href="/admin/scanner" class="nav-item <?= str_contains(current_url(),'admin/scanner') ? 'active' : '' ?>">
                📷 QR Scanner
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-group-label">Pengaturan</div>
            <a href="/admin/kategori" class="nav-item <?= str_contains(current_url(),'admin/kategori') ? 'active' : '' ?>">
                📦 Kategori
            </a>
            <a href="/admin/report" class="nav-item <?= str_contains(current_url(),'admin/report') ? 'active' : '' ?>">
                📈 report
            </a>
            <a href="/logout" class="nav-item" style="margin-top:1rem; color: #7a3030;">
                ↩ Keluar
            </a>
        </div>
    </nav>
</aside>

<!-- Main -->
<div class="admin-main">

    <!-- Topbar -->
    <header class="admin-topbar">
        <div class="topbar-title">☽ <?= esc($title ?? 'Dashboard') ?></div>
        <div class="topbar-right">
            <div class="topbar-notif">🔔<div class="notif-dot"></div></div>
            <div class="topbar-info">Admin · <?= esc(session()->get('user_name')) ?></div>
            <div class="topbar-avatar"><?= strtoupper(substr(session()->get('user_name'), 0, 2)) ?></div>
        </div>
    </header>

    <!-- Flash -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="flash success">✦ <?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="flash error">✗ <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Content -->
    <main class="admin-content">
        <?= $this->renderSection('content') ?>
    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('submit', function(e) {
        let form = e.target;
        if (form.tagName === 'FORM' && form.closest('.modal')) {
            e.preventDefault();
            
            let btn = form.querySelector('button[type="submit"]');
            let originalText = btn ? btn.innerHTML : 'Simpan';
            if (btn) {
                btn.innerHTML = 'Memproses...';
                btn.disabled = true;
            }

            let alertBox = form.querySelector('.ajax-alert');
            if (!alertBox) {
                alertBox = document.createElement('div');
                alertBox.className = 'ajax-alert';
                alertBox.style.padding = '10px';
                alertBox.style.marginBottom = '15px';
                alertBox.style.borderRadius = '4px';
                alertBox.style.border = '1px solid transparent';
                form.insertBefore(alertBox, form.firstChild);
            }
            
            // Fungsi helper untuk scroll ke atas modal
            function scrollToAlert() {
                let scrollTarget = form.closest('.modal-body') || form.closest('.modal-content') || form;
                scrollTarget.scrollTo({top: 0, behavior: 'smooth'});
            }

            fetch(form.action, {
                method: form.method || 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    alertBox.style.display = 'block';
                    alertBox.style.color = '#70c080';
                    alertBox.style.borderColor = '#70c080';
                    alertBox.style.background = 'rgba(30,60,30,0.4)';
                    alertBox.innerHTML = '✦ ' + (data.message || 'Berhasil disimpan!');
                    scrollToAlert();
                    
                    setTimeout(() => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.reload();
                        }
                    }, 800);
                } else {
                    alertBox.style.display = 'block';
                    alertBox.style.color = '#ff6b6b';
                    alertBox.style.borderColor = '#ff6b6b';
                    alertBox.style.background = 'rgba(220,53,69,0.1)';
                    
                    if (data.error) {
                        alertBox.innerHTML = '✗ ' + data.error;
                    } else if (data.errors) {
                        alertBox.innerHTML = '✗ ' + Object.values(data.errors).join('<br>✗ ');
                    } else {
                        alertBox.innerHTML = '✗ Gagal menyimpan data.';
                    }
                    scrollToAlert();
                    if (btn) {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                }
            })
            .catch(err => {
                alertBox.style.display = 'block';
                alertBox.style.color = '#ff6b6b';
                alertBox.style.borderColor = '#ff6b6b';
                alertBox.style.background = 'rgba(220,53,69,0.1)';
                alertBox.innerHTML = '✗ Terjadi kesalahan jaringan / server.';
                scrollToAlert();
                if (btn) {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            });
        }
    });
});
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
