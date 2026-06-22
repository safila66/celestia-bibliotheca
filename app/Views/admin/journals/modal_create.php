<div style="background: var(--bg-card); padding: 30px; border-radius: 8px; border: 2px solid #7ec8a0; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative;">
    <button type="button" onclick="$('#createModal').hide()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; color: var(--text-muted); font-size: 20px; cursor: pointer;">&times;</button>
    
    <h3 style="font-family: 'Cinzel', serif; color: #7ec8a0; margin-bottom: 20px; text-align: center;">Tulis Jurnal Baru</h3>
    
    <form action="<?= base_url('admin/create/journal') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Judul Artikel</label>
                <input type="text" name="title" required style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(126,200,160,0.3); color:var(--ivory); font-family:'EB Garamond',serif; border-radius:4px;">
            </div>
            
            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Kategori / Jenis</label>
                <input type="text" name="type" placeholder="Contoh: Review, Interview, List" required style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(126,200,160,0.3); color:var(--ivory); font-family:'EB Garamond',serif; border-radius:4px;">
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Penulis</label>
                <input type="text" name="author" value="<?= session()->get('name') ?>" required style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(126,200,160,0.3); color:var(--ivory); font-family:'EB Garamond',serif; border-radius:4px;">
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Buku yang Dibahas (Opsional)</label>
                <select name="book_id" style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(126,200,160,0.3); color:var(--text-dim); font-family:'EB Garamond',serif; border-radius:4px;">
                    <option value="">-- Tidak Terhubung ke Buku --</option>
                    <?php if(!empty($books)): ?>
                        <?php foreach($books as $b): ?>
                            <option value="<?= $b['id'] ?>"><?= esc($b['title']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Gambar Cover</label>
                <input type="file" name="cover_image" accept="image/*" style="width:100%; padding:8px; background:var(--bg-body); border:1px solid rgba(126,200,160,0.3); color:var(--text-dim); font-size: 13px; border-radius:4px;">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Ringkasan (Excerpt) - Ditampilkan di halaman depan</label>
            <textarea name="excerpt" rows="3" required style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(126,200,160,0.3); color:var(--ivory); font-family:'EB Garamond',serif; border-radius:4px; resize:vertical;"></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 30px;">
            <label style="display:block; margin-bottom:8px; font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">Isi Artikel Lengkap (HTML Didukung)</label>
            <textarea name="content" rows="10" required style="width:100%; padding:10px; background:var(--bg-body); border:1px solid rgba(126,200,160,0.3); color:var(--ivory); font-family:'EB Garamond',serif; border-radius:4px; resize:vertical; line-height:1.5;"></textarea>
        </div>
        
        <div style="text-align: right; display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" onclick="$('#createModal').hide()" class="btn-outline">Batal</button>
            <button type="submit" class="btn-primary" style="background:#7ec8a0; border-color:#7ec8a0; color:#04060f;">Publikasikan</button>
        </div>
    </form>
</div>
