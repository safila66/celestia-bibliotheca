<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
    <h3 class="section-title" style="margin-bottom: 0; border: none; padding: 0;">MY JOURNAL</h3>
    <button style="background: var(--gold); color: var(--deep-navy); border: none; padding: 6px 16px; border-radius: 4px; font-family: 'Raleway', sans-serif; font-size: 11px; font-weight: bold; cursor: pointer; text-transform: uppercase; letter-spacing: 0.1em; transition: filter 0.2s;" onclick="document.getElementById('writeJournalModal').classList.add('show')" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='none'">+ Write Article</button>
</div>
<hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin-bottom: 24px;">

<div style="display: flex; flex-direction: column; gap: 24px;">
    <?php if (!empty($myJournals)): ?>
        <?php foreach ($myJournals as $journal): ?>
            <div style="display: flex; gap: 20px; border: 1px solid rgba(255,255,255,0.05); border-radius: 8px; overflow: hidden; background: rgba(0,0,0,0.2);">
                <div style="flex: 0 0 200px; height: 140px;">
                    <img src="<?= base_url('uploads/journals/' . ($journal['cover_image'] ?? 'placeholder.jpg')) ?>" alt="<?= esc($journal['title']) ?>" onerror="this.src='https://via.placeholder.com/300x200?text=No+Cover'" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="flex: 1; padding: 16px;">
                    <h4 style="font-family: 'Cinzel', serif; font-size: 20px; color: var(--gold); margin: 0 0 8px 0;"><?= esc($journal['title']) ?></h4>
                    <p style="color: #A0A0A0; font-size: 13px; font-family: 'Raleway', sans-serif; margin: 0 0 12px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                        <?= esc($journal['excerpt']) ?>
                    </p>
                    <div style="font-size: 11px; color: #666; font-family: 'Raleway', sans-serif; display: flex; justify-content: space-between; align-items: center;">
                        <span>Diterbitkan <?= date('d M Y', strtotime($journal['created_at'])) ?></span>
                        <a href="<?= base_url('mini-journalism/' . $journal['id']) ?>" style="color: var(--gold); text-decoration: none;">Baca Selengkapnya &rarr;</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; font-size: 13px; text-align: center; padding: 40px 0;">Belum ada artikel yang kamu tulis. Mulai bagikan pemikiranmu!</p>
    <?php endif; ?>
</div>

<!-- Write Journal Modal -->
<div class="modal-overlay" id="writeJournalModal">
    <div class="edit-modal">
        <h2>Write New Article</h2>
        <form action="<?= base_url('profil/submit-journal') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label">Article Title</label>
                <input type="text" name="title" class="form-input" required placeholder="A Catchy Substack-like Title...">
            </div>
            <div class="form-group">
                <label class="form-label">Cover Image (Optional)</label>
                <input type="file" name="cover_image" class="form-input" accept="image/*">
            </div>
            <div class="form-group">
                <label class="form-label">Excerpt (Short description)</label>
                <textarea name="excerpt" class="form-input" rows="2" required placeholder="A brief summary of your article..."></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Content</label>
                <textarea name="content" class="form-input" rows="10" required placeholder="Write your full article here. You can use markdown or plain text." style="font-family: 'Inter', sans-serif; line-height: 1.6;"></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="document.getElementById('writeJournalModal').classList.remove('show')">Cancel</button>
                <button type="submit" class="btn-submit">Publish Article</button>
            </div>
        </form>
    </div>
</div>
