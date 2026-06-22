<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
    .readers-container {
        padding: 120px 56px 60px;
        max-width: 1200px;
        margin: 0 auto;
        min-height: 80vh;
    }
    .page-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .page-title {
        font-family: 'Cinzel', serif;
        font-size: 36px;
        color: var(--gold);
        letter-spacing: 0.1em;
        margin-bottom: 16px;
    }
    .search-bar {
        max-width: 500px;
        margin: 0 auto 40px;
        display: flex;
        gap: 12px;
    }
    .search-input {
        flex: 1;
        padding: 12px 20px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-gold);
        border-radius: 30px;
        color: var(--text);
        font-family: 'Raleway', sans-serif;
        font-size: 15px;
    }
    .search-input:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--gold);
    }
    .search-btn {
        padding: 12px 24px;
        background: var(--gold);
        color: #12100E;
        border: none;
        border-radius: 30px;
        font-family: 'Cinzel', serif;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
    }
    .search-btn:hover {
        background: var(--gold-light);
        box-shadow: 0 0 15px rgba(201, 168, 76, 0.4);
    }
    
    .users-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }
    .user-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .user-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 4px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
        opacity: 0;
        transition: opacity 0.3s;
    }
    .user-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(201, 168, 76, 0.3);
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    }
    .user-card:hover::before {
        opacity: 1;
    }
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 16px;
        border: 2px solid var(--border-gold);
    }
    .user-name {
        font-family: 'Cinzel', serif;
        font-size: 18px;
        color: var(--gold);
        margin-bottom: 8px;
        text-decoration: none;
        display: block;
    }
    .user-name:hover {
        color: var(--gold-light);
    }
    .user-bio {
        font-family: 'Raleway', sans-serif;
        font-size: 13px;
        color: #A0A0A0;
        margin-bottom: 20px;
        min-height: 40px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .btn-follow {
        padding: 8px 20px;
        border-radius: 20px;
        font-family: 'Raleway', sans-serif;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        border: 1px solid var(--gold);
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
    
    [data-theme="light"] .readers-container { color: #333; }
    [data-theme="light"] .user-card { background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-color: rgba(0,0,0,0.1); }
    [data-theme="light"] .search-input { background: #fff; color: #333; border-color: #ccc; }
    [data-theme="light"] .user-bio { color: #666; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="readers-container">
    <div class="page-header">
        <h1 class="page-title">Readers Community</h1>
        <p style="color: #A0A0A0; font-family: 'Raleway', sans-serif;">Connect with other readers, share reviews, and discover new books.</p>
    </div>

    <form class="search-bar" action="<?= base_url('readers') ?>" method="get">
        <input type="text" name="q" class="search-input" placeholder="Search by name..." value="<?= esc($searchQuery ?? '') ?>">
        <button type="submit" class="search-btn">Search</button>
    </form>

    <div class="users-grid">
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <div class="user-card">
                    <a href="<?= base_url('u/' . $user['id']) ?>">
                        <img src="<?= base_url('uploads/profiles/' . ($user['photo'] ?? 'default.jpg')) ?>" class="user-avatar" alt="<?= esc($user['name']) ?>" onerror="this.src='https://via.placeholder.com/80?text=<?= strtoupper(substr($user['name'], 0, 1)) ?>'">
                    </a>
                    <a href="<?= base_url('u/' . $user['id']) ?>" class="user-name"><?= esc($user['name']) ?></a>
                    <p class="user-bio"><?= esc($user['bio'] ?? 'No bio provided.') ?></p>
                    
                    <?php if (session()->get('user_id') != $user['id']): ?>
                        <button class="btn-follow <?= $user['is_following'] ? 'following' : 'not-following' ?>" 
                                onclick="toggleFollow(this, <?= $user['id'] ?>)">
                            <?= $user['is_following'] ? 'Following' : 'Follow' ?>
                        </button>
                    <?php else: ?>
                        <div style="font-size:12px; color:#A0A0A0; margin-top:8px;">You</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; color: #888; font-family: 'Raleway', sans-serif; padding: 40px;">
                No readers found.
            </div>
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
            if(data.isFollowing) {
                btn.className = 'btn-follow following';
                btn.innerText = 'Following';
            } else {
                btn.className = 'btn-follow not-following';
                btn.innerText = 'Follow';
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
