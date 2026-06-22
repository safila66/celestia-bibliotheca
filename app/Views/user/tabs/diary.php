<h3 class="section-title">READING DIARY</h3>
<div class="activity-feed">
    <?php if (!empty($diary)): ?>
        <?php foreach ($diary as $log): ?>
            <div style="display: flex; gap: 16px; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 16px;">
                <div style="flex: 0 0 40px;">
                    <div style="background: rgba(255,255,255,0.1); border-radius: 4px; padding: 4px; text-align: center; color: var(--gold); font-family: 'Cinzel', serif; font-size: 14px; font-weight: bold;">
                        <?= date('d', strtotime($log['updated_at'])) ?><br>
                        <span style="font-size: 10px; font-family: 'Raleway', sans-serif; color: #A0A0A0;"><?= date('M Y', strtotime($log['updated_at'])) ?></span>
                    </div>
                </div>
                <div style="flex: 1;">
                    <div style="font-family: 'Cinzel', serif; font-size: 16px; color: #F0EBE0; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                        <?= esc($log['title']) ?>
                        <?php if(isset($log['is_reread']) && $log['is_reread']): ?>
                            <span style="font-size: 10px; background: rgba(168,117,42,0.2); color: var(--gold); padding: 2px 6px; border-radius: 4px; font-family: 'Raleway', sans-serif;">Re-read</span>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($log['notes']) && !empty($log['notes'])): ?>
                        <div style="color: #A0A0A0; font-size: 13px; font-style: italic; background: rgba(0,0,0,0.2); padding: 8px; border-left: 2px solid var(--gold);">
                            <?= esc($log['notes']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div style="flex: 0 0 60px;">
                    <img src="<?= base_url('uploads/covers/' . ($log['cover_image'] ?? 'placeholder.jpg')) ?>" alt="<?= esc($log['title']) ?>" style="width: 100%; border-radius: 4px;">
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; font-size: 13px;">Belum ada catatan membaca.</p>
    <?php endif; ?>
</div>
