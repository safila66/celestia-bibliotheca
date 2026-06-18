<div class="table-responsive">
    <table class="table table-hover align-middle border-bottom">
        <thead style="background-color: #f1ebd9; color: #8b7355; border-bottom: 2px solid #d4b872;">
            <tr>
                <th scope="col" class="py-3">No</th>
                <th scope="col" class="py-3">Nama Kategori</th>
                <th scope="col" class="py-3">Deskripsi</th>
                <th scope="col" class="py-3 text-center">Jumlah Buku</th>
                <th scope="col" class="py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($categories)): ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted" style="font-style: italic;">
                        Belum ada kategori yang ditambahkan.
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach($categories as $row): ?>
                <tr>
                    <th scope="row" class="align-middle"><?= $no++ ?></th>
                    <td class="align-middle font-weight-bold" style="color: #5a4b81;">
                        <?= esc($row['nama_kategori']) ?> </td>
                    <td class="align-middle"><?= esc($row['deskripsi']) ?></td> <td class="align-middle text-center">
                        <span class="badge" style="background-color: #e6e2f1; color: #5a4b81; font-size: 14px;">
                            <?= esc($row['total_books']) ?> Buku 
                        </span>
                    </td>
                    <td class="align-middle text-center">
                        <button class="btn btn-sm btnEdit shadow-sm" data-id="<?= $row['id'] ?>" style="background-color: #d4b872; color: white;" title="Edit">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btnHapus shadow-sm text-white" data-id="<?= $row['id'] ?>" style="background-color: #a85858;" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>