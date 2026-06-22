<h3 class="section-title">LIKES (FAVORITE BOOKS)</h3>
<div class="favorites-grid">
    <?php if (!empty($likes)): ?>
        <?php foreach ($likes as $book): ?>
            <div class="fav-card" title="<?= esc($book['title']) ?>">
                <img src="<?= base_url('uploads/covers/' . ($book['cover_image'] ?? 'placeholder.jpg')) ?>" alt="<?= esc($book['title']) ?>" onerror="this.src='https://via.placeholder.com/200x300?text=No+Cover'">
                <div style="position: absolute; top: 8px; right: 8px; color: #ef4444; text-shadow: 0 0 4px rgba(0,0,0,0.8);">
                    <i class="fas fa-heart"></i>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; font-size: 13px; grid-column: span 4;">Belum ada buku yang disukai.</p>
    <?php endif; ?>
</div>
