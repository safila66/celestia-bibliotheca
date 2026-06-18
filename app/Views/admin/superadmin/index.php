<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<!-- HEADER HALAMAN & SEARCH BAR -->
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 15px;">
    <h2 style="font-family: 'Cinzel', serif; color: var(--gold); font-weight: bold; margin: 0; font-size: 24px;">Manajemen Admin</h2>
    
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        
        <!-- SEARCH BAR & FILTER STATUS -->
        <form action="" method="GET" style="display: flex; gap: 5px; margin: 0;">
            <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama / email..." style="padding: 8px 15px; background: rgba(201,168,76,0.05); border: 1px solid var(--gold); color: var(--gold); border-radius: 4px; font-size: 13px; outline: none; width: 220px;">
            
            <select name="status" style="padding: 8px 12px; background: rgba(201,168,76,0.05); border: 1px solid var(--gold); color: var(--gold); border-radius: 4px; font-size: 13px; outline: none; cursor: pointer;">
                <option value="" style="background: var(--deep); color: var(--text);">Semua Status</option>
                <option value="active" <?= (isset($status) && $status === 'active') ? 'selected' : '' ?> style="background: var(--deep); color: var(--text);">Aktif</option>
                <option value="inactive" <?= (isset($status) && $status === 'inactive') ? 'selected' : '' ?> style="background: var(--deep); color: var(--text);">Nonaktif</option>
            </select>
            
            <button type="submit" style="background: var(--gold); color: #04060f; border: none; padding: 8px 12px; border-radius: 4px; font-weight: bold; cursor: pointer;">🔍 Cari</button>
            
            <!-- Tombol Reset Pencarian -->
            <?php if(!empty($keyword) || !empty($status)): ?>
                <a href="<?= base_url('admin/list/superadmin') ?>" style="border: 1px solid #963c3c; color: #963c3c; padding: 8px 12px; border-radius: 4px; font-weight: bold; text-decoration: none; display: flex; align-items: center;">✖ Reset</a>
            <?php endif; ?>
        </form>

        <a href="<?= base_url('admin/list/superadmin/trash') ?>" style="padding: 8px 16px; text-decoration: none; border: 1px solid var(--gold); color: var(--gold); border-radius: 4px; font-weight: bold;">🗑️ Tong Sampah</a>
        
        <a href="javascript:void(0);" onclick="createAdmin()" style="padding: 8px 16px; background: var(--gold); color: #04060f; border: none; font-weight: bold; text-decoration: none; border-radius: 4px;">+ Tambah Admin</a>
    </div>
</div>

<!-- TABEL DATA ADMIN -->
<div class="card" style="background: var(--deep-navy); padding: 20px; border-radius: 8px; border: 1px solid rgba(201,168,76,0.3);">
    <div class="table-wrap" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--ivory); min-width: 800px;">
            
            <!-- KEPALA TABEL -->
            <thead>
                <tr style="border-bottom: 2px solid var(--gold); background: rgba(201,168,76,0.1);">
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">No</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Nama</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Email</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Telepon</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Status</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            
            <!-- ISI TABEL -->
            <tbody>
                <?php if (!empty($admins)): ?>
                    <?php $i = 1; foreach ($admins as $admin): ?>
                    <tr style="border-bottom: 1px solid rgba(201,168,76,0.2); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                        
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px;"><?= $i++ ?></td>
                        
                        <!-- Nama -->
                        <td style="padding: 12px 10px;">
                            <div style="font-family: 'Cinzel', serif; font-size: 14px; font-weight: 600; color: var(--gold);"><?= esc($admin['name']) ?></div>
                        </td>

                        <!-- Email -->
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px;">
                            <?= esc($admin['email']) ?>
                        </td>

                        <!-- Telepon -->
                        <td style="padding: 12px 10px; color: var(--text-dim); font-size: 13px;">
                            <?= esc($admin['phone'] ?? '-') ?>
                        </td>

                        <!-- Status -->
                        <td style="padding: 12px 10px;">
                            <?php if ($admin['status'] === 'active'): ?>
                                <span class="badge badge-ok" style="background: rgba(74,122,58,0.15); color: #7ec8a0; border: 1px solid #7ec8a0; padding: 4px 10px; border-radius: 15px; font-size: 11px; white-space: nowrap;">● Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-danger" style="background: rgba(160,48,48,0.15); color: #e07070; border: 1px solid #e07070; padding: 4px 10px; border-radius: 15px; font-size: 11px; white-space: nowrap;">● Nonaktif</span>
                            <?php endif; ?>
                        </td>

                        <!-- Aksi -->
                        <td style="padding: 12px 10px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <button onclick="editAdmin(<?= $admin['id'] ?>)" style="background: #c9a84c; color: #04060f; border: none; padding: 6px 10px; border-radius: 4px; font-size: 11px; cursor: pointer; font-weight: bold;">✏️</button>
                                
                                <a href="<?= base_url('admin/delete/superadmin/' . $admin['id']) ?>" style="background: #963c3c; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none; font-size: 11px; font-weight: bold;" onclick="return confirm('Apakah Anda yakin ingin membuang admin ini ke tong sampah?')">🗑️</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-dim); font-style: italic;">
                            <div style="font-size: 40px; margin-bottom: 10px;">🌌</div>
                            Tidak ada data admin yang ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ========================================== -->
<!-- WADAH POP-UP UNTUK EDIT & TAMBAH ADMIN -->
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
    function editAdmin(id) {
        $('#editModal').css('display', 'flex');
        $('#editFormContent').html('<div style="color:var(--gold); padding:20px; background: var(--deep-navy); border: 1px solid var(--gold); border-radius: 8px;">Memuat data admin... ⏳</div>');
        
        $.ajax({
            url: "<?= base_url('admin/ajax/edit/superadmin/') ?>" + id,
            type: "GET",
            success: function(response) {
                $('#editFormContent').html(response);
            },
            error: function(xhr) {
                $('#editFormContent').html('<div style="background: #fff; color: #000; padding: 20px; border-radius: 8px;">' + xhr.responseText + '</div>');
            }
        });
    }

    function createAdmin() {
        $('#createModal').css('display', 'flex');
        $('#createFormContent').html('<div style="color:#7ec8a0; padding:20px; background: var(--deep-navy); border: 1px solid #7ec8a0; border-radius: 8px;">Mempersiapkan formulir baru... ⏳</div>');
        
        $.ajax({
            url: "<?= base_url('admin/ajax/create/superadmin') ?>",
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
