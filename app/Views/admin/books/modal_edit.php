<div class="modal-dialog modal-lg" style="width: 90%; max-width: 900px; height: 90vh; margin: auto; display: flex; flex-direction: column;">
    
    <div class="modal-content" style="background: #0a0f18; border: 2px solid var(--gold); border-radius: 8px; box-shadow: 0 20px 50px rgba(0,0,0,0.95); display: flex; flex-direction: column; height: 100%; overflow: hidden;">
        
        <div class="modal-header" style="flex-shrink: 0; border-bottom: 1px solid rgba(201,168,76,0.3); padding: 15px 25px; display: flex; justify-content: space-between; align-items: center;">
            <h5 class="modal-title" style="color: var(--gold); font-family: 'Cinzel', Bookman Old Style; margin: 0; font-size: 22px; font-weight: bold;">Edit Data Buku</h5>
            <button type="button" onclick="$('#editModal').hide()" style="background: none; border: none; color: var(--ivory); font-size: 2rem; cursor: pointer; line-height: 1;">
                &times;
            </button>
        </div>
        
        <form action="<?= base_url('admin/update/book/' . $book['id']) ?>" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; margin: 0;">
            <?= csrf_field(); ?>
            
            <div class="modal-body" style="flex-grow: 1; overflow-y: auto; padding: 25px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Call Number</label>
                        <input type="text" name="call_number" value="<?= esc($book['call_number']) ?>" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">ISBN</label>
                        <input type="text" name="isbn" value="<?= esc($book['isbn']) ?>" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 2;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Kategori Buku</label>
                        <select name="category_id" required style="width: 100%; padding: 12px; font-size: 15px; font-weight: bold; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box; cursor: pointer;">
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $book['category_id'] == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Judul Buku</label>
                        <input type="text" name="title" value="<?= esc($book['title']) ?>" required style="width: 100%; padding: 12px; font-size: 15px; font-weight: bold; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Penulis</label>
                        <input type="text" name="author" value="<?= esc($book['author']) ?>" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Penerbit</label>
                        <input type="text" name="publisher" value="<?= esc($book['publisher']) ?>" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Tahun Terbit</label>
                        <input type="number" name="year" value="<?= esc($book['year']) ?>" required style="width: 100%; padding: 12px; font-size: 15px; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 1;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Stok Buku</label>
                        <input type="number" name="stock_available" value="<?= esc($book['stock_available']) ?>" required style="width: 100%; padding: 12px; font-size: 15px; font-weight: bold; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: #7ec8a0; border-radius: 6px; box-sizing: border-box;">
                    </div>

                    <?php 
                    $predefinedGenres = ['fiction', 'mystery', 'romance', 'dark', 'classic', 'historical', 'fantasy', 'sci-fi', 'thriller', 'contemporary', 'non-fiction', 'poetry', 'biography', 'action', 'adventure', 'politics', 'friendship', 'arts', 'psychology', 'philosophy', 'religion', 'science', 'technology', 'business', 'economics'];
                    $currentGenres = explode(',', $book['genres'] ?? '');
                    ?>
                    <div class="form-group" style="grid-column: span 2;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Genres (Bisa pilih lebih dari satu)</label>
                        <div style="display:flex; flex-wrap:wrap; gap:12px;">
                            <?php foreach($predefinedGenres as $genre): ?>
                                <label style="color: white; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                    <input type="checkbox" name="genres[]" value="<?= $genre ?>" style="accent-color: var(--gold);" <?= in_array($genre, $currentGenres) ? 'checked' : '' ?>> <?= ucfirst($genre) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="form-group" style="grid-column: span 2;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Keterangan / Deskripsi</label>
                        <textarea name="description" rows="5" style="width: 100%; padding: 12px; font-size: 15px; line-height: 1.5; background: #131a26; border: 1px solid rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box;"><?= esc($book['description']) ?></textarea>
                    </div>
                    
                    <div class="form-group" style="grid-column: span 2;">
                        <label style="color: var(--gold-dim); font-size: 13px; font-weight: bold; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 8px; display: block;">Ganti Sampul Buku (Opsional)</label>
                        
                        <!-- Menampilkan info jika buku sudah punya sampul -->
                        <?php if(!empty($book['cover_image'])): ?>
                            <div style="margin-bottom: 8px; color: #7ec8a0; font-size: 12px; font-style: italic;">✓ Buku ini sudah memiliki sampul. Unggah baru jika ingin menggantinya.</div>
                        <?php endif; ?>

                        <input type="file" name="cover_image" accept="image/*" style="width: 100%; padding: 10px; font-size: 14px; background: #131a26; border: 1px dashed rgba(201,168,76,0.5); color: white; border-radius: 6px; box-sizing: border-box; cursor: pointer;">
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
