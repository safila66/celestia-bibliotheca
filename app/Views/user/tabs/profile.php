<!-- FAVORITE BOOKS -->
<h3 class="section-title">
    FAVORITE BOOKS
</h3>
<div class="favorites-grid" style="margin-bottom: 40px;">
    <?php if (!empty($favoriteBooks)): ?>
        <?php foreach ($favoriteBooks as $book): ?>
            <div class="fav-card">
                <img src="<?= base_url('uploads/covers/' . ($book['cover_image'] ?? 'placeholder.jpg')) ?>" alt="<?= esc($book['title']) ?>" onerror="this.src='https://via.placeholder.com/200x300?text=No+Cover'">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; font-size: 13px;">Belum ada buku favorit.</p>
    <?php endif; ?>
</div>

<!-- MY FINES (DENDA) -->
<?php if (isset($unpaidFines) && !empty($unpaidFines)): ?>
<h3 class="section-title" style="color: #e07070; border-color: rgba(224, 112, 112, 0.2);">
    UNPAID FINES
</h3>
<div style="background: rgba(224, 112, 112, 0.05); border: 1px solid rgba(224, 112, 112, 0.2); border-radius: 8px; padding: 20px; margin-bottom: 40px;">
    <table style="width: 100%; border-collapse: collapse; color: var(--ivory); font-family: 'Raleway', sans-serif; font-size: 13px;">
        <thead>
            <tr style="border-bottom: 1px solid rgba(224, 112, 112, 0.2);">
                <th style="padding: 10px; text-align: left; color: #e07070;">Deskripsi</th>
                <th style="padding: 10px; text-align: left; color: #e07070;">Jumlah</th>
                <th style="padding: 10px; text-align: right; color: #e07070;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($unpaidFines as $fine): ?>
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                <td style="padding: 12px 10px;"><?= esc($fine['description']) ?></td>
                <td style="padding: 12px 10px; color: var(--gold); font-weight: bold;">Rp <?= number_format($fine['amount'], 0, ',', '.') ?></td>
                <td style="padding: 12px 10px; text-align: right;">
                    <button type="button" class="btn-submit" style="padding: 6px 12px; font-size: 10px;" onclick="showQRIS(<?= $fine['id'] ?>)">Tampilkan QRIS</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- QRIS Modal -->
<div class="modal-overlay" id="qrisModal" onclick="closeQRIS(event)" style="display: none;">
    <div class="modal-content" onclick="event.stopPropagation()" style="background: var(--deep-navy); padding: 30px; border-radius: 8px; width: 100%; max-width: 300px; border: 1px solid var(--gold); text-align: center; margin: auto;">
        <h3 style="margin-top: 0; color: var(--gold); font-family: 'Cinzel', serif;">Scan QRIS</h3>
        <p style="font-size: 14px; color: var(--text-dim);">Silakan scan menggunakan aplikasi pembayaran Anda.</p>
        <div style="width: 200px; height: 200px; background: #fff; margin: 20px auto; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
            <img src="" id="qrisImage" style="width:180px; height:180px;">
        </div>
        <p id="qrisStatusText" style="font-size: 12px; color: #ff9800; font-weight:bold;">Menunggu Pembayaran...</p>
        <button onclick="closeQRIS()" style="margin-top: 10px; background: transparent; border: 1px solid var(--text-dim); color: #ccc; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Tutup</button>
    </div>
</div>

<script>
    let pollInterval;
    function showQRIS(fineId) {
        document.getElementById('qrisModal').style.display = 'flex';
        // Add class show for animation
        setTimeout(() => document.getElementById('qrisModal').classList.add('show'), 10);
        const scanUrl = '<?= base_url('scan/fine/') ?>' + fineId;
        document.getElementById('qrisImage').src = `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${encodeURIComponent(scanUrl)}`;
        document.getElementById('qrisStatusText').innerText = "Menunggu Pembayaran...";
        document.getElementById('qrisStatusText').style.color = "#ff9800";
        
        // Start polling API
        pollInterval = setInterval(() => {
            fetch('<?= base_url('api/check-fine/') ?>' + fineId)
            .then(r => r.json())
            .then(data => {
                if (data.status === 'paid') {
                    clearInterval(pollInterval);
                    document.getElementById('qrisStatusText').innerText = "Pembayaran Berhasil! Memuat ulang...";
                    document.getElementById('qrisStatusText').style.color = "#4caf50";
                    setTimeout(() => window.location.reload(), 1500);
                }
            })
            .catch(err => console.error(err));
        }, 2000); // poll every 2s
    }

    function closeQRIS(e) {
        if(e) e.stopPropagation();
        clearInterval(pollInterval);
        document.getElementById('qrisModal').classList.remove('show');
        setTimeout(() => document.getElementById('qrisModal').style.display = 'none', 300);
    }
</script>
<?php endif; ?>

<!-- RIWAYAT LAYANAN -->
<div style="margin-top: 40px;">
    <h3 class="section-title">
        Riwayat Layanan (Mendeley, Room, Language)
    </h3>
    <?php $hasService = false; ?>

    <?php if(!empty($myServices['mendeley'])): $hasService = true; ?>
        <?php foreach($myServices['mendeley'] as $item): ?>
        <div class="service-card">
            <div>
                <div class="service-title">Mendeley Class (<?= esc($item['class_level']) ?>)</div>
                <div class="service-desc"><?= date('d M Y', strtotime($item['schedule_date'])) ?> | <?= esc($item['session_time']) ?></div>
            </div>
            <div class="service-status status-<?= strtolower($item['status']) ?>"><?= esc($item['status']) ?></div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if(!empty($myServices['language'])): $hasService = true; ?>
        <?php foreach($myServices['language'] as $item): ?>
        <div class="service-card">
            <div>
                <div class="service-title">Language Class (<?= esc($item['language']) ?>)</div>
                <div class="service-desc">
                    <?= date('d M Y', strtotime($item['schedule_date'])) ?> | <?= esc($item['session_time']) ?> | 
                    Seat: <?= esc($item['seat_number']) ?> 
                </div>
            </div>
            <div class="service-status status-<?= strtolower($item['status']) ?>"><?= esc($item['status']) ?></div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if(!empty($myServices['room'])): $hasService = true; ?>
        <?php foreach($myServices['room'] as $item): ?>
        <div class="service-card">
            <div>
                <div class="service-title">Room Booking (<?= esc($item['room_name']) ?>)</div>
                <div class="service-desc"><?= date('d M Y', strtotime($item['booking_date'])) ?> | <?= esc($item['start_time']) ?> - <?= esc($item['end_time']) ?></div>
            </div>
            <div class="service-status status-<?= strtolower($item['status']) ?>"><?= esc($item['status']) ?></div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if(!$hasService): ?>
        <p style="color: #666; font-size: 13px;">Belum ada riwayat layanan.</p>
    <?php endif; ?>
</div>
