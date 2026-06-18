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
        <h3 class="card-title">Data Buku</h3>
        <div class="card-tools">
            <a href="<?= base_url('/report/cetak-buku') ?>" target="_blank" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>
        </div>
    </div>

    <div class="card-body table-responsive">
        <table id="tabelLaporanBuku" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="50">No.</th>
                    <th>Judul Buku</th>
                    <th>Kode Buku</th>
                    <th>ISBN</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 0; ?>
                <?php foreach($books as $book): ?>
                    <?php $no++; ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $book['title_book'] ?></td>
                        <td><?= $book['code_book'] ?></td>
                        <td><?= $book['isbn_book'] ?></td>
                        <td><?= $book['author_book'] ?></td>
                        <td><?= $book['publisher_book'] ?></td>
                        <td><?= $book['published_year'] ?></td>
                        <td><?= $book['description_book'] ?></td>
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
        $('#tabelLaporanBuku').DataTable({
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