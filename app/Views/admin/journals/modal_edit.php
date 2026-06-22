<div style="background: var(--bg-card); padding: 30px; border-radius: 8px; border: 2px solid var(--gold); width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative;">
    <button type="button" onclick="$('#editModal').hide()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; color: var(--text-muted); font-size: 20px; cursor: pointer;">&times;</button>
    
    <h3 style="font-family: 'Cinzel', serif; color: var(--gold); margin-bottom: 20px; text-align: center;">Edit Jurnal: <?= esc($journal['title']) ?></h3>
    
    <form action="<?= base_url('admin/update/journal/' . $journal['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Judul Artikel</label>
                <input type="text" name="title" value="<?= esc($journal['title']) ?>" required style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(201,168,76,0.3); color:var(--ivory); font-family:'EB Garamond',serif; border-radius:4px;">
            </div>
            
            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Kategori / Jenis</label>
                <input type="text" name="type" value="<?= esc($journal['type']) ?>" required style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(201,168,76,0.3); color:var(--ivory); font-family:'EB Garamond',serif; border-radius:4px;">
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Penulis</label>
                <input type="text" name="author" value="<?= esc($journal['author']) ?>" required style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(201,168,76,0.3); color:var(--ivory); font-family:'EB Garamond',serif; border-radius:4px;">
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Buku yang Dibahas (Opsional)</label>
                <select name="book_id" style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(201,168,76,0.3); color:var(--text-dim); font-family:'EB Garamond',serif; border-radius:4px;">
                    <option value="">-- Tidak Terhubung ke Buku --</option>
                    <?php if(!empty($books)): ?>
                        <?php foreach($books as $b): ?>
                            <option value="<?= $b['id'] ?>" <?= ($journal['book_id'] == $b['id']) ? 'selected' : '' ?>><?= esc($b['title']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Gambar Cover Baru (Abaikan jika tidak ingin mengubah)</label>
                <input type="file" name="cover_image" accept="image/*" style="width:100%; padding:8px; background:var(--bg-body); border:1px solid rgba(201,168,76,0.3); color:var(--text-dim); font-size: 13px; border-radius:4px;">
                <?php if(!empty($journal['cover_image'])): ?>
                    <div style="margin-top: 5px; font-size: 11px; color: var(--gold-dim);">Cover saat ini: <?= esc($journal['cover_image']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Ringkasan (Excerpt)</label>
            <textarea name="excerpt" rows="3" required style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(201,168,76,0.3); color:var(--ivory); font-family:'EB Garamond',serif; border-radius:4px; resize:vertical;"><?= esc($journal['excerpt']) ?></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 30px;">
            <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Isi Artikel Lengkap (HTML Didukung)</label>
            <textarea name="content" rows="10" required style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(201,168,76,0.3); color:var(--ivory); font-family:'EB Garamond',serif; border-radius:4px; resize:vertical; line-height:1.5;"><?= esc($journal['content']) ?></textarea>
        </div>
        
        <div style="text-align: right; display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" onclick="$('#editModal').hide()" class="btn-outline">Batal</button>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
