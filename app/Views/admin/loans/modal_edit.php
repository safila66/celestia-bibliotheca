<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit Data Peminjaman</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            
            <form action="<?= base_url('update/loan/' . $loan['id_loan']) ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label>Nama Member</label>
                        <select name="id_member" class="form-control" required>
                            <option value="">-- Pilih Member --</option>
                            <?php foreach ($members as $m) : ?>
                                <option value="<?= $m['id_member'] ?>" <?= $loan['id_member'] == $m['id_member'] ? 'selected' : '' ?>>
                                    <?= esc($m['name_member']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Judul Buku</label>
                        <select name="id_book" class="form-control" required>
                            <option value="">-- Pilih Buku --</option>
                            <?php foreach ($books as $b) : ?>
                                <option value="<?= $b['id_book'] ?>" <?= $loan['id_book'] == $b['id_book'] ? 'selected' : '' ?>>
                                    <?= esc($b['title_book']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Peminjaman</label>
                        <input type="date" name="tanggal_loan" class="form-control" value="<?= esc($loan['tanggal_loan']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Target Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" class="form-control" value="<?= esc($loan['tanggal_kembali']) ?>" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                </div>
            </form>
            
        </div>
    </div>
</div>