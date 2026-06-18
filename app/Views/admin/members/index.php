<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<!-- HEADER HALAMAN & SEARCH BAR -->
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 15px;">
    <h2 style="font-family: 'Cinzel', serif; color: var(--gold); font-weight: bold; margin: 0; font-size: 24px;">Manajemen Anggota</h2>
    
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        
        <!-- SEARCH BAR -->
        <form action="" method="GET" style="display: flex; gap: 5px; margin: 0;">
            <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama / email..." style="padding: 8px 15px; background: rgba(201,168,76,0.05); border: 1px solid var(--gold); color: var(--gold); border-radius: 4px; font-size: 13px; outline: none; width: 220px;">
            <button type="submit" style="background: var(--gold); color: #04060f; border: none; padding: 8px 12px; border-radius: 4px; font-weight: bold; cursor: pointer;">🔍 Cari</button>
            
            <?php if(!empty($keyword)): ?>
                <a href="<?= base_url('admin/list/members') ?>" style="border: 1px solid #963c3c; color: #963c3c; padding: 8px 12px; border-radius: 4px; font-weight: bold; text-decoration: none; display: flex; align-items: center;">✖ Reset</a>
            <?php endif; ?>
        </form>

        <a href="<?= base_url('admin/list/members/trash') ?>" style="padding: 8px 16px; text-decoration: none; border: 1px solid var(--gold); color: var(--gold); border-radius: 4px; font-weight: bold;">🗑️ Tong Sampah</a>
        
        <a href="javascript:void(0);" onclick="createMember()" style="padding: 8px 16px; background: var(--gold); color: #04060f; border: none; font-weight: bold; text-decoration: none; border-radius: 4px;">+ Tambah Anggota</a>
    </div>
</div>

<!-- TABEL ANGGOTA -->
<div class="card" style="background: var(--deep-navy); padding: 20px; border-radius: 8px; border: 1px solid rgba(201,168,76,0.3);">
    <div class="table-wrap" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--ivory); min-width: 900px;">
            
            <!-- KEPALA TABEL -->
            <thead>
                <tr style="border-bottom: 2px solid var(--gold); background: rgba(201,168,76,0.1);">
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">No</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase; text-align: center;">Foto</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Nama</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Email</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Telepon</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Alamat</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Status</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            
            <!-- ISI TABEL -->
            <tbody>
                <?php if (!empty($members)): ?>
                    <?php $i = 1; foreach ($members as $member): ?>
                    <tr style="border-bottom: 1px solid rgba(201,168,76,0.2); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                        
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px;"><?= $i++ ?></td>
                        
                        <!-- Foto -->
                        <td style="padding: 12px 10px; text-align: center;">
                            <?php if(!empty($member['photo'])): ?>
                                <img src="<?= base_url('uploads/profiles/' . $member['photo']) ?>" alt="Foto" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; border: 1px solid var(--gold-dim);" onerror="this.style.display='none'">
                            <?php else: ?>
                                <div style="width: 40px; height: 40px; background: rgba(0,0,0,0.1); border: 1px dashed var(--gold-dim); display: inline-flex; align-items: center; justify-content: center; font-size: 16px; border-radius: 50%; margin: auto;">👤</div>
                            <?php endif; ?>
                        </td>

                        <!-- Nama -->
                        <td style="padding: 12px 10px;">
                            <div style="font-family: 'Cinzel', serif; font-size: 14px; font-weight: 600; color: var(--gold);"><?= esc($member['name']) ?></div>
                        </td>

                        <!-- Email -->
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px;">
                            <?= esc($member['email']) ?>
                        </td>

                        <!-- Telepon -->
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px;">
                            <?= esc($member['phone'] ?? '-') ?>
                        </td>

                        <!-- Alamat -->
                        <td style="padding: 12px 10px; color: var(--text-dim); font-size: 13px; max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?= esc($member['address'] ?? '-') ?>
                        </td>

                        <!-- Status -->
                        <td style="padding: 12px 10px;">
                            <?php if ($member['status'] === 'active'): ?>
                                <span style="background: rgba(126,200,160,0.1); border: 1px solid rgba(126,200,160,0.3); padding: 4px 8px; border-radius: 15px; font-size: 11px; color: #7ec8a0; white-space: nowrap;">Aktif</span>
                            <?php else: ?>
                                <span style="background: rgba(224,112,112,0.1); border: 1px solid rgba(224,112,112,0.3); padding: 4px 8px; border-radius: 15px; font-size: 11px; color: #e07070; white-space: nowrap;">Nonaktif</span>
                            <?php endif; ?>
                        </td>

                        <!-- Aksi -->
                        <td style="padding: 12px 10px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <button onclick="editMember(<?= $member['id'] ?>)" style="background: #c9a84c; color: #04060f; border: none; padding: 6px 10px; border-radius: 4px; font-size: 11px; cursor: pointer; font-weight: bold;">✏️</button>
                                
                                <a href="<?= base_url('admin/delete/member/' . $member['id']) ?>" style="background: #963c3c; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none; font-size: 11px; font-weight: bold;" onclick="return confirm('Apakah Anda yakin ingin memindahkan anggota ini ke tong sampah?')">🗑️</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-dim); font-style: italic;">
                            <div style="font-size: 40px; margin-bottom: 10px;">🌌</div>
                            Tidak ada data anggota yang ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ========================================== -->
<!-- WADAH POP-UP UNTUK EDIT & TAMBAH ANGGOTA -->
<!-- ========================================== -->
<div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
    <div id="editFormContent" style="width: 100%; display: flex; justify-content: center;"></div>
</div>

<div id="createModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
    <div id="createFormContent" style="width: 100%; display: flex; justify-content: center;"></div>
</div>

<?= $this->endSection() ?>

<!-- ========================================== -->
<!-- SCRIPT UNTUK MEMANGGIL AJAX -->
<!-- ========================================== -->
<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function editMember(id) {
        $('#editModal').css('display', 'flex');
        $('#editFormContent').html('<div style="color:var(--gold); padding:20px; background: var(--deep-navy); border: 1px solid var(--gold); border-radius: 8px;">Memuat data anggota... ⏳</div>');
        
        $.ajax({
            url: "<?= base_url('admin/ajax/edit/members/') ?>" + id,
            type: "GET",
            success: function(response) {
                $('#editFormContent').html(response);
            },
            error: function(xhr) {
                $('#editFormContent').html('<div style="background: #fff; color: #000; padding: 20px; border-radius: 8px;">' + xhr.responseText + '</div>');
            }
        });
    }

    function createMember() {
        $('#createModal').css('display', 'flex');
        $('#createFormContent').html('<div style="color:#7ec8a0; padding:20px; background: var(--deep-navy); border: 1px solid #7ec8a0; border-radius: 8px;">Mempersiapkan formulir baru... ⏳</div>');
        
        $.ajax({
            url: "<?= base_url('admin/ajax/create/members') ?>",
            type: "GET",
            success: function(response) {
                $('#createFormContent').html(response);
            },
            error: function(xhr) {
                $('#createFormContent').html('<div style="background: #fff; color: #000; padding: 20px; border-radius: 8px;">' + xhr.responseText + '</div>');
            }
        });
    }
</script>
<?= $this->endSection() ?>