<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
    <h2>📰 Manajemen Jurnal</h2>
    <div>
        <a href="<?= base_url('admin/list/journals/trash') ?>" class="btn-outline" style="color:#e07070; border-color:rgba(224,112,112,0.3); margin-right: 10px;">
            🗑️ Tong Sampah
        </a>
        <button class="btn-primary" onclick="createJournal()">+ Tulis Jurnal Baru</button>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div style="color: #7ec8a0; background: rgba(126,200,160,0.1); border: 1px solid rgba(126,200,160,0.3); padding: 12px; margin-bottom: 20px; border-radius: 4px;">
        ✦ <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div style="color: #e07070; background: rgba(224,112,112,0.1); border: 1px solid rgba(224,112,112,0.3); padding: 12px; margin-bottom: 20px; border-radius: 4px;">
        ✗ <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="card">
    <div style="margin-bottom: 20px; display: flex; gap: 10px;">
        <form action="<?= current_url() ?>" method="get" style="display: flex; gap: 10px; flex: 1;">
            <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari judul atau penulis..." 
                   style="flex: 1; padding: 10px 16px; background: var(--bg-body); border: 1px solid var(--border-gold); color: var(--text); border-radius: 4px; font-family: 'EB Garamond', serif;">
            <button type="submit" class="btn-outline">Cari</button>
            <?php if(!empty($keyword)): ?>
                <a href="<?= base_url('admin/list/journals') ?>" class="btn-outline" style="border:none;">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Cover</th>
                    <th width="30%">Judul</th>
                    <th width="15%">Kategori</th>
                    <th width="15%">Penulis</th>
                    <th width="10%">Tanggal</th>
                    <th width="15%" style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($journals)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: var(--text-muted); font-style: italic;">
                            Belum ada jurnal/artikel yang ditulis.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($journals as $j): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <?php if(!empty($j['cover_image'])): ?>
                                <img src="<?= base_url('assets/images/' . $j['cover_image']) ?>" alt="cover" style="height: 50px; border-radius: 4px; border: 1px solid var(--border-gold);">
                            <?php else: ?>
                                <div style="height: 50px; width: 40px; background: rgba(255,255,255,0.05); border: 1px dashed var(--border-gold); border-radius: 4px; display:flex; align-items:center; justify-content:center; font-size:10px;">No Cover</div>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight: bold; color: var(--gold);"><?= esc($j['title']) ?></td>
                        <td><span style="background: rgba(201,168,76,0.1); padding: 4px 8px; border-radius: 4px; font-size: 11px;"><?= esc($j['type']) ?></span></td>
                        <td><?= esc($j['author']) ?></td>
                        <td style="font-size: 12px; color: var(--text-muted);"><?= date('d M Y', strtotime($j['created_at'])) ?></td>
                        <td style="text-align:right;">
                            <button onclick="editJournal(<?= $j['id'] ?>)" class="btn-outline" style="padding: 6px 12px; font-size: 11px; margin-right: 5px;">Edit</button>
                            <a href="<?= base_url('admin/delete/journal/' . $j['id']) ?>" onclick="return confirm('Hapus artikel ini?')" class="btn-outline" style="padding: 6px 12px; font-size: 11px; color: #e07070; border-color: rgba(224,112,112,0.3);">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Container -->
<div id="createModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(4,6,15,0.8); backdrop-filter:blur(4px); z-index:999; align-items:center; justify-content:center;"></div>
<div id="editModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(4,6,15,0.8); backdrop-filter:blur(4px); z-index:999; align-items:center; justify-content:center;"></div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function createJournal() {
    $('#createModal').html('<div style="color:var(--gold); text-align:center;">Memuat gulungan naskah...</div>').css('display','flex');
    $.get('<?= base_url('admin/ajax/create/journal') ?>', function(html) {
        $('#createModal').html(html);
    });
}

function editJournal(id) {
    $('#editModal').html('<div style="color:var(--gold); text-align:center;">Membuka arsip...</div>').css('display','flex');
    $.get('<?= base_url('admin/ajax/edit/journal/') ?>' + id, function(html) {
        $('#editModal').html(html);
    });
}
</script>
<?= $this->endSection() ?>
