<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
    .page-container {
        padding: 120px 56px 60px;
        max-width: 1000px;
        margin: 0 auto;
        min-height: 80vh;
    }
    .page-title {
        font-family: 'Cinzel', serif;
        font-size: 32px;
        color: var(--gold);
        text-align: center;
        margin-bottom: 40px;
        letter-spacing: 0.1em;
    }
    .loans-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .loan-card {
        background: var(--bg-card);
        border: 1px solid var(--border-gold);
        border-radius: 8px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    .loan-cover {
        width: 80px;
        height: 120px;
        object-fit: cover;
        border-radius: 4px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.5);
    }
    .loan-info {
        flex: 1;
    }
    .loan-title {
        font-family: 'Cinzel', serif;
        font-size: 20px;
        color: var(--gold-light);
        margin: 0 0 8px 0;
    }
    .loan-details {
        font-family: 'Raleway', sans-serif;
        font-size: 13px;
        color: #CCC;
        margin: 0 0 12px 0;
        line-height: 1.6;
    }
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 4px;
        font-family: 'Raleway', sans-serif;
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    .status-pending { background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid #ffc107; }
    .status-active { background: rgba(40, 167, 69, 0.1); color: #28a745; border: 1px solid #28a745; }
    .status-delivering { background: rgba(23, 162, 184, 0.1); color: #17a2b8; border: 1px solid #17a2b8; }
    .status-returned { background: rgba(108, 117, 125, 0.1); color: #adb5bd; border: 1px solid #adb5bd; }
    .status-overdue { background: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid #dc3545; }
    .btn-track {
        display: inline-block;
        background: transparent;
        border: 1px solid var(--gold);
        color: var(--gold);
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-family: 'Raleway', sans-serif;
        font-size: 12px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-top: 10px;
        transition: all 0.3s;
    }
    .btn-track:hover {
        background: var(--gold);
        color: #12100E;
    }
    
    [data-theme="light"] .loan-card { background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-color: rgba(168,117,42,0.3); }
    [data-theme="light"] .loan-details { color: #555; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-container">
    <h1 class="page-title">Peminjaman Saya</h1>
    
    <?php if (empty($loans)): ?>
        <p style="text-align:center; color: #aaa; font-family:'Raleway', sans-serif;">Belum ada riwayat peminjaman.</p>
    <?php else: ?>
        <div class="loans-grid">
            <?php foreach ($loans as $loan): ?>
                <div class="loan-card">
                    <!-- Gunakan placeholder jika cover tidak ada di join query (tergantung implementasi model) -->
                    <img src="<?= base_url('uploads/covers/' . ($loan['cover_image'] ?? 'placeholder.jpg')) ?>" class="loan-cover" alt="Cover" onerror="this.src='https://via.placeholder.com/80x120?text=No+Cover'">
                    
                    <div class="loan-info">
                        <h3 class="loan-title"><?= esc($loan['book_title'] ?? 'Buku Tidak Diketahui') ?></h3>
                        <p class="loan-details">
                            <strong>Kode Pinjam:</strong> <?= esc($loan['loan_code']) ?><br>
                            <strong>Tanggal Pinjam:</strong> <?= date('d M Y', strtotime($loan['borrow_date'] ?? $loan['created_at'])) ?><br>
                            <strong>Tenggat Waktu:</strong> <?= date('d M Y', strtotime($loan['due_date'])) ?>
                        </p>
                        
                        <?php
                            $statusClass = 'status-pending';
                            $statusText = 'Menunggu Konfirmasi';
                            $isOverdue = false;
                            
                            if ($loan['status'] == 'active') { $statusClass = 'status-active'; $statusText = 'Dipinjam'; }
                            if ($loan['status'] == 'delivering') { $statusClass = 'status-delivering'; $statusText = 'Dalam Pengiriman'; }
                            if ($loan['status'] == 'returned') { $statusClass = 'status-returned'; $statusText = 'Dikembalikan'; }
                            if ($loan['status'] == 'overdue') { $statusClass = 'status-overdue'; $statusText = 'Terlambat'; $isOverdue = true; }
                            
                            // Check overdue based on date if it's active or pending/delivering
                            if (in_array($loan['status'], ['pending', 'active', 'delivering']) && strtotime($loan['due_date']) < strtotime(date('Y-m-d'))) {
                                $statusClass = 'status-overdue';
                                $statusText = 'Terlambat';
                                $isOverdue = true;
                            }
                            // Calculate overdue days and fine
                            $overdueDays = 0;
                            $fineAmount = 0;
                            if ($isOverdue) {
                                $dueDateTime = strtotime($loan['due_date']);
                                $currentDateTime = strtotime(date('Y-m-d'));
                                if ($currentDateTime > $dueDateTime) {
                                    $overdueDays = floor(($currentDateTime - $dueDateTime) / (60 * 60 * 24));
                                    $fineAmount = $overdueDays * 1000;
                                }
                            }
                            
                            $badgeAttributes = '';
                            if ($isOverdue) {
                                $badgeAttributes = 'style="cursor:pointer;" onclick="showFineModal(\''.esc($loan['loan_code']).'\', \''.esc($loan['book_title'] ?? 'Buku').'\', '.$overdueDays.', '.$fineAmount.')" title="Klik untuk membayar denda"';
                            }
                        ?>
                        <span class="status-badge <?= $statusClass ?>" <?= $badgeAttributes ?>><?= $statusText ?></span>
                        
                        <?php if ($loan['status'] == 'delivering'): ?>
                            <br>
                            <a href="<?= base_url('delivery-tracking/' . $loan['loan_code']) ?>" class="btn-track">📍 Lacak Pengiriman</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Denda / QRIS -->
<div id="fineModal" class="modal-overlay" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.8); z-index:1000; align-items:center; justify-content:center;">
    <div class="modal-content" style="background: var(--bg-card); border: 1px solid var(--border-gold); border-radius: 8px; padding: 30px; width: 100%; max-width: 400px; text-align: center; color: #fff;">
        <h2 style="font-family: 'Cinzel', serif; color: var(--gold); margin-top: 0;">Pembayaran Denda</h2>
        <p style="font-family: 'Raleway', sans-serif; font-size: 14px; color: #CCC; margin-bottom: 20px;">
            Buku: <strong id="fineBookTitle" style="color: var(--gold-light);"></strong><br>
            Kode: <span id="fineLoanCode"></span><br>
            Keterlambatan: <strong id="fineDays" style="color: #ffc107;"></strong> hari<br>
            Total Denda: <strong id="fineAmount" style="color: #ff6b6b; font-size: 18px;"></strong><br><br>
            Harap scan QRIS di bawah ini untuk membayar denda keterlambatan Anda.
        </p>
        
        <div style="background: #fff; padding: 15px; border-radius: 8px; display: inline-block; margin-bottom: 20px;">
            <img id="qrisImage" src="" alt="QRIS Code" style="width: 200px; height: 200px;">
        </div>
        
        <div style="font-family: 'Raleway', sans-serif; font-size: 12px; color: #888; margin-bottom: 20px;">
            *Setelah melakukan pembayaran, admin akan memverifikasi dan memperbarui status peminjaman Anda.
        </div>
        
        <button onclick="closeFineModal()" style="background: transparent; color: var(--gold); border: 1px solid var(--gold); padding: 8px 24px; border-radius: 4px; cursor: pointer; font-family: 'Raleway', sans-serif; font-weight: bold; text-transform: uppercase;">Tutup</button>
    </div>
</div>

<script>
function showFineModal(loanCode, bookTitle, overdueDays, fineAmount) {
    document.getElementById('fineBookTitle').innerText = bookTitle;
    document.getElementById('fineLoanCode').innerText = loanCode;
    document.getElementById('fineDays').innerText = overdueDays;
    
    // Format fine amount to Rupiah
    const formattedFine = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(fineAmount);
    document.getElementById('fineAmount').innerText = formattedFine;
    
    // Generate a dummy QRIS payload or simple text
    const dummyQrisPayload = `QRIS-PAYMENT-FINE-${loanCode}-RP${fineAmount}`;
    const qrisUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(dummyQrisPayload)}`;
    
    document.getElementById('qrisImage').src = qrisUrl;
    
    document.getElementById('fineModal').style.display = 'flex';
}

function closeFineModal() {
    document.getElementById('fineModal').style.display = 'none';
}
</script>

<?= $this->endSection() ?>
