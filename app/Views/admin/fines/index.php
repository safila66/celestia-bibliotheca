<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 15px;">
    <h2 style="font-family: 'Cinzel', serif; color: var(--gold); font-weight: bold; margin: 0; font-size: 24px;">Manajemen Denda</h2>
    
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="javascript:void(0);" onclick="createFine()" style="padding: 8px 16px; background: var(--gold); color: #04060f; border: none; font-weight: bold; text-decoration: none; border-radius: 4px;">+ Tambah Denda</a>
    </div>
</div>

<div class="card" style="background: var(--deep-navy); padding: 20px; border-radius: 8px; border: 1px solid rgba(201,168,76,0.3);">
    <div class="table-wrap" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--ivory); min-width: 900px;">
            <thead>
                <tr style="border-bottom: 2px solid var(--gold); background: rgba(201,168,76,0.1);">
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">No</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Member</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Ref. Peminjaman</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Keterangan</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase; text-align: right;">Jumlah (Rp)</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase; text-align: center;">Status</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($fines)): ?>
                    <?php $i = 1; foreach ($fines as $row): ?>
                    <tr style="border-bottom: 1px solid rgba(201,168,76,0.2); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px;"><?= $i++ ?></td>
                        <td style="padding: 12px 10px; font-family: 'Cinzel', serif; font-size: 14px; font-weight: 600; color: var(--gold);">
                            <?= esc($row['user_name'] ?? '-') ?>
                        </td>
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px;">
                            <?= !empty($row['loan_ref']) ? esc($row['loan_ref']) : '-' ?>
                        </td>
                        <td style="padding: 12px 10px; color: var(--text-dim); font-size: 13px;">
                            <?= esc($row['description']) ?: 'Keterlambatan/Kerusakan' ?>
                        </td>
                        <td style="padding: 12px 10px; color: #ff6b6b; font-weight: bold; font-size: 14px; text-align: right;">
                            <?= number_format($row['amount'], 0, ',', '.') ?>
                        </td>
                        <td style="padding: 12px 10px; text-align: center;">
                            <?php if ($row['status'] === 'paid'): ?>
                                <span style="background: rgba(126, 200, 160, 0.15); border: 1px solid #7ec8a0; padding: 4px 8px; border-radius: 15px; font-size: 11px; color: #7ec8a0; white-space: nowrap;">
                                    Lunas (<?= date('d/m', strtotime($row['paid_at'])) ?>)
                                </span>
                            <?php else: ?>
                                <span style="background: rgba(224, 112, 112, 0.15); border: 1px solid #e07070; padding: 4px 8px; border-radius: 15px; font-size: 11px; color: #e07070; white-space: nowrap;">
                                    Belum Dibayar
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 12px 10px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <?php if ($row['status'] === 'unpaid'): ?>
                                    <button onclick="payQris(<?= $row['id'] ?>, <?= $row['amount'] ?>)" style="background: #20b2aa; color: #04060f; border: none; padding: 6px 10px; border-radius: 4px; font-size: 11px; cursor: pointer; font-weight: bold;" title="Bayar via QRIS">💳</button>
                                <?php endif; ?>
                                <button onclick="editFine(<?= $row['id'] ?>)" style="background: #c9a84c; color: #04060f; border: none; padding: 6px 10px; border-radius: 4px; font-size: 11px; cursor: pointer; font-weight: bold;" title="Edit">✏️</button>
                                <a href="<?= base_url('admin/delete/fine/' . $row['id']) ?>" style="background: #963c3c; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none; font-size: 11px; font-weight: bold;" onclick="return confirm('Hapus data denda ini?')" title="Hapus">🗑️</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-dim); font-style: italic;">
                            <div style="font-size: 40px; margin-bottom: 10px;">💸</div>
                            Tidak ada data denda saat ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
    <div id="editFormContent" style="width: 100%; display: flex; justify-content: center;"></div>
</div>

<div id="createModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
    <div id="createFormContent" style="width: 100%; display: flex; justify-content: center;"></div>
</div>

<div id="qrisModal" class="modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
    <div class="modal-content" style="background: #0a0f18; border: 2px solid var(--gold); border-radius: 8px; box-shadow: 0 20px 50px rgba(0,0,0,0.95); width: 90%; max-width: 400px; display: flex; flex-direction: column;">
        <div style="border-bottom: 1px solid rgba(201,168,76,0.3); padding: 15px 25px; display: flex; justify-content: space-between; align-items: center;">
            <h5 style="color: var(--gold); font-family: 'Cinzel', serif; margin: 0; font-size: 20px; font-weight: bold;">Pembayaran QRIS</h5>
            <button type="button" onclick="$('#qrisModal').hide()" style="background: none; border: none; color: var(--ivory); font-size: 2rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        <div style="padding: 25px; text-align: center;">
            <p style="color: var(--moon-silver); font-size: 14px; margin-bottom: 20px;">Silakan scan kode QRIS di bawah ini untuk menyelesaikan denda sebesar <strong id="qrisAmount" style="color: #ff6b6b; font-size: 18px;"></strong></p>
            <div style="background: white; padding: 20px; border-radius: 8px; display: inline-block; margin-bottom: 25px;">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=Pembayaran_Denda_Celestia" alt="Dummy QRIS" style="width: 200px; height: 200px;">
            </div>
            
            <form id="qrisForm" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn-submit" style="width: 100%; padding: 12px; font-size: 15px; font-weight: bold; background: var(--gold); color: #04060f; border: none; border-radius: 6px; cursor: pointer; transition: background 0.3s;">Simulasikan Pembayaran</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function editFine(id) {
        $('#editModal').css('display', 'flex');
        $('#editFormContent').html('<div style="color:var(--gold); padding:20px; background: var(--deep-navy); border: 1px solid var(--gold); border-radius: 8px;">Memuat data... ⏳</div>');
        
        $.ajax({
            url: "<?= base_url('admin/ajax/edit/fine/') ?>" + id,
            type: "GET",
            success: function(response) {
                $('#editFormContent').html(response);
            },
            error: function(xhr) {
                $('#editFormContent').html('<div style="background: #fff; color: #000; padding: 20px; border-radius: 8px;">' + xhr.responseText + '</div>');
            }
        });
    }

    function createFine() {
        $('#createModal').css('display', 'flex');
        $('#createFormContent').html('<div style="color:#7ec8a0; padding:20px; background: var(--deep-navy); border: 1px solid #7ec8a0; border-radius: 8px;">Mempersiapkan formulir... ⏳</div>');
        
        $.ajax({
            url: "<?= base_url('admin/ajax/create/fine') ?>",
            type: "GET",
            success: function(response) {
                $('#createFormContent').html(response);
            },
            error: function(xhr) {
                $('#editFormContent').html('<div style="background: #fff; color: #000; padding: 20px; border-radius: 8px;">' + xhr.responseText + '</div>');
            }
        });
    }

    function payQris(id, amount) {
        // Format rupiah
        let formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
        $('#qrisAmount').text(formatted);
        
        // Update URL form submit
        $('#qrisForm').attr('action', "<?= base_url('admin/fines/markPaid/') ?>" + id);
        
        $('#qrisModal').css('display', 'flex');
    }
</script>
<?= $this->endSection() ?>
