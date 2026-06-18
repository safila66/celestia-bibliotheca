<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin — <?= esc($title ?? 'Dasbor') ?> | Bibliotheca Stellarum</title>
<link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
<?= $this->renderSection('styles') ?>
</head>
<body>
<canvas id="starfield"></canvas>

<?php
  $session   = session();
  $userName  = $session->get('user_name');
  $pendingCount = (new \App\Models\LoanModel())->countPending();
?>

<div class="page-content">
<div class="admin-shell">

  <!-- SIDEBAR -->
  <aside class="admin-sidebar">
    <div class="sidebar-logo">
      <div class="logo-emblem" style="width:36px;height:36px;font-size:16px"></div>
      <div class="logo-text" style="font-size:11px">Bibliotheca<br><span>Admin Panel</span></div>
    </div>

    <div class="sidebar-section">
      <span class="sidebar-section-label">Navigasi Utama</span>
      <nav class="sidebar-nav">
        <a href="<?= base_url('admin') ?>" class="<?= current_url() === base_url('admin') || current_url() === base_url('admin/') ? 'active' : '' ?>">
          <span class="nav-icon">⊕</span> Dasbor
        </a>
        <a href="<?= base_url('admin/books') ?>" class="<?= str_contains(current_url(), '/admin/books') ? 'active' : '' ?>">
          <span class="nav-icon">☉</span> catalog Koleksi
        </a>
        <a href="<?= base_url('admin/books/tambah') ?>" class="<?= current_url() === base_url('admin/books/tambah') ? 'active' : '' ?>">
          <span class="nav-icon">✦</span> Tambah Koleksi
        </a>
        <a href="<?= base_url('admin/loan') ?>" class="<?= str_contains(current_url(), '/admin/loan') ? 'active' : '' ?>">
          <span class="nav-icon">◈</span> Peminjaman
          <?php if ($pendingCount > 0): ?>
            <span style="margin-left:auto;background:var(--gold);color:var(--navy);font-size:9px;padding:2px 6px;border-radius:10px;font-family:'Cinzel',serif;font-weight:700"><?= $pendingCount ?></span>
          <?php endif; ?>
        </a>
      </nav>
    </div>

    <div class="sidebar-section">
      <span class="sidebar-section-label">Anggota & Kategori</span>
      <nav class="sidebar-nav">
        <a href="<?= base_url('admin/users') ?>" class="<?= str_contains(current_url(), '/admin/users') ? 'active' : '' ?>">
          <span class="nav-icon">☽</span> Daftar Anggota
        </a>
        <a href="<?= base_url('admin/kategori') ?>" class="<?= str_contains(current_url(), '/admin/kategori') ? 'active' : '' ?>">
          <span class="nav-icon">✧</span> Kategori
        </a>
      </nav>
    </div>

    <div class="sidebar-section">
      <span class="sidebar-section-label">report</span>
      <nav class="sidebar-nav">
        <a href="<?= base_url('admin/report') ?>" class="<?= str_contains(current_url(), '/admin/report') ? 'active' : '' ?>">
          <span class="nav-icon">☀</span> Statistik & report
        </a>
      </nav>
    </div>

    <div class="sidebar-section">
      <span class="sidebar-section-label">Akun</span>
      <nav class="sidebar-nav">
        <a href="<?= base_url('/') ?>">
          <span class="nav-icon">☿</span> Lihat Situs
        </a>
        <a href="<?= base_url('logout') ?>" style="color:rgba(200,80,80,0.6)!important">
          <span class="nav-icon">✴</span> Keluar
        </a>
      </nav>
    </div>

    <div class="sidebar-profile">
      <div class="admin-avatar"><?= esc(strtoupper(mb_substr($userName ?? 'A', 0, 2))) ?></div>
      <div class="admin-info">
        <div class="name"><?= esc(mb_substr($userName ?? '', 0, 14)) ?></div>
        <div class="role">Super Admin</div>
      </div>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="admin-main">
    <div class="admin-topbar">
      <div class="breadcrumb">
        Bibliotheca <span>✦</span> <?= esc($breadcrumb ?? 'Dasbor') ?>
      </div>
      <div class="topbar-right">
        <?php if ($pendingCount > 0): ?>
          <a href="<?= base_url('admin/loan?status=pending') ?>" class="topbar-btn" title="<?= $pendingCount ?> loan pending" style="position:relative">
            🔔
            <span style="position:absolute;top:-4px;right:-4px;width:16px;height:16px;background:var(--gold);border-radius:50%;font-size:8px;color:var(--navy);display:flex;align-items:center;justify-content:center;font-weight:700;font-family:'Cinzel',serif"><?= $pendingCount ?></span>
          </a>
        <?php endif; ?>
        <a href="<?= base_url('/') ?>" class="topbar-btn" title="Lihat Situs">🏛</a>
      </div>
    </div>

    <!-- Flash -->
    <?php if ($session->getFlashdata('success')): ?>
      <div class="alert alert-success" style="margin:16px 32px 0">✦ &nbsp;<?= esc($session->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if ($session->getFlashdata('error')): ?>
      <div class="alert alert-error" style="margin:16px 32px 0">⚠ &nbsp;<?= esc($session->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="admin-content">
      <?= $this->renderSection('content') ?>
    </div>
  </main>
</div>
</div>

<script src="<?= base_url('js/app.js') ?>"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>