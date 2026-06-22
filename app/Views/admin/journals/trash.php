<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
    <h2>🗑️ Tong Sampah Jurnal</h2>
    <a href="<?= base_url('admin/list/journals') ?>" class="btn-outline">
        ← Kembali
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div style="color: #7ec8a0; background: rgba(126,200,160,0.1); border: 1px solid rgba(126,200,160,0.3); padding: 12px; margin-bottom: 20px; border-radius: 4px;">
        ✦ <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Judul</th>
                    <th width="15%">Kategori</th>
                    <th width="15%">Penulis</th>
                    <th width="15%">Waktu Dihapus</th>
                    <th width="15%" style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($journals)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted); font-style: italic;">
                            Tong sampah kosong.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($journals as $j): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td style="font-weight: bold; color: var(--text-muted); text-decoration: line-through;"><?= esc($j['title']) ?></td>
                        <td><?= esc($j['type']) ?></td>
                        <td><?= esc($j['author']) ?></td>
                        <td style="font-size: 12px; color: #e07070;"><?= date('d M Y H:i', strtotime($j['deleted_at'])) ?></td>
                        <td style="text-align:right;">
                            <a href="<?= base_url('admin/restore/journal/' . $j['id']) ?>" onclick="return confirm('Pulihkan jurnal ini?')" class="btn-outline" style="padding: 6px 12px; font-size: 11px; margin-right: 5px; color: #7ec8a0; border-color: rgba(126,200,160,0.3);">Pulihkan</a>
                            <a href="<?= base_url('admin/purge/journal/' . $j['id']) ?>" onclick="return confirm('Hapus permanen? Data tidak dapat dikembalikan.')" class="btn-outline" style="padding: 6px 12px; font-size: 11px; color: #e07070; border-color: rgba(224,112,112,0.3);">Hapus Permanen</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
