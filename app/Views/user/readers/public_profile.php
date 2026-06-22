<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
    .profile-container {
        padding: 120px 56px 60px;
        max-width: 1000px;
        margin: 0 auto;
        min-height: 80vh;
    }
    .profile-header {
        display: flex;
        align-items: center;
        gap: 32px;
        margin-bottom: 48px;
        flex-wrap: wrap;
    }
    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border-gold);
    }
    .profile-info {
        flex: 1;
    }
    .profile-name {
        font-family: 'Cinzel', serif;
        font-size: 32px;
        color: var(--gold);
        margin: 0 0 8px 0;
    }
    .profile-bio {
        font-family: 'Raleway', sans-serif;
        font-size: 14px;
        color: #A0A0A0;
        margin-bottom: 16px;
    }
    
    .stats-container {
        display: flex;
        gap: 32px;
        flex-wrap: wrap;
        margin-top: 16px;
    }
    .stat-item {
        text-align: center;
    }
    .stat-value {
        font-family: 'Cinzel', serif;
        font-size: 24px;
        color: var(--text);
        font-weight: bold;
    }
    .stat-label {
        font-family: 'Raleway', sans-serif;
        font-size: 11px;
        color: #A0A0A0;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-top: 4px;
    }
    
    .btn-follow {
        padding: 10px 24px;
        border-radius: 20px;
        font-family: 'Raleway', sans-serif;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
        border: 1px solid var(--gold);
        display: inline-block;
        margin-top: 16px;
    }
    .btn-follow.following {
        background: transparent;
        color: var(--gold);
    }
    .btn-follow.following:hover {
        background: rgba(201, 168, 76, 0.1);
        border-color: #ff4757;
        color: #ff4757;
    }
    .btn-follow.not-following {
        background: var(--gold);
        color: #12100E;
    }
    .btn-follow.not-following:hover {
        background: var(--gold-light);
        box-shadow: 0 0 10px rgba(201, 168, 76, 0.3);
    }
    
    .section-title {
        font-family: 'Cinzel', serif;
        font-size: 20px;
        color: var(--gold-light);
        margin-bottom: 24px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 12px;
    }
    
    [data-theme="light"] .profile-container { color: #333; }
    [data-theme="light"] .profile-bio, [data-theme="light"] .stat-label { color: #666; }
    [data-theme="light"] .section-title { border-color: rgba(0,0,0,0.1); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="profile-container">
    <div class="profile-header">
        <img src="<?= base_url('uploads/profiles/' . ($user['photo'] ?? 'default.jpg')) ?>" class="profile-photo" alt="<?= esc($user['name']) ?>" onerror="this.src='https://via.placeholder.com/150?text=<?= strtoupper(substr($user['name'], 0, 1)) ?>'">
        
        <div class="profile-info">
            <h1 class="profile-name"><?= esc($user['name']) ?></h1>
            <div class="profile-bio"><?= esc($user['bio'] ?? 'No bio provided.') ?></div>
            
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-value"><?= $stats['read'] ?></div>
                    <div class="stat-label">Books Read</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?= $stats['this_year'] ?></div>
                    <div class="stat-label">This Year</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?= $stats['wishlist'] ?></div>
                    <div class="stat-label">Wishlist</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="followersCount"><?= $stats['followers'] ?></div>
                    <div class="stat-label">Followers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?= $stats['following'] ?></div>
                    <div class="stat-label">Following</div>
                </div>
            </div>
            
            <?php if ($currentUserId && $currentUserId != $user['id']): ?>
                <button class="btn-follow <?= $isFollowing ? 'following' : 'not-following' ?>" 
                        onclick="toggleFollow(this, <?= $user['id'] ?>)">
                    <?= $isFollowing ? 'Following' : 'Follow' ?>
                </button>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="reviews-section">
        <h2 class="section-title">Recent Reviews</h2>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div style="display: flex; gap: 16px; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 16px;">
                    <div style="flex: 0 0 60px;">
                        <a href="<?= base_url('buku/' . $review['book_id']) ?>">
                            <img src="<?= base_url('uploads/covers/' . ($review['cover_image'] ?? 'placeholder.jpg')) ?>" alt="<?= esc($review['title']) ?>" style="width: 100%; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.5);">
                        </a>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-family: 'Cinzel', serif; font-size: 16px; color: var(--gold); margin-bottom: 4px; display: flex; align-items: center; justify-content: space-between;">
                            <a href="<?= base_url('buku/' . $review['book_id']) ?>" style="color: inherit; text-decoration: none;"><?= esc($review['title']) ?></a>
                            <span style="font-size: 12px; color: #f5c518; letter-spacing: 2px;">
                                <?= str_repeat('★', $review['rating']) ?><?= str_repeat('☆', 5 - $review['rating']) ?>
                            </span>
                        </div>
                        <div style="color: #A0A0A0; font-size: 10px; margin-bottom: 8px; font-family: 'Raleway', sans-serif;">
                            Ditulis pada <?= date('d M Y', strtotime($review['created_at'])) ?>
                        </div>
                        <div style="color: #F0EBE0; font-size: 13px; line-height: 1.5;">
                            <!-- Removed esc() here to render quill html properly -->
                            <?= $review['review_text'] ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: #666; font-size: 13px;">Belum ada ulasan yang ditulis.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function toggleFollow(btn, userId) {
    if(!<?= session()->get('user_id') ? 'true' : 'false' ?>) {
        window.location.href = '/login';
        return;
    }

    fetch('/u/follow/' + userId, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            let followersCountEl = document.getElementById('followersCount');
            let currentCount = parseInt(followersCountEl.innerText) || 0;
            
            if(data.isFollowing) {
                btn.className = 'btn-follow following';
                btn.innerText = 'Following';
                followersCountEl.innerText = currentCount + 1;
            } else {
                btn.className = 'btn-follow not-following';
                btn.innerText = 'Follow';
                followersCountEl.innerText = currentCount - 1;
            }
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred.');
    });
}
</script>
<?= $this->endSection() ?>
