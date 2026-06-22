<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-family: 'Cinzel', serif; color: #e07070; font-weight: 400; letter-spacing: 0.05em;">Tong Sampah Volume</h2>
    <div style="display: flex; gap: 10px;">
        <a href="<?= base_url('admin/books') ?>" class="btn-ghost" style="padding: 8px 16px; text-decoration: none; border: 1px solid var(--gold); color: var(--gold);">⬅ Kembali ke Koleksi Utama</a>
    </div>
</div>

<div class="card" style="background: var(--deep-navy); padding: 20px; border-radius: 8px; border: 1px solid rgba(224,112,112,0.3);">
    <div class="table-wrap" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--ivory);">
            
            <thead>
                <tr style="border-bottom: 2px solid #e07070; background: rgba(224,112,112,0.1);">
                    <th style="padding: 12px 16px; font-family: 'Raleway', sans-serif; font-size: 12px; color: #e07070; text-transform: uppercase;">No</th>
                    <th style="padding: 12px 16px; font-family: 'Raleway', sans-serif; font-size: 12px; color: #e07070; text-transform: uppercase;">Sampul</th>
                    <th style="padding: 12px 16px; font-family: 'Raleway', sans-serif; font-size: 12px; color: #e07070; text-transform: uppercase;">Judul & Penulis</th>
                    <th style="padding: 12px 16px; font-family: 'Raleway', sans-serif; font-size: 12px; color: #e07070; text-transform: uppercase;">Waktu Dihapus</th>
                    <th style="padding: 12px 16px; font-family: 'Raleway', sans-serif; font-size: 12px; color: #e07070; text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            
            <tbody>
                <?php if (!empty($books)): ?>
                    <?php $i = 1; foreach ($books as $book): ?>
                    <tr style="border-bottom: 1px solid rgba(224,112,112,0.1); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 16px; color: var(--moon-silver);"><?= $i++ ?></td>
                        
                        <td style="padding: 16px;">
                            <?php if(!empty($book['cover_image'])): ?>
                                <img src="<?= base_url('uploads/covers/' . $book['cover_image']) ?>" alt="Cover" style="width: 45px; height: 65px; object-fit: cover; border-radius: 4px; filter: grayscale(100%); opacity: 0.5;">
                            <?php else: ?>
                                <div style="width: 45px; height: 65px; background: rgba(0,0,0,0.5); border: 1px dashed #e07070; display: flex; align-items: center; justify-content: center; font-size: 20px; border-radius: 4px; opacity: 0.5;">📖</div>
                            <?php endif; ?>
                        </td>

                        <td style="padding: 16px;">
                            <div style="font-family: 'Cinzel', serif; font-size: 15px; font-weight: 600; color: var(--moon-silver); margin-bottom: 4px; text-decoration: line-through;"><?= esc($book['title']) ?></div>
                            <div style="font-size: 12px; color: var(--text-dim); font-style: italic;"><?= esc($book['author']) ?></div>
                        </td>

                        <td style="padding: 16px; color: #e07070; font-size: 13px;">
                            <?= date('d M Y, H:i', strtotime($book['deleted_at'])) ?>
                        </td>

                        <td style="padding: 16px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="<?= base_url('admin/restore/book/' . $book['id']) ?>" style="background: #7ec8a0; color: #04060f; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 11px; font-weight: bold;">✨ Restore</a>
                                
                                <a href="<?= base_url('admin/purge/book/' . $book['id']) ?>" style="background: transparent; border: 1px solid #e07070; color: #e07070; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 11px; font-weight: bold;" onclick="return confirm('Peringatan: Tindakan ini tidak dapat dibatalkan. Hapus volume ini selamanya?')">🔥 Hapus Permanen</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-dim); font-style: italic;">
                            <div style="font-size: 40px; margin-bottom: 10px; filter: grayscale(100%); opacity: 0.5;">🗑️</div>
                            Tidak ada volume di tong sampah. Arsip tetap suci.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
