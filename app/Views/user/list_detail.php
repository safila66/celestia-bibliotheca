<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div style="max-width: 1200px; margin: 40px auto; padding: 0 40px;">
    
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px;">
        <div>
            <h1 style="font-family: 'Cinzel', serif; color: var(--gold); margin-bottom: 10px;"><?= esc($list['title']) ?></h1>
            <p style="color: #A0A0A0; font-family: 'EB Garamond', serif; font-size: 16px; margin-bottom: 10px; max-width: 600px;">
                <?= nl2br(esc($list['description'])) ?>
            </p>
            <div style="font-size: 12px; color: #666; font-family: 'Raleway', sans-serif;">
                Dibuat: <?= date('d M Y', strtotime($list['created_at'])) ?>
                <?= $list['is_public'] ? '• <i class="fas fa-globe"></i> Publik' : '• <i class="fas fa-lock"></i> Privat' ?>
            </div>
        </div>
        
        <?php if ($isOwner): ?>
        <form action="<?= base_url('profil/list/delete/' . $list['id']) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus list ini? Semua buku di dalamnya akan ikut terhapus dari list.')">
            <?= csrf_field() ?>
            <button type="submit" style="background: rgba(255,0,0,0.1); border: 1px solid red; color: red; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-family: 'Raleway', sans-serif; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                <i class="fas fa-trash"></i> Hapus List
            </button>
        </form>
        <?php endif; ?>
    </div>

    <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin-bottom: 40px;">

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 30px;">
        <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
                <div style="position: relative; background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.05); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                    
                    <?php if ($isOwner): ?>
                    <form action="<?= base_url('profil/list/remove-book/' . $item['id']) ?>" method="POST" onsubmit="return confirm('Hapus buku ini dari list?')" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                        <?= csrf_field() ?>
                        <button type="submit" style="background: rgba(0,0,0,0.8); border: 1px solid rgba(255,255,255,0.2); color: #fff; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Hapus dari List">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                    <?php endif; ?>

                    <a href="<?= base_url('book/detail/' . $item['book_id']) ?>" style="text-decoration: none; display: block; height: 100%;">
                        <div style="width: 100%; padding-top: 150%; position: relative;">
                            <img src="<?= base_url('uploads/covers/' . $item['cover_image']) ?>" onerror="this.src='https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=300'" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" alt="Cover">
                        </div>
                        <div style="padding: 15px;">
                            <div style="font-family: 'Cinzel', serif; font-size: 14px; color: var(--gold); font-weight: bold; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?= esc($item['book_title']) ?>
                            </div>
                            <div style="font-family: 'Raleway', sans-serif; font-size: 12px; color: #A0A0A0;">
                                <?= esc($item['author']) ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; color: #666; padding: 40px 0;">
                <i class="fas fa-book-open" style="font-size: 48px; opacity: 0.2; margin-bottom: 20px;"></i>
                <p>Belum ada buku di dalam list ini.</p>
                <a href="<?= base_url('koleksi') ?>" style="color: var(--gold); text-decoration: none;">Cari Buku</a>
            </div>
        <?php endif; ?>
    </div>
    
    <div style="margin-top: 60px;">
        <a href="<?= base_url('profil') ?>" style="color: #A0A0A0; text-decoration: none; font-size: 14px;"><i class="fas fa-arrow-left"></i> Kembali ke Profil</a>
    </div>

</div>
<?= $this->endSection() ?>
