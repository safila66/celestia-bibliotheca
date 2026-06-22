<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 15px;">
    <h2 style="font-family: 'Cinzel', serif; color: var(--gold); font-weight: bold; margin: 0; font-size: 24px;"><?= esc($title) ?></h2>
    
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <!-- Navigasi Tab Laporan -->
        <a href="<?= base_url('admin/report/buku') ?>" style="padding: 8px 16px; border: 1px solid var(--gold); color: var(--gold); text-decoration: none; border-radius: 4px;">📖 Lap. Buku</a>
        <a href="<?= base_url('admin/report/member') ?>" style="padding: 8px 16px; background: var(--gold); color: #04060f; border: none; font-weight: bold; text-decoration: none; border-radius: 4px;">👥 Lap. Anggota</a>
    </div>
</div>

<div class="card" style="background: var(--deep-navy); padding: 20px; border-radius: 8px; border: 1px solid rgba(201,168,76,0.3);">
    
    <div style="margin-bottom: 20px; display: flex; gap: 10px;">
        <a href="<?= base_url('admin/report/cetak-kartu-member') ?>" target="_blank" style="padding: 8px 16px; background: #4682B4; color: white; border: none; font-weight: bold; text-decoration: none; border-radius: 4px;">
            🖨️ Cetak Semua Kartu Anggota
        </a>
    </div>

    <div class="table-wrap" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--ivory);">
            <thead>
                <tr style="border-bottom: 2px solid var(--gold); background: rgba(201,168,76,0.1);">
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">No</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">ID Anggota</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Nama Lengkap</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Email</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Telepon</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($members as $m): ?>
                    <tr style="border-bottom: 1px solid rgba(201,168,76,0.2);">
                        <td style="padding: 12px 10px;"><?= $no++ ?></td>
                        <td style="padding: 12px 10px; font-weight: bold;">MEM-<?= str_pad($m['id'], 4, '0', STR_PAD_LEFT) ?></td>
                        <td style="padding: 12px 10px; font-family: 'Cinzel', serif; color: var(--gold);"><?= esc($m['name'] ?? '-') ?></td>
                        <td style="padding: 12px 10px;"><?= esc($m['email'] ?? '-') ?></td>
                        <td style="padding: 12px 10px;"><?= esc($m['phone'] ?? '-') ?></td>
                        <td style="padding: 12px 10px; text-align: center;">
                            <a href="<?= base_url('admin/report/cetak-kartu-member/' . $m['id']) ?>" target="_blank" style="background: #7ec8a0; color: #04060f; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 11px; font-weight: bold;">
                                🪪 Cetak Kartu
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
