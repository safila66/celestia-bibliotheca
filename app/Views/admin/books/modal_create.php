<div class="modal-dialog modal-lg" style="width: 90%; max-width: 900px; height: 90vh; margin: auto; display: flex; flex-direction: column;">
    
    <div class="modal-content" style="background: #0a0f18; border: 2px solid #7ec8a0; border-radius: 8px; box-shadow: 0 20px 50px rgba(0,0,0,0.95); display: flex; flex-direction: column; height: 100%; overflow: hidden;">
        
        <div class="modal-header" style="flex-shrink: 0; border-bottom: 1px solid rgba(126,200,160,0.3); padding: 15px 25px; display: flex; justify-content: space-between; align-items: center;">
            <h5 class="modal-title" style="color: #7ec8a0; font-family: 'Cinzel', serif; margin: 0; font-size: 22px; font-weight: bold;">+ Tambah Volume Baru</h5>
            <button type="button" onclick="$('#createModal').hide()" style="background: none; border: none; color: #ffffff; font-size: 2rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        
        <form action="<?= base_url('admin/create/book') ?>" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; margin: 0;">
            <?= csrf_field(); ?>
            
            <div class="modal-body" style="flex-grow: 1; overflow-y: auto; padding: 25px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Call Number</label>
                        <input type="text" name="call_number" required style="width: 100%; padding: 12px; font-size: 15px; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ffffff !important; border-radius: 6px; box-sizing: border-box;">
                    </div>

                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Kategori / Konstelasi</label>
                        <select name="category_id" required style="width: 100%; padding: 12px; font-size: 15px; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ffffff !important; border-radius: 6px; box-sizing: border-box; cursor: pointer;">
                            <option value="" disabled selected style="color: #a0aec0; background: #1a2332;">-- Pilih Kategori --</option>
                            <?php if(!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= esc($cat['id']) ?>" style="color: #ffffff; background: #1a2332;"><?= esc($cat['name']) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled style="color: #e07070; background: #1a2332;">⚠️ Belum ada kategori di database!</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">ISBN</label>
                        <input type="text" name="isbn" required style="width: 100%; padding: 12px; font-size: 15px; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ffffff !important; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Judul Buku</label>
                        <input type="text" name="title" required style="width: 100%; padding: 12px; font-size: 15px; font-weight: bold; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ffffff !important; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Penulis</label>
                        <input type="text" name="author" required style="width: 100%; padding: 12px; font-size: 15px; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ffffff !important; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Penerbit</label>
                        <input type="text" name="publisher" required style="width: 100%; padding: 12px; font-size: 15px; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ffffff !important; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Tahun Terbit</label>
                        <input type="number" name="year" required style="width: 100%; padding: 12px; font-size: 15px; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ffffff !important; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Jumlah Stok</label>
                        <input type="number" name="stock_available" required style="width: 100%; padding: 12px; font-size: 15px; font-weight: bold; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #7ec8a0 !important; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 2;">
                        <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Keterangan / Deskripsi</label>
                        <textarea name="description" rows="3" style="width: 100%; padding: 12px; font-size: 15px; line-height: 1.5; background: #1a2332; border: 1px solid rgba(126,200,160,0.5); color: #ffffff !important; border-radius: 6px; box-sizing: border-box;"></textarea>
                    </div>
                    
                    <div class="form-group" style="grid-column: span 2;">
                        <label style="color: #e2e8f0; font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Unggah Sampul Buku (Opsional)</label>
                        <input type="file" name="cover_image" accept="image/*" style="width: 100%; padding: 10px; font-size: 14px; background: #1a2332; border: 1px dashed rgba(126,200,160,0.5); color: #ffffff !important; border-radius: 6px; box-sizing: border-box; cursor: pointer;">
                        <small style="color: #a0aec0; font-size: 11px; margin-top: 5px; display: block;">*Format: JPG, JPEG, PNG.</small>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer" style="flex-shrink: 0; border-top: 1px solid rgba(126,200,160,0.3); padding: 15px 25px; text-align: right; background: #070a11;">
                <button type="button" onclick="$('#createModal').hide()" style="background: transparent; color: #7ec8a0; border: 1px solid #7ec8a0; padding: 10px 20px; font-size: 14px; margin-right: 10px; cursor: pointer; border-radius: 4px; font-weight: bold;">Batal</button>
                <button type="submit" style="background: #7ec8a0; color: #04060f; padding: 10px 20px; font-size: 14px; border: none; font-weight: bold; cursor: pointer; border-radius: 4px;">Simpan Buku</button>
            </div>
            
        </form>
    </div>
</div>