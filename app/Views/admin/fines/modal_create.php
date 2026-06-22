<div class="modal-dialog modal-lg" style="width: 90%; max-width: 700px; height: auto; margin: auto; display: flex; flex-direction: column;">
    <div class="modal-content" style="background: #0a0f18; border: 2px solid #7ec8a0; border-radius: 8px; box-shadow: 0 20px 50px rgba(0,0,0,0.95); display: flex; flex-direction: column; overflow: hidden;">
        
        <div class="modal-header" style="border-bottom: 1px solid rgba(126,200,160,0.3); padding: 15px 25px; display: flex; justify-content: space-between; align-items: center;">
            <h5 class="modal-title" style="color: #7ec8a0; font-family: 'Cinzel', serif; margin: 0; font-size: 22px; font-weight: bold;">+ Catat Denda Baru</h5>
            <button type="button" onclick="$('#createModal').hide()" style="background: none; border: none; color: #ffffff; font-size: 2rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        
        <form action="<?= base_url('admin/create/fine') ?>" method="post" style="display: flex; flex-direction: column; margin: 0;">
            <?= csrf_field(); ?>
            <div class="modal-body" style="padding: 25px;">
                <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Member</label>
                            <select name="user_id" required style="width: 100%; padding: 12px; font-size: 15px; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ffffff; border-radius: 6px;">
                                <option value="" disabled selected>-- Pilih Member --</option>
                                <?php foreach ($members as $m): ?>
                                    <option value="<?= esc($m['id']) ?>" style="background: #1a2332;"><?= esc($m['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Terkait Peminjaman (Opsional)</label>
                            <select name="loan_id" style="width: 100%; padding: 12px; font-size: 15px; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ffffff; border-radius: 6px;">
                                <option value="">-- Tidak Terkait --</option>
                                <?php foreach ($loans as $l): ?>
                                    <option value="<?= esc($l['id']) ?>" style="background: #1a2332;">#L-<?= str_pad($l['id'], 4, '0', STR_PAD_LEFT) ?> - <?= esc($l['book_title']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Jumlah Denda (Rp)</label>
                            <input type="number" name="amount" required min="0" placeholder="Contoh: 50000" style="width: 100%; padding: 12px; font-size: 15px; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ff6b6b; font-weight: bold; border-radius: 6px;">
                        </div>
                        <div class="form-group">
                            <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Status Pembayaran</label>
                            <select name="status" required style="width: 100%; padding: 12px; font-size: 15px; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #7ec8a0; border-radius: 6px; font-weight: bold;">
                                <option value="unpaid" selected style="background: #1a2332; color:#fff;">Belum Dibayar</option>
                                <option value="paid" style="background: #1a2332; color:#fff;">Sudah Lunas</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Keterangan Denda</label>
                        <textarea name="description" placeholder="Misal: Buku hilang, halaman sobek, terlambat 5 hari..." rows="2" style="width: 100%; padding: 12px; font-size: 15px; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ffffff; border-radius: 6px;"></textarea>
                    </div>

                </div>
            </div>
            
            <div class="modal-footer" style="border-top: 1px solid rgba(126,200,160,0.3); padding: 15px 25px; text-align: right; background: #070a11;">
                <button type="button" onclick="$('#createModal').hide()" style="background: transparent; color: #7ec8a0; border: 1px solid #7ec8a0; padding: 10px 20px; font-size: 14px; margin-right: 10px; cursor: pointer; border-radius: 4px; font-weight: bold;">Batal</button>
                <button type="submit" style="background: #7ec8a0; color: #04060f; padding: 10px 20px; font-size: 14px; border: none; font-weight: bold; cursor: pointer; border-radius: 4px;">Simpan Catatan</button>
            </div>
        </form>
    </div>
</div>
