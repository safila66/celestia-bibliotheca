<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
/* Header Styles */
.service-header {
    background: linear-gradient(180deg, var(--deep-navy) 0%, #0d1025 100%);
    padding: 120px 20px 60px;
    text-align: center;
    border-bottom: 1px solid rgba(201,168,76,0.15);
}
.service-title {
    font-family: 'Cinzel', serif; font-size: 36px;
    color: var(--gold); letter-spacing: 0.08em;
    margin-bottom: 16px;
}
.service-subtitle {
    color: var(--ivory); opacity: 0.8; font-size: 16px;
}

/* ── UI TAB & TRACKING ── */
.delivery-tabs { display: flex; gap: 24px; margin-bottom: 30px; border-bottom: 1px solid rgba(201,168,76,0.2); }
.delivery-tab { padding: 12px 0; cursor: pointer; color: var(--text-dim); font-weight: 600; border-bottom: 2px solid transparent; transition: all 0.3s; }
.delivery-tab.active { color: var(--gold); border-bottom-color: var(--gold); }
.delivery-tab:hover { color: var(--gold-light); }

/* Delivery Tracker / Online Shop Style */
.tracker-tabs {
    display: flex; background: var(--panel, rgba(30,35,45,0.4));
    border: 1px solid var(--border, rgba(255,255,255,0.1));
    border-radius: 8px 8px 0 0; overflow: hidden;
}
.tracker-tab {
    flex: 1; text-align: center; padding: 16px; cursor: pointer;
    color: var(--text-dim); transition: 0.2s;
    border-bottom: 2px solid transparent;
}
.tracker-tab.active {
    color: #ff5722; border-bottom-color: #ff5722; background: rgba(255,87,34,0.05); font-weight: bold;
}
.tracker-content {
    background: var(--panel, rgba(30,35,45,0.4));
    border: 1px solid var(--border, rgba(255,255,255,0.1));
    border-top: none; padding: 40px; border-radius: 0 0 8px 8px;
    min-height: 300px;
}
.empty-state {
    text-align: center; color: var(--text-dim);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    height: 100%;
}

/* Delivery Item Card */
.delivery-card {
    display: flex; gap: 20px; padding: 20px; border: 1px solid var(--border, rgba(255,255,255,0.1));
    border-radius: 8px; margin-bottom: 20px; background: rgba(0,0,0,0.2);
}
.delivery-card img { width: 80px; height: 120px; object-fit: cover; border-radius: 4px; }
.delivery-info { flex: 1; }
.delivery-title { font-weight: bold; font-size: 18px; margin-bottom: 8px; color: var(--text); }
.delivery-meta { font-size: 14px; color: var(--text-dim); margin-bottom: 4px; }
.delivery-status {
    display: inline-block; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: bold; margin-top: 10px;
}
.status-pending { background: rgba(255,152,0,0.2); color: #ff9800; }
.status-shipping { background: rgba(33,150,243,0.2); color: #2196f3; }
.status-delivered { background: rgba(76,175,80,0.2); color: #4caf50; }
.status-cancelled { background: rgba(244,67,54,0.2); color: #f44336; }

/* Table */
.book-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.book-table th, .book-table td { padding: 16px; text-align: left; border-bottom: 1px solid var(--border, rgba(255,255,255,0.1)); color: var(--text); }
.book-table th { background: rgba(201,168,76,0.1); color: var(--gold); font-weight: bold; }
.btn-request { background: var(--gold); color: #1a1a2e; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; transition: background 0.2s; }
.btn-request:hover { background: #dfc16d; }

/* Modal */
.modal-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.8); display: none; align-items: center; justify-content: center; z-index: 1000;
}
.modal-content {
    background: var(--deep-navy); padding: 30px; border-radius: 8px; width: 100%; max-width: 500px;
    border: 1px solid var(--gold); color: var(--text);
}
.modal-content h3 { margin-top: 0; color: var(--gold); margin-bottom: 20px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-size: 14px; color: var(--text-dim); }
.form-group textarea, .form-group input { width: 100%; padding: 12px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: var(--text); font-family: inherit; }

[data-theme="light"] .service-header { background: #F8F5F0; }
[data-theme="light"] .service-title { color: #A8752A; }
[data-theme="light"] .service-subtitle { color: #555; }
[data-theme="light"] .tracker-tabs, [data-theme="light"] .tracker-content { background: #fff; border-color: #ddd; }
[data-theme="light"] .book-table th { background: #f0f0f0; color: #333; }
[data-theme="light"] .book-table td { border-bottom-color: #eee; color: #333; }
[data-theme="light"] .modal-content { background: #fff; border-color: #ccc; }
[data-theme="light"] .form-group textarea, [data-theme="light"] .form-group input { background: #fafafa; border-color: #ccc; color: #333; }
</style>

<section class="service-header">
    <h1 class="service-title"><?= esc($title) ?></h1>
    <p class="service-subtitle">Pesan buku fisik langsung ke alamat Anda dengan pelacakan waktu nyata.</p>
</section>

<?php if(session()->getFlashdata('success')): ?>
    <div style="padding: 16px; background: rgba(76,175,80,0.2); border: 1px solid #4caf50; color: #4caf50; border-radius: 4px; margin: 20px auto; max-width: 1100px;">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="delivery-tabs" style="max-width: 1100px; margin: 40px auto 30px;">
    <div class="delivery-tab" onclick="switchDeliveryTab('katalog', event)">Katalog Buku Fisik</div>
    <div class="delivery-tab active" onclick="switchDeliveryTab('tracking', event)">Status Pengiriman Saya</div>
</div>

<div id="tab-katalog" class="delivery-content" style="display: none; max-width: 1100px; margin: 0 auto;">
    <table class="book-table">
        <thead>
            <tr>
                <th>Sampul</th>
                <th>Judul Buku</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($availableBooks as $book): ?>
            <tr>
                <td><img src="/assets/covers/<?= esc($book['cover_image'] ?? 'default-cover.jpg') ?>" style="width: 50px; border-radius: 4px;"></td>
                <td>
                    <div style="font-weight: bold; font-size: 16px;"><?= esc($book['title']) ?></div>
                    <div style="font-size: 13px; color: var(--text-dim);"><?= esc($book['author']) ?></div>
                </td>
                <td><?= esc($book['stock_available']) ?> Tersedia</td>
                <td>
                    <button class="btn-request" onclick="openRequestModal(<?= $book['id'] ?>, '<?= addslashes(esc($book['title'])) ?>')">Pesan Delivery</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Tracking Section -->
<div id="tab-tracking" class="delivery-content" style="max-width: 1100px; margin: 0 auto;">
    <?php
        $counts = [
            'pending' => 0,
            'shipping' => 0,
            'delivered' => 0,
            'cancelled' => 0
        ];
        foreach($userDeliveries as $d) {
            $counts[$d['status']]++;
        }
    ?>
    <div class="tracker-tabs">
        <div class="tracker-tab active" onclick="switchStatusTab('pending', this)">Sedang Dikemas <?= $counts['pending'] ? "({$counts['pending']})" : "" ?></div>
        <div class="tracker-tab" onclick="switchStatusTab('shipping', this)">Dikirim <?= $counts['shipping'] ? "({$counts['shipping']})" : "" ?></div>
        <div class="tracker-tab" onclick="switchStatusTab('delivered', this)">Selesai <?= $counts['delivered'] ? "({$counts['delivered']})" : "" ?></div>
        <div class="tracker-tab" onclick="switchStatusTab('cancelled', this)">Dibatalkan <?= $counts['cancelled'] ? "({$counts['cancelled']})" : "" ?></div>
    </div>
    <div class="tracker-content" id="tracker-content">
        <!-- Will be populated by JS -->
    </div>
</div>

<!-- Modal Form -->
<div class="modal-overlay" id="requestModal">
    <div class="modal-content">
        <h3>Request Book Delivery</h3>
        <p style="margin-bottom: 20px; font-size: 14px;" id="modalBookTitle"></p>
        <form action="/book-delivery/request" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="book_id" id="modalBookId">
            <div class="form-group">
                <label>Alamat Lengkap Pengiriman</label>
                <textarea name="address" rows="4" required placeholder="Masukkan alamat lengkap RT/RW, Kode Pos..."></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-request" style="background: transparent; border: 1px solid var(--text-dim); color: var(--text);" onclick="closeRequestModal()">Batal</button>
                <button type="submit" class="btn-request">Kirim Permintaan</button>
            </div>
        </form>
    </div>
</div>

<script>
const deliveries = <?= json_encode($userDeliveries) ?>;

function switchDeliveryTab(tab, event) {
    document.querySelectorAll('.delivery-tab').forEach(t => t.classList.remove('active'));
    event.target.classList.add('active');
    document.getElementById('tab-katalog').style.display = tab === 'katalog' ? 'block' : 'none';
    document.getElementById('tab-tracking').style.display = tab === 'tracking' ? 'block' : 'none';
}

function switchStatusTab(status, element) {
    document.querySelectorAll('.tracker-tab').forEach(t => t.classList.remove('active'));
    if(element) element.classList.add('active');
    
    const container = document.getElementById('tracker-content');
    const filtered = deliveries.filter(d => d.status === status);
    
    if (filtered.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <div style="font-size: 64px; margin-bottom: 20px; opacity: 0.8;">📦</div>
                <div style="font-size: 18px;">Belum ada pesanan</div>
            </div>
        `;
        return;
    }
    
    let html = '';
    filtered.forEach(d => {
        let statusBadge = '';
        if(d.status === 'pending') statusBadge = '<span class="delivery-status status-pending">Sedang Dikemas</span>';
        if(d.status === 'shipping') statusBadge = '<span class="delivery-status status-shipping">Sedang Dikirim</span>';
        if(d.status === 'delivered') statusBadge = '<span class="delivery-status status-delivered">Selesai</span>';
        if(d.status === 'cancelled') statusBadge = '<span class="delivery-status status-cancelled">Dibatalkan</span>';

        let imgSrc = d.cover_image && d.cover_image.includes('../images') ? d.cover_image.replace('../images', '/assets/images') : '/assets/covers/' + (d.cover_image || 'default-cover.jpg');

        html += `
            <div class="delivery-card">
                <img src="${imgSrc}">
                <div class="delivery-info">
                    <div class="delivery-title">${d.book_title}</div>
                    <div class="delivery-meta">Alamat: ${d.delivery_address}</div>
                    <div class="delivery-meta">Resi: ${d.tracking_number || '-'}</div>
                    <div class="delivery-meta">Tanggal: ${d.created_at}</div>
                    ${statusBadge}
                </div>
            </div>
        `;
    });
    container.innerHTML = html;
}

function openRequestModal(id, title) {
    document.getElementById('requestModal').style.display = 'flex';
    document.getElementById('modalBookId').value = id;
    document.getElementById('modalBookTitle').innerText = 'Buku: ' + title;
}

function closeRequestModal() {
    document.getElementById('requestModal').style.display = 'none';
}

// Init
document.addEventListener('DOMContentLoaded', () => {
    switchStatusTab('pending', document.querySelector('.tracker-tab.active'));
});
</script>
