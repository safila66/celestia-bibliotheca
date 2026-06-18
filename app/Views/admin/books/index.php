<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<!-- HEADER HALAMAN & SEARCH BAR -->
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 15px;">
    <h2 style="font-family: 'Cinzel', serif; color: var(--gold); font-weight: bold; margin: 0; font-size: 24px;">Manajemen Koleksi</h2>
    
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        
        <!-- SEARCH BAR ELEGANT -->
        <form action="" method="GET" style="display: flex; gap: 5px; margin: 0;">
            <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari judul / penulis..." style="padding: 8px 15px; background: rgba(201,168,76,0.05); border: 1px solid var(--gold); color: var(--gold); border-radius: 4px; font-size: 13px; outline: none; width: 220px;">
            <button type="submit" style="background: var(--gold); color: #04060f; border: none; padding: 8px 12px; border-radius: 4px; font-weight: bold; cursor: pointer;">🔍 Cari</button>
            
            <!-- Tombol Reset Pencarian (muncul jika sedang mencari sesuatu) -->
            <?php if(!empty($keyword)): ?>
                <a href="<?= base_url('admin/books') ?>" style="border: 1px solid #963c3c; color: #963c3c; padding: 8px 12px; border-radius: 4px; font-weight: bold; text-decoration: none; display: flex; align-items: center;">✖ Reset</a>
            <?php endif; ?>
        </form>

        <a href="<?= base_url('admin/book/trash') ?>" style="padding: 8px 16px; text-decoration: none; border: 1px solid var(--gold); color: var(--gold); border-radius: 4px; font-weight: bold;">🗑️ Tong Sampah</a>
        
        <a href="javascript:void(0);" onclick="createBook()" style="padding: 8px 16px; background: var(--gold); color: #04060f; border: none; font-weight: bold; text-decoration: none; border-radius: 4px;">+ Tambah Buku</a>
    </div>
</div>

<!-- TABEL SPREADSHEET (Mewarisi background aslimu) -->
<div class="card" style="background: var(--deep-navy); padding: 20px; border-radius: 8px; border: 1px solid rgba(201,168,76,0.3);">
    <div class="table-wrap" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--ivory); min-width: 1100px;">
            
            <!-- KEPALA TABEL -->
            <thead>
                <tr style="border-bottom: 2px solid var(--gold); background: rgba(201,168,76,0.1);">
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">No</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase; text-align: center;">Sampul</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Call Number</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">ISBN</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Judul Buku</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Penulis</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Penerbit</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Tahun Terbit</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Kategori</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Stok</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            
            <!-- ISI TABEL -->
            <tbody>
                <?php if (!empty($books)): ?>
                    <?php $i = 1; foreach ($books as $book): ?>
                    <tr style="border-bottom: 1px solid rgba(201,168,76,0.2); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                        
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px;"><?= $i++ ?></td>
                        
                        <!-- Sampul -->
                        <td style="padding: 12px 10px; text-align: center;">
                            <?php if(!empty($book['cover_image'])): ?>
                                <img src="<?= base_url('uploads/covers/' . $book['cover_image']) ?>" alt="Cover" style="width: 40px; height: 55px; object-fit: cover; border-radius: 4px; border: 1px solid var(--gold-dim);" onerror="this.style.display='none'">
                            <?php else: ?>
                                <div style="width: 40px; height: 55px; background: rgba(0,0,0,0.1); border: 1px dashed var(--gold-dim); display: inline-flex; align-items: center; justify-content: center; font-size: 16px; border-radius: 4px; margin: auto;">📖</div>
                            <?php endif; ?>
                        </td>

                        <!-- Call Number & ISBN -->
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px; font-weight: bold;"><?= esc($book['call_number']) ?></td>
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px;"><?= esc($book['isbn']) ?></td>

                        <!-- Judul Buku -->
                        <td style="padding: 12px 10px;">
                            <div style="font-family: 'Cinzel', serif; font-size: 14px; font-weight: 600; color: var(--gold);"><?= esc($book['title']) ?></div>
                        </td>

                        <!-- Penulis -->
                        <td style="padding: 12px 10px; color: var(--text-dim); font-size: 13px; font-style: italic;">
                            <?= esc($book['author']) ?>
                        </td>

                        <!-- Penerbit (DIPISAH) -->
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px;">
                            <?= esc($book['publisher']) ?>
                        </td>

                        <!-- Tahun Terbit (DIPISAH) -->
                        <td style="padding: 12px 10px; color: var(--text-dim); font-size: 13px;">
                            <?= esc($book['year']) ?>
                        </td>

                        <!-- Kategori -->
                        <td style="padding: 12px 10px;">
                            <span style="background: rgba(201,168,76,0.1); border: 1px solid rgba(201,168,76,0.3); padding: 4px 8px; border-radius: 15px; font-size: 11px; color: var(--gold); white-space: nowrap;">
                                <?= esc($book['category_name'] ?? 'Uncategorized') ?>
                            </span>
                        </td>

                        <!-- Stok -->
                        <td style="padding: 12px 10px;">
                            <?php if ($book['stock_available'] > 0): ?>
                                <span style="color: #7ec8a0; font-weight: bold; font-size: 13px;"><?= esc($book['stock_available']) ?></span>
                            <?php else: ?>
                                <span style="color: #e07070; font-weight: bold; font-size: 13px;">0</span>
                            <?php endif; ?>
                        </td>

                        <!-- Aksi -->
                        <td style="padding: 12px 10px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <button onclick="editBook(<?= $book['id'] ?>)" style="background: #c9a84c; color: #04060f; border: none; padding: 6px 10px; border-radius: 4px; font-size: 11px; cursor: pointer; font-weight: bold;">✏️</button>
                                
                                <a href="<?= base_url('admin/delete/book/' . $book['id']) ?>" style="background: #963c3c; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none; font-size: 11px; font-weight: bold;" onclick="return confirm('Apakah Anda yakin ingin membuang volume ini ke tong sampah?')">🗑️</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" style="text-align: center; padding: 40px; color: var(--text-dim); font-style: italic;">
                            <div style="font-size: 40px; margin-bottom: 10px;">🌌</div>
                            Tidak ada data arsip yang ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ========================================== -->
<!-- WADAH POP-UP UNTUK EDIT & TAMBAH BUKU -->
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
    function editBook(id) {
        $('#editModal').css('display', 'flex');
        $('#editFormContent').html('<div style="color:var(--gold); padding:20px; background: var(--deep-navy); border: 1px solid var(--gold); border-radius: 8px;">Memuat gulungan arsip... ⏳</div>');
        
        $.ajax({
            url: "<?= base_url('admin/ajax/edit/book/') ?>" + id,
            type: "GET",
            success: function(response) {
                $('#editFormContent').html(response);
            },
            error: function(xhr) {
                $('#editFormContent').html('<div style="background: #fff; color: #000; padding: 20px; border-radius: 8px;">' + xhr.responseText + '</div>');
            }
        });
    }

    function createBook() {
        $('#createModal').css('display', 'flex');
        $('#createFormContent').html('<div style="color:#7ec8a0; padding:20px; background: var(--deep-navy); border: 1px solid #7ec8a0; border-radius: 8px;">Mempersiapkan formulir baru... ⏳</div>');
        
        $.ajax({
            url: "<?= base_url('admin/ajax/create/book') ?>",
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