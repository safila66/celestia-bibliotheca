<?= $this->extend('layouts/template') ?>

<?= $this->section('header') ?>
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><?= $title ?></h1>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Buku — Pilih untuk Cetak Label</h3>
        <div class="card-tools">
            <a href="<?= base_url('/report/cetak-label-buku') ?>" target="_blank" class="btn btn-danger btn-sm">
                <i class="fas fa-print"></i> Cetak Semua Label
            </a>
        </div>
    </div>

    <div class="card-body table-responsive">
        <table id="tabelLabelBuku" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="50">No.</th>
                    <th>Kode Buku</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th width="130">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 0; ?>
                <?php foreach($books as $book): ?>
                    <?php $no++; ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $book['code_book'] ?></td>
                        <td><?= $book['title_book'] ?></td>
                        <td><?= $book['author_book'] ?></td>
                        <td><?= $book['publisher_book'] ?></td>
                        <td><?= $book['published_year'] ?></td>
                        <td>
                            <a href="<?= base_url('/report/cetak-label-buku/' . $book['id_book']) ?>"
                               target="_blank"
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-tag"></i> Cetak Label
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<link rel="stylesheet" href="<?= base_url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<script src="<?= base_url('adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('#tabelLabelBuku').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data",
                "zeroRecords": "Data tidak ditemukan",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>
