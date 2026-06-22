<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="border-bottom: 1px solid rgba(201,168,76,0.3); text-align: left;">
            <th style="padding: 16px; color: var(--gold); font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">No</th>
            <th style="padding: 16px; color: var(--gold); font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">Sampul</th>
            <th style="padding: 16px; color: var(--gold); font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">Judul</th>
            <th style="padding: 16px; color: var(--gold); font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">Penulis</th>
            <th style="padding: 16px; color: var(--gold); font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">Penerbit</th>
            <th style="padding: 16px; color: var(--gold); font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">Tahun</th>
            <th style="padding: 16px; color: var(--gold); font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">ISBN</th>
            <th style="padding: 16px; color: var(--gold); font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">Kategori</th>
            <th style="padding: 16px; color: var(--gold); font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">Stok</th>
            <th style="padding: 16px; color: var(--gold); font-family: 'Raleway', sans-serif; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($books)): ?>
            <?php $i = 1; foreach ($books as $book): ?>
            <tr style="border-bottom: 1px solid rgba(201,168,76,0.1); transition: background 0.3s;">
                <td style="padding: 16px; color: var(--moon-silver);"><?= $i++ ?></td>
                <td style="padding: 16px;">
                    <?php if(!empty($book['cover_image'])): ?>
                        <img src="<?= base_url('uploads/covers/' . $book['cover_image']) ?>" style="width: 50px; height: 75px; object-fit: cover; border: 1px solid rgba(201,168,76,0.3); border-radius: 4px;" onerror="this.style.display='none'">
                    <?php else: ?>
                        <div style="width: 50px; height: 75px; background: rgba(4,6,15,0.5); border: 1px dashed rgba(201,168,76,0.3); display: flex; align-items: center; justify-content: center; font-size: 20px; border-radius: 4px;">📖</div>
                    <?php endif; ?>
                </td>
                <td style="padding: 16px;">
                    <div style="font-family: 'Cinzel', serif; font-size: 15px; font-weight: 600; color: var(--ivory); margin-bottom: 4px;"><?= esc($book['title']) ?></div>
                    <div style="font-size: 12px; color: var(--text-dim); font-style: italic;"><?= esc($book['author']) ?></div>
                </td>
                <td style="padding: 16px; color: var(--moon-silver);">
                    <span style="background: rgba(201,168,76,0.1); border: 1px solid rgba(201,168,76,0.3); padding: 4px 10px; border-radius: 20px; font-size: 11px; color: var(--gold);">
                        <?= esc($book['category_name'] ?? 'Uncategorized') ?>
                    </span>
                </td>
                <td style="padding: 16px;">
                    <?php if ($book['stock_available'] > 0): ?>
                        <span style="color: #7ec8a0; font-weight: bold;"><?= esc($book['stock_available']) ?> Tersedia</span>
                    <?php else: ?>
                        <span style="color: #e07070; font-weight: bold;">Habis</span>
                    <?php endif; ?>
                </td>
                <td style="padding: 16px; display: flex; gap: 8px; align-items: center; height: 100%;">
                    <a href="<?= base_url('admin/edit/book/' . $book['id']) ?>" class="btn-ghost" style="padding: 6px 12px; font-size: 11px; text-decoration: none;">✏️ Edit</a>
                    <a href="<?= base_url('admin/delete/book/' . $book['id']) ?>" class="btn-primary" style="padding: 6px 12px; font-size: 11px; text-decoration: none; background: #963c3c; color: white;" onclick="return confirm('Hapus volume ini?')">🗑️ Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-dim); font-style: italic;">
                    <div style="font-size: 40px; margin-bottom: 10px;">🌌</div> Belum ada volume yang dicatat.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
