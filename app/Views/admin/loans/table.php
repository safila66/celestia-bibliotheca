<table class="table table-bordered table-striped text-center">
    <div class="table-responsive">
    <table class="table table-hover align-middle border-bottom">
        <thead style="background-color: #f1ebd9; color: #8b7355; border-bottom: 2px solid #d4b872;">
            <tr>
                <th scope="col" class="py-3">No</th>
                <th scope="col" class="py-3">Peminjam</th>
                <th scope="col" class="py-3">Judul Buku</th>
                <th scope="col" class="py-3">Tanggal Pinjam</th>
                <th scope="col" class="py-3">Status</th>
                <th scope="col" class="py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($loans)): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted" style="font-style: italic;">
                        Belum ada catatan sirkulasi di arsip ini.
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach($loans as $row): ?>
                <tr>
                    <th scope="row" class="align-middle"><?= $no++ ?></th>
                    <td class="align-middle">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 35px; height: 35px; background-color: #e6e2f1; color: #5a4b81;">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <div class="font-weight-bold text-dark" style="font-family: serif;">
                                <?= esc($row['nama_peminjam']) ?> </div>
                        </div>
                    </td>
                    <td class="align-middle"><?= esc($row['judul_buku']) ?></td> <td class="align-middle"><?= date('d/m/Y', strtotime($row['tanggal_pinjam'])) ?></td> <td class="align-middle">
                        <?php if($row['status'] == 'Aktif'): ?>
                            <span class="badge text-success" style="background-color: #e6f4ea;">Aktif</span>
                        <?php else: ?>
                            <span class="badge text-secondary" style="background-color: #f1f3f4;">Selesai</span>
                        <?php endif; ?>
                    </td>
                    
                    <td class="align-middle text-center">
                        <button class="btn btn-sm btnEdit shadow-sm" data-id="<?= $row['id'] ?>" style="background-color: #d4b872; color: white;">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btnHapus shadow-sm text-white" data-id="<?= $row['id'] ?>" style="background-color: #a85858;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
    <thead class="bg-primary text-white">
        <tr>
            <th width="50">No.</th>
            <th>Nama Member</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($loan)) : ?>
            <?php $no = 1; foreach ($loan as $row) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td class="text-left font-weight-bold"><?= esc($row['name_member']) ?></td>
                    <td class="text-left font-italic"><?= esc($row['title_book']) ?></td>
                    <td><?= esc($row['tanggal_loan']) ?></td>
                    <td><?= esc($row['tanggal_kembali']) ?></td>
                    <td>
                        <button class="btn btn-info btn-sm btnEdit" data-id="<?= $row['id_loan'] ?>">Edit</button>
                        <a href="<?= base_url('delete/loan/' . $row['id_loan']) ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Hapus data loan ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6" class="text-center font-italic">Belum ada data loan buku.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>