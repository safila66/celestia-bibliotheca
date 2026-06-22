<h3 class="section-title">MY REVIEWS</h3>
<div class="activity-feed">
    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $review): ?>
            <div style="display: flex; gap: 16px; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 16px;">
                <div style="flex: 0 0 60px;">
                    <img src="<?= base_url('uploads/covers/' . ($review['cover_image'] ?? 'placeholder.jpg')) ?>" alt="<?= esc($review['title']) ?>" style="width: 100%; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.5);">
                </div>
                <div style="flex: 1;">
                    <div style="font-family: 'Cinzel', serif; font-size: 16px; color: var(--gold); margin-bottom: 4px; display: flex; align-items: center; justify-content: space-between;">
                        <span><?= esc($review['title']) ?></span>
                        <span style="font-size: 12px; color: #f5c518; letter-spacing: 2px;">
                            <?= str_repeat('★', $review['rating']) ?><?= str_repeat('☆', 5 - $review['rating']) ?>
                        </span>
                    </div>
                    <div style="color: #A0A0A0; font-size: 10px; margin-bottom: 8px; font-family: 'Raleway', sans-serif;">
                        Ditulis pada <?= date('d M Y', strtotime($review['created_at'])) ?>
                    </div>
                    <div style="color: #F0EBE0; font-size: 13px; line-height: 1.5;">
                        <?= $review['review_text'] ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; font-size: 13px;">Belum ada ulasan yang ditulis.</p>
    <?php endif; ?>
</div>
