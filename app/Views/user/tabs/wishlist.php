<h3 class="section-title">MY WISHLIST</h3>
<div class="favorites-grid">
    <?php if (!empty($wishlist)): ?>
        <?php foreach ($wishlist as $item): ?>
            <div class="fav-card" title="<?= esc($item['title']) ?>">
                <img src="<?= base_url('uploads/covers/' . ($item['cover_image'] ?? 'placeholder.jpg')) ?>" alt="<?= esc($item['title']) ?>" onerror="this.src='https://via.placeholder.com/200x300?text=No+Cover'">
                <button style="position: absolute; top: 4px; right: 4px; background: rgba(0,0,0,0.5); border: none; color: #fff; cursor: pointer; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;" onclick="alert('Fitur hapus wishlist di profil segera hadir!')">
                    <i class="fas fa-times" style="font-size: 10px;"></i>
                </button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; font-size: 13px; grid-column: span 4;">Wishlist kosong.</p>
    <?php endif; ?>
</div>
