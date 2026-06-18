<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Ringkasan Arsip Stellarum</h2>
    <a href="<?= base_url('admin/books/tambah') ?>" class="btn btn-primary">
        + Tambah Volume Baru
    </a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    
    <div class="card" onclick="window.location.href='<?= base_url('admin/books') ?>'" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem; cursor: pointer;">
        <div style="font-size: 2.2rem; color: var(--gold-dim);">📚</div>
        <div>
            <div style="font-size: 0.7rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.3rem;">Total Koleksi</div>
            <div style="font-size: 1.8rem; font-family: 'Cinzel', serif; color: var(--gold);"><?= esc($totalBooks ?? 0) ?></div>
        </div>
    </div>

    <div class="card" onclick="window.location.href='<?= base_url('admin/users') ?>'" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem; cursor: pointer;">
        <div style="font-size: 2.2rem; color: var(--gold-dim);">👥</div>
        <div>
            <div style="font-size: 0.7rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.3rem;">Anggota Scholar</div>
            <div style="font-size: 1.8rem; font-family: 'Cinzel', serif; color: var(--gold);"><?= esc($totalMembers ?? 0) ?></div>
        </div>
    </div>

    <div class="card" onclick="window.location.href='<?= base_url('admin/loan') ?>'" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem; cursor: pointer;">
        <div style="font-size: 2.2rem; color: var(--gold-dim);">📋</div>
        <div>
            <div style="font-size: 0.7rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.3rem;">Sirkulasi Aktif</div>
            <div style="font-size: 1.8rem; font-family: 'Cinzel', serif; color: var(--ok);"><?= esc($activeLoans ?? 0) ?></div>
        </div>
    </div>

    <div class="card" onclick="window.location.href='<?= base_url('admin/loan') ?>'" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem; cursor: pointer;">
        <div style="font-size: 2.2rem; color: var(--gold-dim);">⚠️</div>
        <div>
            <div style="font-size: 0.7rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.3rem;">Antrean Peminjaman</div>
            <div style="font-size: 1.8rem; font-family: 'Cinzel', serif; color: var(--warn);"><?= esc($pendingLoans ?? 0) ?></div>
        </div>
    </div>

</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Catatan Sirkulasi Terbaru</div>
        <a href="<?= base_url('admin/loan') ?>" style="font-size: 0.75rem; color: var(--muted);">Lihat Semua →</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentLoans)): ?>
                    <?php foreach($recentLoans as $loan): ?>
                    <tr>
                        <td style="color: var(--gold-dim); font-family: 'Cinzel', serif;">#<?= str_pad($loan['id'], 5, '0', STR_PAD_LEFT) ?></td>
                        <td style="color: var(--ivory);"><?= esc($loan['user_name'] ?? 'Unknown Scholar') ?></td>
                        <td style="color: var(--text); font-style: italic;"><?= esc($loan['book_title'] ?? 'Unknown Tome') ?></td>
                        <td><?= date('d M Y', strtotime($loan['borrow_date'])) ?></td>
                        <td>
                            <?php 
                                $status = $loan['status'] ?? 'pending';
                                if ($status === 'approved' || $status === 'active') echo '<span class="badge badge-ok">Berjalan</span>';
                                elseif ($status === 'pending') echo '<span class="badge badge-warn">Menunggu</span>';
                                elseif ($status === 'returned') echo '<span class="badge badge-subtle">Selesai</span>';
                                else echo '<span class="badge badge-danger">Terlambat</span>';
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; font-style: italic; color: var(--subtle); padding: 3rem;">Belum ada catatan sirkulasi di arsip ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>