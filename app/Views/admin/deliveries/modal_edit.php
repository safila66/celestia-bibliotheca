<div class="modal-dialog modal-lg" style="width: 90%; max-width: 700px; height: auto; margin: auto; display: flex; flex-direction: column;">
    <div class="modal-content" style="background: #0a0f18; border: 2px solid var(--gold); border-radius: 8px; box-shadow: 0 20px 50px rgba(0,0,0,0.95); display: flex; flex-direction: column; overflow: hidden;">
        
        <div class="modal-header" style="border-bottom: 1px solid rgba(201,168,76,0.3); padding: 15px 25px; display: flex; justify-content: space-between; align-items: center;">
            <h5 class="modal-title" style="color: var(--gold); font-family: 'Cinzel', serif; margin: 0; font-size: 22px; font-weight: bold;">Edit Pengiriman Buku</h5>
            <button type="button" onclick="$('#editModal').hide()" style="background: none; border: none; color: var(--ivory); font-size: 2rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        
        <form action="<?= base_url('admin/update/delivery/' . $delivery['id']) ?>" method="post" style="display: flex; flex-direction: column; margin: 0;">
            <?= csrf_field(); ?>
            <div class="modal-body" style="padding: 25px;">
                <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Member</label>
                            <select name="user_id" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px;">
                                <option value="" disabled>-- Pilih Member --</option>
                                <?php foreach ($members as $m): ?>
                                    <option value="<?= esc($m['id']) ?>" <?= $delivery['user_id'] == $m['id'] ? 'selected' : '' ?> style="background: #131a26;">
                                        <?= esc($m['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Buku</label>
                            <select name="book_id" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px;">
                                <option value="" disabled>-- Pilih Buku --</option>
                                <?php foreach ($books as $b): ?>
                                    <option value="<?= esc($b['id']) ?>" <?= $delivery['book_id'] == $b['id'] ? 'selected' : '' ?> style="background: #131a26;">
                                        <?= esc($b['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Alamat Pengiriman</label>
                        <textarea name="delivery_address" required rows="3" style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px;"><?= esc($delivery['delivery_address']) ?></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Tgl Pengiriman</label>
                            <input type="date" name="shipping_date" value="<?= esc($delivery['shipping_date']) ?>" style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px;">
                        </div>
                        <div class="form-group">
                            <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">No. Resi (Opsional)</label>
                            <input type="text" name="tracking_number" value="<?= esc($delivery['tracking_number']) ?>" placeholder="Resi JNE/SiCepat" style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Status</label>
                        <select name="status" required style="width: 100%; padding: 12px; font-size: 15px; font-weight: bold; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: var(--gold); border-radius: 6px;">
                            <option value="pending" <?= $delivery['status'] == 'pending' ? 'selected' : '' ?> style="background: #131a26; color: #fff;">Pending</option>
                            <option value="shipping" <?= $delivery['status'] == 'shipping' ? 'selected' : '' ?> style="background: #131a26; color: #fff;">Dikirim</option>
                            <option value="delivered" <?= $delivery['status'] == 'delivered' ? 'selected' : '' ?> style="background: #131a26; color: #fff;">Selesai (Sampai)</option>
                            <option value="cancelled" <?= $delivery['status'] == 'cancelled' ? 'selected' : '' ?> style="background: #131a26; color: #fff;">Dibatalkan</option>
                        </select>
                    </div>

                </div>
            </div>
            
            <div class="modal-footer" style="border-top: 1px solid rgba(201,168,76,0.3); padding: 15px 25px; text-align: right; background: #070a11;">
                <button type="button" onclick="$('#editModal').hide()" style="background: transparent; color: var(--gold); border: 1px solid var(--gold); padding: 10px 20px; font-size: 14px; margin-right: 10px; cursor: pointer; border-radius: 4px; font-weight: bold;">Batal</button>
                <button type="submit" style="background: var(--gold); color: #04060f; padding: 10px 20px; font-size: 14px; border: none; font-weight: bold; cursor: pointer; border-radius: 4px;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
