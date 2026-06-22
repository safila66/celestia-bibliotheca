<h3 class="section-title">BOOKS READ</h3>
<div class="favorites-grid">
    <?php if (!empty($books)): ?>
        <?php foreach ($books as $book): ?>
            <div class="fav-card" title="<?= esc($book['title']) ?>">
                <img src="<?= base_url('uploads/covers/' . ($book['cover_image'] ?? 'placeholder.jpg')) ?>" alt="<?= esc($book['title']) ?>" onerror="this.src='https://via.placeholder.com/200x300?text=No+Cover'">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; font-size: 13px; grid-column: span 4;">Belum ada buku yang diselesaikan.</p>
    <?php endif; ?>
</div>
