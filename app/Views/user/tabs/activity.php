<h3 class="section-title">RECENT ACTIVITY</h3>
<div class="activity-feed">
    <?php if (!empty($activities)): ?>
        <?php foreach ($activities as $act): ?>
            <div style="display: flex; gap: 16px; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 16px;">
                <div style="flex: 0 0 60px;">
                    <img src="<?= base_url('uploads/covers/' . ($act['cover_image'] ?? 'placeholder.jpg')) ?>" alt="<?= esc($act['title']) ?>" style="width: 100%; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.5);">
                </div>
                <div style="flex: 1;">
                    <div style="color: #A0A0A0; font-size: 12px; margin-bottom: 4px;">
                        <?php if ($act['type'] === 'review'): ?>
                            Menulis ulasan pada <?= date('d M Y', strtotime($act['created_at'])) ?>
                        <?php else: ?>
                            Mengubah status buku menjadi <strong><?= esc($act['status']) ?></strong> pada <?= date('d M Y', strtotime($act['updated_at'])) ?>
                        <?php endif; ?>
                    </div>
                    <div style="font-family: 'Cinzel', serif; font-size: 16px; color: var(--gold); margin-bottom: 4px;">
                        <?= esc($act['title']) ?>
                    </div>
                    <?php if ($act['type'] === 'review'): ?>
                        <div style="color: #F0EBE0; font-size: 13px; font-style: italic;">
                            "<?= $act['review_text'] ?>"
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; font-size: 13px;">Belum ada aktivitas terbaru.</p>
    <?php endif; ?>
</div>
