<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
    <h3 class="section-title" style="margin-bottom: 0; border: none; padding: 0;">MY LISTS</h3>
    <button style="background: rgba(255,255,255,0.1); color: var(--gold); border: 1px solid var(--gold); padding: 4px 12px; border-radius: 4px; font-family: 'Raleway', sans-serif; font-size: 10px; cursor: pointer; text-transform: uppercase; letter-spacing: 0.1em;" onclick="document.getElementById('createListModal').style.display='flex'">+ New List</button>
</div>
<hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin-bottom: 24px;">

<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
    <?php if (!empty($lists)): ?>
        <?php foreach ($lists as $list): ?>
            <div onclick="window.location.href='<?= base_url('profil/list/' . $list['id']) ?>'" style="background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
                <!-- Placeholder for list covers (stacked effect could be implemented here) -->
                <div style="height: 100px; background: linear-gradient(135deg, rgba(168,117,42,0.2), rgba(229,192,107,0.1)); display: flex; align-items: center; justify-content: center; position: relative;">
                    <i class="fas fa-layer-group" style="font-size: 32px; color: rgba(255,255,255,0.1);"></i>
                </div>
                <div style="padding: 16px;">
                    <div style="font-family: 'Cinzel', serif; font-size: 14px; color: var(--gold); margin-bottom: 4px; font-weight: bold;"><?= esc($list['title']) ?></div>
                    <div style="font-size: 12px; color: #A0A0A0; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        <?= esc($list['description']) ?>
                    </div>
                    <div style="font-size: 10px; color: #666; font-family: 'Raleway', sans-serif;">
                        Dibuat <?= date('d M Y', strtotime($list['created_at'])) ?>
                        <?= $list['is_public'] ? '• <i class="fas fa-globe"></i> Publik' : '• <i class="fas fa-lock"></i> Privat' ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; font-size: 13px; grid-column: span 3;">Belum ada daftar yang dibuat.</p>
    <?php endif; ?>
</div>

<!-- Modal Create List -->
<div id="createListModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:var(--bg-card); border:1px solid var(--border-gold); padding:30px; border-radius:8px; width:400px; color:#fff;">
        <h3 style="font-family:'Cinzel', serif; color:var(--gold); margin-top:0;">Buat List Baru</h3>
        <form id="createListForm" onsubmit="submitCreateList(event)">
            <?= csrf_field() ?>
            <div style="margin-bottom: 15px;">
                <label style="display:block; font-size:12px; color:#CCC; margin-bottom:5px;">Nama List *</label>
                <input type="text" name="title" required style="width:100%; padding:8px; background:rgba(0,0,0,0.5); border:1px solid rgba(255,255,255,0.2); color:#fff; border-radius:4px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display:block; font-size:12px; color:#CCC; margin-bottom:5px;">Deskripsi</label>
                <textarea name="description" rows="3" style="width:100%; padding:8px; background:rgba(0,0,0,0.5); border:1px solid rgba(255,255,255,0.2); color:#fff; border-radius:4px;"></textarea>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display:block; font-size:12px; color:#CCC; margin-bottom:5px;">Privasi</label>
                <select name="is_public" style="width:100%; padding:8px; background:rgba(0,0,0,0.5); border:1px solid rgba(255,255,255,0.2); color:#fff; border-radius:4px;">
                    <option value="1">Publik (Bisa dilihat orang lain)</option>
                    <option value="0">Privat (Hanya untuk saya)</option>
                </select>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="document.getElementById('createListModal').style.display='none'" style="padding:8px 16px; background:transparent; color:#CCC; border:none; cursor:pointer;">Batal</button>
                <button type="submit" style="padding:8px 16px; background:var(--gold); color:#000; border:none; border-radius:4px; font-weight:bold; cursor:pointer;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function submitCreateList(e) {
    e.preventDefault();
    const form = document.getElementById('createListForm');
    const formData = new FormData(form);

    fetch('<?= base_url('profil/list/create') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('List berhasil dibuat!');
            window.location.reload();
        } else {
            alert(data.message || 'Gagal membuat list.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan pada server.');
    });
}
</script>
