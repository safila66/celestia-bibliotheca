<div class="modal-dialog modal-lg" style="width: 90%; max-width: 900px; height: 90vh; margin: auto; display: flex; flex-direction: column;">
    
    <div class="modal-content" style="background: #0a0f18; border: 2px solid var(--gold); border-radius: 8px; box-shadow: 0 20px 50px rgba(0,0,0,0.95); display: flex; flex-direction: column; height: 100%; overflow: hidden;">
        
        <div class="modal-header" style="flex-shrink: 0; border-bottom: 1px solid rgba(201,168,76,0.3); padding: 15px 25px; display: flex; justify-content: space-between; align-items: center;">
            <h5 class="modal-title" style="color: var(--gold); font-family: 'Cinzel', serif; margin: 0; font-size: 22px; font-weight: bold;">Edit Data Anggota</h5>
            <button type="button" onclick="$('#editModal').hide()" style="background: none; border: none; color: var(--ivory); font-size: 2rem; cursor: pointer; line-height: 1;">
                &times;
            </button>
        </div>
        
        <form action="<?= base_url('admin/update/member/' . $member['id']) ?>" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; margin: 0;">
            <?= csrf_field(); ?>
            
            <div class="modal-body" style="flex-grow: 1; overflow-y: auto; padding: 25px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Nama Lengkap</label>
                        <input type="text" name="name" value="<?= esc($member['name']) ?>" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Email</label>
                        <input type="email" name="email" value="<?= esc($member['email']) ?>" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Telepon</label>
                        <input type="text" name="phone" value="<?= esc($member['phone'] ?? '') ?>" style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Status</label>
                        <select name="status" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box; cursor: pointer;">
                            <option value="active" <?= ($member['status'] === 'active') ? 'selected' : '' ?> style="color: #ffffff; background: #131a26;">Aktif</option>
                            <option value="inactive" <?= ($member['status'] === 'inactive') ? 'selected' : '' ?> style="color: #ffffff; background: #131a26;">Nonaktif</option>
                        </select>
                    </div>
                    
                    <div class="form-group" style="grid-column: span 2;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Alamat</label>
                        <textarea name="address" rows="3" style="width: 100%; padding: 12px; font-size: 15px; line-height: 1.5; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box;"><?= esc($member['address'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="form-group" style="grid-column: span 2;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Ganti Foto Profil (Opsional)</label>
                        
                        <?php if(!empty($member['photo'])): ?>
                            <div style="margin-bottom: 8px; color: #7ec8a0; font-size: 12px; font-style: italic;">✓ Anggota ini sudah memiliki foto profil. Unggah baru jika ingin menggantinya.</div>
                        <?php endif; ?>

                        <input type="file" name="photo" accept="image/*" style="width: 100%; padding: 10px; font-size: 14px; background: #131a26; border: 1px dashed rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box; cursor: pointer;">
                    </div>
                </div>
            </div>
            
            <div class="modal-footer" style="flex-shrink: 0; border-top: 1px solid rgba(201,168,76,0.3); padding: 15px 25px; text-align: right; background: #070a11;">
                <button type="button" onclick="$('#editModal').hide()" style="background: transparent; color: var(--gold); border: 1px solid var(--gold); padding: 10px 20px; font-size: 14px; margin-right: 10px; cursor: pointer; border-radius: 4px; font-weight: bold;">Batal</button>
                <button type="submit" style="background: var(--gold); color: #04060f; padding: 10px 20px; font-size: 14px; border: none; font-weight: bold; cursor: pointer; border-radius: 4px;">Simpan Perubahan</button>
            </div>
            
        </form>
    </div>
</div>
