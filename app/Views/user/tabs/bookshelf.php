<h3 class="section-title">MY BOOKSHELF</h3>
<div class="favorites-grid">
    <?php if (!empty($books)): ?>
        <?php foreach ($books as $book): ?>
            <div class="fav-card" title="<?= esc($book['title']) ?>">
                <img src="<?= base_url('uploads/covers/' . ($book['cover_image'] ?? 'placeholder.jpg')) ?>" alt="<?= esc($book['title']) ?>" onerror="this.src='https://via.placeholder.com/200x300?text=No+Cover'">
                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.8); color: var(--gold); font-size: 10px; text-align: center; padding: 4px; text-transform: uppercase;">
                    <?= esc($book['status']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; font-size: 13px; grid-column: span 4;">Rak buku kosong.</p>
    <?php endif; ?>
</div>
