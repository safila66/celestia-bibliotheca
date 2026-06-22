<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
/* CSS for Sidebar Layout and Service Cards */
.services-layout { 
    display: flex; gap: 30px; margin-top: 20px; 
    align-items: flex-start;
}
.services-sidebar { 
    width: 320px; flex-shrink: 0; display: flex; flex-direction: column; gap: 15px; 
    position: sticky; top: 100px;
}
.services-content { 
    flex-grow: 1; background: rgba(0,0,0,0.2); padding: 0; border-radius: 8px; border: 1px solid rgba(201,168,76,0.2); 
    overflow: hidden;
}
[data-theme="light"] .services-content { background: rgba(255,255,255,0.7); }

/* Sidebar Cards (Similar to volume cards) */
.svc-nav-card {
    display: flex; align-items: center; gap: 20px; padding: 20px;
    background: rgba(4,6,15,0.4); border: 1px solid rgba(201,168,76,0.15);
    border-radius: 8px; cursor: pointer; transition: all 0.3s;
    text-decoration: none; color: inherit;
    position: relative; overflow: hidden;
}
[data-theme="light"] .svc-nav-card { background: #fff; }
.svc-nav-card:hover, .svc-nav-card.active {
    background: rgba(201,168,76,0.1); border-color: var(--gold);
    transform: translateY(-2px);
}
.svc-nav-card.active::before {
    content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: var(--gold);
}
.svc-nav-icon { 
    font-size: 32px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;
    background: rgba(201,168,76,0.1); border-radius: 50%;
}
.svc-info { display: flex; flex-direction: column; gap: 4px; }
.svc-nav-title { font-family: 'Cinzel', serif; font-size: 18px; color: var(--gold); font-weight: bold; }
.svc-desc { font-size: 12px; color: var(--text-dim); line-height: 1.4; }

/* Tab contents */
.service-tab-content { display: none; padding: 30px; }
.service-tab-content.active { display: block; animation: fadeIn 0.4s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

/* Ensure internal partial styles don't conflict, reset some containers */
.service-tab-content .container { max-width: 100%; margin: 0; padding: 0; }
.service-tab-content .service-header { text-align: left; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid rgba(201,168,76,0.2); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container" style="padding-top: 100px; padding-bottom: 100px; max-width: 1300px;">
    
    <div class="services-layout">
        <!-- Sidebar -->
        <div class="services-sidebar">
            <div class="svc-nav-card active" onclick="showService('delivery', this)" data-tab="delivery">
                <div class="svc-nav-icon">🚚</div>
                <div class="svc-info">
                    <div class="svc-nav-title">Book Delivery</div>
                    <div class="svc-desc">Pesan buku fisik langsung ke alamat Anda dengan pelacakan waktu nyata.</div>
                </div>
            </div>
            
            <div class="svc-nav-card" onclick="showService('room', this)" data-tab="room">
                <div class="svc-nav-icon">🏛️</div>
                <div class="svc-info">
                    <div class="svc-nav-title">Room Booking</div>
                    <div class="svc-desc">Reservasi ruang baca dan diskusi eksklusif hingga 24 jam.</div>
                </div>
            </div>
            
            <div class="svc-nav-card" onclick="showService('referensi', this)" data-tab="referensi">
                <div class="svc-nav-icon">🔍</div>
                <div class="svc-info">
                    <div class="svc-nav-title">Layanan Referensi</div>
                    <div class="svc-desc">Akses literatur spesialis dan ensiklopedia tingkat lanjut.</div>
                </div>
            </div>

            <div class="svc-nav-card" onclick="showService('sitasi', this)" data-tab="sitasi">
                <div class="svc-nav-icon">📝</div>
                <div class="svc-info">
                    <div class="svc-nav-title">Panduan Sitasi</div>
                    <div class="svc-desc">Cek gaya kutipan dan level AI karya tulismu secara presisi.</div>
                </div>
            </div>

            <div class="svc-nav-card" onclick="showService('mendeley', this)" data-tab="mendeley">
                <div class="svc-nav-icon">📖</div>
                <div class="svc-info">
                    <div class="svc-nav-title">Mendeley Class</div>
                    <div class="svc-desc">Kelas khusus manajemen referensi dengan jadwal cerdas.</div>
                </div>
            </div>

            <div class="svc-nav-card" onclick="showService('konsultasi', this)" data-tab="konsultasi">
                <div class="svc-nav-icon">💬</div>
                <div class="svc-info">
                    <div class="svc-nav-title">Konsultasi Umum</div>
                    <div class="svc-desc">Bimbingan dasar penelusuran sumber referensi yang relevan.</div>
                </div>
            </div>

            <div class="svc-nav-card" onclick="showService('language', this)" data-tab="language">
                <div class="svc-nav-icon">🌐</div>
                <div class="svc-info">
                    <div class="svc-nav-title">Language Class</div>
                    <div class="svc-desc">Asah kemampuan multibahasamu bersama instruktur terverifikasi.</div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="services-content">
            
            <?php if(session()->getFlashdata('success')): ?>
                <div style="padding: 16px; background: rgba(76,175,80,0.2); border: 1px solid #4caf50; color: #4caf50; border-radius: 4px; margin: 20px;">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                <div style="padding: 16px; background: rgba(244,67,54,0.2); border: 1px solid #f44336; color: #f44336; border-radius: 4px; margin: 20px;">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- 1. Book Delivery Content -->
            <div id="svc-delivery" class="service-tab-content active">
               <?= $this->include('user/services/book_delivery') ?>
            </div>
            
            <!-- 2. Room Booking Content -->
            <div id="svc-room" class="service-tab-content">
               <?= $this->include('user/services/room_booking') ?>
            </div>

            <!-- 3. Layanan Referensi Content -->
            <div id="svc-referensi" class="service-tab-content">
               <?= $this->include('user/services/referensi') ?>
            </div>

            <!-- 4. Panduan Sitasi Content -->
            <div id="svc-sitasi" class="service-tab-content">
               <?= $this->include('user/services/sitasi') ?>
            </div>

            <!-- 5. Mendeley Class Content -->
            <div id="svc-mendeley" class="service-tab-content">
               <?= $this->include('user/services/mendeley_class') ?>
            </div>

            <!-- 6. Konsultasi Content -->
            <div id="svc-konsultasi" class="service-tab-content">
               <?= $this->include('user/services/konsultasi') ?>
            </div>

            <!-- 7. Language Class Content -->
            <div id="svc-language" class="service-tab-content">
               <?= $this->include('user/services/language_class') ?>
            </div>
            
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function showService(id, el) {
    // Hide all contents
    document.querySelectorAll('.service-tab-content').forEach(c => c.classList.remove('active'));
    // Show selected content
    document.getElementById('svc-' + id).classList.add('active');
    
    // Deactivate all nav cards
    document.querySelectorAll('.svc-nav-card').forEach(c => c.classList.remove('active'));
    // Activate clicked nav card
    el.classList.add('active');
    
    // Update URL query string
    const url = new URL(window.location);
    url.searchParams.set('tab', id);
    window.history.pushState({}, '', url);
}

// On load check hash or query param to activate specific tab
window.onload = function() {
    let urlParams = new URLSearchParams(window.location.search);
    let tab = urlParams.get('tab');
    if(tab) {
        let el = document.querySelector(`.svc-nav-card[data-tab='${tab}']`);
        if(el) {
            showService(tab, el);
        }
    }
}
</script>
<?= $this->endSection() ?>
