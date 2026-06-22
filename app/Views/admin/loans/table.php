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
            <?php if (empty($loans)): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted" style="font-style: italic;">
                        Belum ada catatan sirkulasi di arsip ini.
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($loans as $row): ?>
                <tr>
                    <th scope="row" class="align-middle"><?= $no++ ?></th>
                    <td class="align-middle">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 35px; height: 35px; background-color: #e6e2f1; color: #5a4b81;">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <div class="font-weight-bold text-dark" style="font-family: serif;">
                                <?= esc($row['user_name'] ?? '-') ?>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle"><?= esc($row['book_title'] ?? '-') ?></td>
                    <td class="align-middle"><?= !empty($row['borrow_date']) ? date('d/m/Y', strtotime($row['borrow_date'])) : '-' ?></td>
                    <td class="align-middle">
                        <?php
                            $statusMap = [
                                'pending'  => ['label' => 'Menunggu',  'bg' => '#fff3cd', 'fg' => '#8a6d3b'],
                                'active'   => ['label' => 'Aktif',     'bg' => '#e6f4ea', 'fg' => '#3a6030'],
                                'returned' => ['label' => 'Selesai',   'bg' => '#f1f3f4', 'fg' => '#5a4828'],
                                'overdue'  => ['label' => 'Terlambat', 'bg' => '#fae3e3', 'fg' => '#a03030'],
                            ];
                            $s = $statusMap[$row['status']] ?? ['label' => esc($row['status']), 'bg' => '#f1f3f4', 'fg' => '#5a4828'];
                        ?>
                        <span class="badge" style="background-color: <?= $s['bg'] ?>; color: <?= $s['fg'] ?>;"><?= $s['label'] ?></span>
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
