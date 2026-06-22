<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
    .page-container {
        padding: 120px 56px 60px;
        max-width: 1000px;
        margin: 0 auto;
        min-height: 80vh;
        font-family: 'Inter', 'Raleway', sans-serif;
    }
    
    /* ── HEADER PROFIL ── */
    .profile-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .profile-left {
        display: flex;
        align-items: center;
        gap: 24px;
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: var(--gold-dim);
        color: var(--deep-navy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Cinzel', serif;
        font-size: 40px;
        font-weight: bold;
        flex-shrink: 0;
        overflow: hidden;
    }
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-info h1 {
        font-family: 'Cinzel', serif;
        font-size: 28px;
        color: #F0EBE0;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .btn-edit-profile {
        background: rgba(255,255,255,0.1);
        color: #EBEBEB;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-family: 'Raleway', sans-serif;
        font-size: 11px;
        font-weight: bold;
        letter-spacing: 0.1em;
        cursor: pointer;
        transition: background 0.2s;
        text-transform: uppercase;
    }
    .btn-edit-profile:hover { background: rgba(255,255,255,0.2); }
    .profile-bio {
        font-size: 14px;
        color: #A0A0A0;
        margin: 8px 0 0 0;
        max-width: 400px;
    }

    .profile-stats {
        display: flex;
        gap: 32px;
    }
    .stat-item {
        text-align: center;
    }
    .stat-num {
        display: block;
        font-family: 'Cinzel', serif;
        font-size: 24px;
        color: #F0EBE0;
        margin-bottom: 4px;
        font-weight: bold;
    }
    .stat-label {
        font-family: 'Raleway', sans-serif;
        font-size: 10px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    /* ── NAVBAR PROFIL ── */
    .profile-nav {
        display: flex;
        gap: 24px;
        margin-bottom: 40px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 12px;
    }
    .profile-nav a {
        color: #A0A0A0;
        text-decoration: none;
        font-size: 14px;
        position: relative;
        padding-bottom: 12px;
        transition: color 0.2s;
    }
    .profile-nav a:hover, .profile-nav a.active {
        color: #F0EBE0;
    }
    .profile-nav a.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #28a745; /* Letterboxd green underline, or change to gold var(--gold) */
    }

    /* ── FAVORITE BOOKS ── */
    .section-title {
        font-family: 'Raleway', sans-serif;
        font-size: 12px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 16px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-edit-favs {
        background: transparent;
        border: none;
        color: #A0A0A0;
        font-size: 10px;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    .btn-edit-favs:hover { color: var(--gold); }
    
    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    .fav-card {
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.5);
        aspect-ratio: 2/3;
        position: relative;
    }
    .fav-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ── MODAL EDIT PROFIL ── */
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.8);
        z-index: 1000;
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden;
        transition: all 0.3s;
    }
    .modal-overlay.show { opacity: 1; visibility: visible; }
    
    .edit-modal {
        background: var(--bg-card);
        border: 1px solid var(--border-gold);
        border-radius: 8px;
        padding: 40px;
        width: 100%; max-width: 800px;
        box-shadow: 0 16px 40px rgba(0,0,0,0.6);
        transform: translateY(20px);
        transition: transform 0.3s;
        max-height: 90vh;
        overflow-y: auto;
    }
    .modal-overlay.show .edit-modal { transform: translateY(0); }
    
    .edit-modal h2 {
        font-family: 'Cinzel', serif;
        color: var(--gold);
        margin: 0 0 24px 0;
        font-size: 24px;
    }
    
    .modal-body {
        display: flex; gap: 40px;
    }
    .modal-col-left {
        flex: 0 0 180px; display: flex; flex-direction: column; align-items: center;
    }
    .modal-col-right {
        flex: 1;
    }
    
    .avatar-upload-preview {
        width: 150px; height: 150px; border-radius: 50%;
        background: var(--gold-dim); color: var(--deep-navy);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Cinzel', serif; font-size: 60px; font-weight: bold;
        position: relative; overflow: hidden; cursor: pointer;
        border: 2px dashed rgba(255,255,255,0.2);
        margin-bottom: 12px;
    }
    .avatar-upload-preview img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .avatar-overlay {
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.6); color: #fff;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.2s; font-family: 'Raleway', sans-serif; font-size: 12px;
    }
    .avatar-upload-preview:hover .avatar-overlay { opacity: 1; }
    
    .form-group { margin-bottom: 20px; }
    .form-label {
        display: block; font-family: 'Raleway', sans-serif;
        font-size: 12px; color: #CCC; margin-bottom: 8px; letter-spacing: 0.05em;
    }
    .form-input {
        width: 100%; padding: 12px 16px;
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 4px; color: #F0EBE0;
        font-family: 'Raleway', sans-serif; font-size: 14px;
        transition: all 0.2s;
    }
    .form-input:focus { outline: none; border-color: var(--gold); }
    
    .modal-actions {
        display: flex; justify-content: flex-end; gap: 16px; margin-top: 32px;
    }
    .btn-cancel {
        background: transparent; color: #CCC; border: none;
        padding: 12px 24px; cursor: pointer; font-family: 'Raleway', sans-serif;
        font-size: 12px; font-weight: bold; letter-spacing: 0.1em; text-transform: uppercase;
    }
    .btn-cancel:hover { color: #FFF; }
    .btn-submit {
        background: linear-gradient(135deg, #A8752A, #E5C06B);
        color: #12100E; border: none; padding: 12px 24px; border-radius: 4px;
        cursor: pointer; font-family: 'Raleway', sans-serif; font-size: 12px;
        font-weight: bold; letter-spacing: 0.1em; transition: filter 0.3s; text-transform: uppercase;
    }
    .btn-submit:hover { filter: brightness(1.1); }

    .btn-submit:hover { filter: brightness(1.1); }

    /* ── MY SERVICES ── */
    .service-grid {
        display: grid; gap: 16px; margin-bottom: 30px;
    }
    .service-card {
        background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.1); padding: 15px 20px; border-radius: 8px;
        display: flex; justify-content: space-between; align-items: center;
    }
    .service-title { font-weight: bold; font-size: 14px; color: var(--gold); margin-bottom: 4px; }
    .service-desc { font-size: 12px; color: #A0A0A0; }
    .service-status {
        font-size: 10px; padding: 4px 10px; border-radius: 12px; font-weight: bold; text-transform: uppercase; border: 1px solid;
    }
    .status-pending { background: rgba(245,158,11,0.1); color: #f59e0b; border-color: #f59e0b; }
    .status-approved { background: rgba(16,185,129,0.1); color: #10b981; border-color: #10b981; }
    .status-confirmed { background: rgba(59,130,246,0.1); color: #3b82f6; border-color: #3b82f6; }
    .status-registered { background: rgba(139,92,246,0.1); color: #8b5cf6; border-color: #8b5cf6; }
    .status-completed { background: rgba(156,163,175,0.1); color: #9ca3af; border-color: #9ca3af; }
    .status-cancelled { background: rgba(239,68,68,0.1); color: #ef4444; border-color: #ef4444; }

    /* ── LIGHT MODE OVERRIDES ── */
    [data-theme="light"] .profile-info h1,
    [data-theme="light"] .stat-num { color: #222; }
    
    [data-theme="light"] .profile-bio,
    [data-theme="light"] .stat-label,
    [data-theme="light"] .profile-nav a,
    [data-theme="light"] .section-title { color: #666; }
    
    [data-theme="light"] .profile-nav a:hover,
    [data-theme="light"] .profile-nav a.active { color: #222; }
    
    [data-theme="light"] .profile-header,
    [data-theme="light"] .profile-nav,
    [data-theme="light"] .section-title { border-color: rgba(0,0,0,0.1); }
    
    [data-theme="light"] .btn-edit-profile { background: rgba(0,0,0,0.05); color: #444; }
    [data-theme="light"] .btn-edit-profile:hover { background: rgba(0,0,0,0.1); }
    
    [data-theme="light"] .edit-modal { background: #fff; border-color: rgba(168,117,42,0.3); }
    [data-theme="light"] .avatar-upload-preview { border-color: rgba(0,0,0,0.2); }
    [data-theme="light"] .form-label { color: #555; }
    [data-theme="light"] .form-input { background: #f8f8f8; border-color: #ddd; color: #333; }
    [data-theme="light"] .btn-cancel { color: #666; }
    [data-theme="light"] .btn-cancel:hover { color: #222; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-container">
    
    <!-- HEADER PROFIL -->
    <div class="profile-header">
        <div class="profile-left">
            <div class="profile-avatar">
                <?php if (!empty($user['photo'])): ?>
                    <img src="<?= base_url('uploads/users/' . esc($user['photo'])) ?>" alt="Profile Photo">
                <?php else: ?>
                    <?= strtoupper(substr(esc($user['name'] ?? 'U'), 0, 1)) ?>
                <?php endif; ?>
            </div>
            <div class="profile-info">
                <h1>
                    <?= esc($user['name']) ?> 
                    <button class="btn-edit-profile" onclick="document.getElementById('editModal').classList.add('show')">Edit Profile</button>
                </h1>
                <p class="profile-bio"><?= esc($user['bio'] ?? 'Bibliophile in training. No bio available yet.') ?></p>
            </div>
        </div>
        <div class="profile-stats">
            <div class="stat-item">
                <span class="stat-num"><?= esc($booksReadCount ?? 0) ?></span>
                <span class="stat-label">BOOKS READ</span>
            </div>
            <div class="stat-item">
                <span class="stat-num"><?= esc($stats['active'] ?? 0) ?></span>
                <span class="stat-label">THIS YEAR</span>
            </div>
            <div class="stat-item">
                <span class="stat-num"><?= esc($wishlistCount ?? 0) ?></span>
                <span class="stat-label">WISHLIST</span>
            </div>
            <div class="stat-item">
                <span class="stat-num"><?= esc($followingCount ?? 0) ?></span>
                <span class="stat-label">FOLLOWING</span>
            </div>
            <div class="stat-item">
                <span class="stat-num"><?= esc($followersCount ?? 0) ?></span>
                <span class="stat-label">FOLLOWERS</span>
            </div>
        </div>
    </div>

    <!-- NAVBAR PROFIL -->
    <div class="profile-nav" id="profileTabs">
        <a href="#" data-tab="profile" class="active">Profile</a>
        <a href="#" data-tab="tickets">Tiket & Booking</a>
        <a href="#" data-tab="activity">Activity</a>
        <a href="#" data-tab="books">Books</a>
        <a href="#" data-tab="bookshelf">My Bookshelf</a>
        <a href="#" data-tab="diary">Diary</a>
        <a href="#" data-tab="reviews">Reviews</a>
        <a href="#" data-tab="wishlist">Wishlist</a>
        <a href="#" data-tab="lists">Lists</a>
        <a href="#" data-tab="likes">Likes</a>
        <a href="#" data-tab="my-journal">My Journal</a>
    </div>

    <!-- TAB CONTENT CONTAINER -->
    <div id="profile-content">
        <!-- Default Content loaded server-side for fast initial load -->
        <?= view('user/tabs/profile') ?>
    </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('#profileTabs a');
            const contentContainer = document.getElementById('profile-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');

                    const tabName = this.getAttribute('data-tab');
                    
                    // Show loading state
                    contentContainer.innerHTML = '<div style="text-align: center; padding: 40px; color: #888; font-family: \'Raleway\', sans-serif;"><i class="fas fa-spinner fa-spin" style="margin-right: 10px; font-size: 20px;"></i> Memuat data...</div>';

                    // Fetch tab content
                    fetch('<?= base_url('profil/tab/') ?>' + tabName, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.text();
                        })
                        .then(html => {
                            contentContainer.innerHTML = html;
                            // Re-evaluate scripts in the loaded HTML if needed (e.g. showQRIS)
                            const scripts = contentContainer.querySelectorAll('script');
                            scripts.forEach(script => {
                                const newScript = document.createElement('script');
                                newScript.textContent = script.textContent;
                                document.body.appendChild(newScript);
                                if (document.body.contains(newScript)) {
                                    document.body.removeChild(newScript);
                                }
                            });
                            // Re-init scripts if needed
                        })
                        .catch(err => {
                            console.error("Tab fetch error:", err);
                            contentContainer.innerHTML = '<div style="color: #e07070; padding: 20px;">Gagal memuat tab. Details: ' + err.message + '</div>';
                        });
                });
            });
        });
    </script>



    </div> <!-- end page-container -->
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Universal Ticket QR Modal -->
<div class="modal-overlay" id="ticketQrModal" onclick="closeTicketQR(event)">
    <div class="modal-content" onclick="event.stopPropagation()" style="background: var(--deep-navy, #0D1535); padding: 30px; border-radius: 8px; border: 1px solid var(--gold, #C9A84C); text-align: center; max-width: 300px; color: #fff;">
        <h3 style="margin-top: 0; color: var(--gold, #C9A84C); font-family: 'Cinzel', serif;">Scan Tiket</h3>
        <p style="font-size: 14px; color: #ddd;" id="ticketQrSubtitle">Silakan tunjukkan QR ini ke Admin.</p>
        <div style="width: 200px; height: 200px; background: #fff; margin: 20px auto; border-radius: 8px; display: flex; align-items: center; justify-content: center; padding: 10px;">
            <img src="" id="ticketQrImage" style="width:100%; height:100%;">
        </div>
        <button onclick="closeTicketQR()" style="margin-top: 10px; background: transparent; border: 1px solid #ddd; color: #ddd; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Tutup</button>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal-overlay" id="editModal" onclick="this.classList.remove('show')">
    <div class="edit-modal">
        <h2>Profile Settings</h2>
        <div id="ajaxAlert" style="display:none; padding: 10px; border-radius: 4px; margin-bottom: 16px; font-family:'Raleway', sans-serif; font-size:12px;"></div>
        <form id="profileForm" action="<?= base_url('profil') ?>" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="modal-col-left">
                    <div class="avatar-upload-preview" onclick="document.getElementById('photoInput').click()">
                        <?php if (!empty($user['photo'])): ?>
                            <img id="avatarPreview" src="<?= base_url('uploads/users/' . esc($user['photo'])) ?>">
                        <?php else: ?>
                            <span id="avatarPreviewInitials"><?= strtoupper(substr(esc($user['name'] ?? 'U'), 0, 1)) ?></span>
                            <img id="avatarPreview" style="display:none;" src="">
                        <?php endif; ?>
                        
                        <div class="avatar-overlay">
                            <span style="font-size: 24px; margin-bottom: 4px;">✎</span>
                            <span>Choose photo</span>
                        </div>
                    </div>
                    <input type="file" id="photoInput" name="photo" style="display: none;" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(this)">
                    <div style="font-size:10px; color:#aaa; text-align:center; line-height:1.4;">Rasio 1:1 persegi<br>Maksimal 2MB</div>
                </div>
                
                <div class="modal-col-right">
                    <div class="form-group">
                        <label class="form-label">Given Name</label>
                        <input type="text" name="name" class="form-input" value="<?= esc($user['name'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-input" value="<?= esc($user['email'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" class="form-input" rows="3" placeholder="Tell us about yourself..."><?= esc($user['bio'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">New Password (Optional)</label>
                        <input type="password" name="password" class="form-input" placeholder="Leave blank to keep current password">
                    </div>
                </div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="document.getElementById('editModal').classList.remove('show')">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function showTicketQR(scanUrl, subtitle) {
        document.getElementById('ticketQrModal').classList.add('show');
        document.getElementById('ticketQrSubtitle').innerText = subtitle;
        document.getElementById('ticketQrImage').src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(scanUrl)}`;
    }

    function closeTicketQR(event) {
        if (event && event.target.id !== 'ticketQrModal') return;
        document.getElementById('ticketQrModal').classList.remove('show');
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.getElementById('avatarPreview');
                let initials = document.getElementById('avatarPreviewInitials');
                
                if (img) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                if (initials) initials.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Menutup modal jika area luar form diklik
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('show');
            document.getElementById('ajaxAlert').style.display = 'none';
        }
    });

    // Handle AJAX Form Submission
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Mencegah reload halaman
        
        let form = this;
        let formData = new FormData(form);
        let alertBox = document.getElementById('ajaxAlert');
        let btnSubmit = form.querySelector('.btn-submit');
        
        btnSubmit.disabled = true;
        btnSubmit.innerText = 'Saving...';
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            btnSubmit.disabled = false;
            btnSubmit.innerText = 'Save Changes';
            
            if (data.success) {
                // Tampilkan pesan sukses
                alertBox.style.display = 'block';
                alertBox.style.backgroundColor = 'rgba(40, 167, 69, 0.2)';
                alertBox.style.color = '#28a745';
                alertBox.style.border = '1px solid #28a745';
                alertBox.innerText = data.message;
                
                // Update elemen di halaman profil (live update)
                if (data.user.name) {
                    // Update H1 Name (tetap mempertahankan tombol Edit Profile di dalamnya)
                    let h1 = document.querySelector('.profile-info h1');
                    h1.innerHTML = data.user.name + ' <button class="btn-edit-profile" onclick="document.getElementById(\'editModal\').classList.add(\'show\')">Edit Profile</button>';
                    
                    // Update initial/image di Avatar
                    let avatar = document.querySelector('.profile-avatar');
                    if (avatar) {
                        if (data.user.photo) {
                            avatar.innerHTML = `<img src="<?= base_url('uploads/users') ?>/${data.user.photo}" alt="Profile Photo">`;
                        } else if (!avatar.querySelector('img')) {
                            avatar.innerText = data.user.name.charAt(0).toUpperCase();
                        }
                    }
                }
                
                if (data.user.bio !== undefined) {
                    let bioP = document.querySelector('.profile-bio');
                    bioP.innerText = data.user.bio ? data.user.bio : 'Bibliophile in training. No bio available yet.';
                }
                
                // Kosongkan form password dan file
                form.querySelector('input[name="password"]').value = '';
                form.querySelector('input[name="photo"]').value = '';
                
                // Sembunyikan alert & modal setelah beberapa detik
                setTimeout(() => {
                    alertBox.style.display = 'none';
                    document.getElementById('editModal').classList.remove('show');
                }, 1500);
            } else {
                // Tampilkan error
                alertBox.style.display = 'block';
                alertBox.style.backgroundColor = 'rgba(220, 53, 69, 0.2)';
                alertBox.style.color = '#dc3545';
                alertBox.style.border = '1px solid #dc3545';
                
                let errorHtml = '<ul>';
                for (const key in data.errors) {
                    errorHtml += `<li>${data.errors[key]}</li>`;
                }
                errorHtml += '</ul>';
                alertBox.innerHTML = errorHtml;
            }
        })
        .catch(error => {
            btnSubmit.disabled = false;
            btnSubmit.innerText = 'Save Changes';
            alertBox.style.display = 'block';
            alertBox.style.backgroundColor = 'rgba(220, 53, 69, 0.2)';
            alertBox.style.color = '#dc3545';
            alertBox.style.border = '1px solid #dc3545';
            alertBox.innerText = 'Terjadi kesalahan sistem.';
        });
    });
</script>

<?= $this->endSection() ?>
