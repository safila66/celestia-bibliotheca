<div class="modal-dialog modal-lg" style="width: 90%; max-width: 700px; height: auto; margin: auto; display: flex; flex-direction: column;">
    <div class="modal-content" style="background: #0a0f18; border: 2px solid var(--gold); border-radius: 8px; box-shadow: 0 20px 50px rgba(0,0,0,0.95); display: flex; flex-direction: column; overflow: hidden;">
        
        <div class="modal-header" style="border-bottom: 1px solid rgba(201,168,76,0.3); padding: 15px 25px; display: flex; justify-content: space-between; align-items: center;">
            <h5 class="modal-title" style="color: var(--gold); font-family: 'Cinzel', serif; margin: 0; font-size: 22px; font-weight: bold;">Edit Data Peminjaman</h5>
            <button type="button" onclick="$('#editModal').hide()" style="background: none; border: none; color: var(--ivory); font-size: 2rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        
        <form action="<?= base_url('admin/update/loan/' . $loan['id']) ?>" method="post" style="display: flex; flex-direction: column; margin: 0;">
            <?= csrf_field(); ?>
            <div class="modal-body" style="padding: 25px;">
                <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                    
                    <div class="form-group">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Nama Peminjam</label>
                        <select name="user_id" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px;">
                            <option value="" disabled>-- Pilih Member --</option>
                            <?php foreach ($members as $m): ?>
                                <option value="<?= esc($m['id']) ?>" <?= $loan['user_id'] == $m['id'] ? 'selected' : '' ?> style="background: #131a26;">
                                    <?= esc($m['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Judul Buku</label>
                        <select name="book_id" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px;">
                            <option value="" disabled>-- Pilih Buku --</option>
                            <?php foreach ($books as $b): ?>
                                <option value="<?= esc($b['id']) ?>" <?= $loan['book_id'] == $b['id'] ? 'selected' : '' ?> style="background: #131a26;">
                                    <?= esc($b['title']) ?> (<?= esc($b['call_number']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Tanggal Pinjam</label>
                            <input type="date" name="borrow_date" value="<?= esc($loan['borrow_date']) ?>" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px;">
                        </div>
                        <div class="form-group">
                            <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Tenggat Waktu</label>
                            <input type="date" name="due_date" value="<?= esc($loan['due_date']) ?>" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Status</label>
                        <select name="status" required style="width: 100%; padding: 12px; font-size: 15px; font-weight: bold; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: var(--gold); border-radius: 6px;">
                            <option value="pending" <?= $loan['status'] == 'pending' ? 'selected' : '' ?> style="background: #131a26; color: #fff;">Menunggu</option>
                            <option value="active" <?= $loan['status'] == 'active' ? 'selected' : '' ?> style="background: #131a26; color: #fff;">Aktif</option>
                            <option value="returned" <?= $loan['status'] == 'returned' ? 'selected' : '' ?> style="background: #131a26; color: #fff;">Selesai (Dikembalikan)</option>
                            <option value="overdue" <?= $loan['status'] == 'overdue' ? 'selected' : '' ?> style="background: #131a26; color: #fff;">Terlambat</option>
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
