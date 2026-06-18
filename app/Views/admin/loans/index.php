<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-3">
    <div class="row mb-4 align-items-center">
        <div class="col-sm-6">
            <h1 class="h3 mb-0" style="font-family: serif; color: #8b7355; font-weight: bold;">MANAJEMEN SIRKULASI</h1>
        </div>
        <div class="col-sm-6 text-right text-end">
            <button class="btn font-weight-bold shadow-sm" id="btnTambahPeminjaman" style="background-color: #d4b872; color: #fff; border-radius: 6px;">
                + CATAT PEMINJAMAN BARU
            </button>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0" style="background-color: #fdfaf2; border-radius: 8px;">
        <div class="card-body p-4">
            <div id="viewDataTabel"></div>
        </div>
    </div>
</div>

<div id="viewModal" style="display:none;"></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Load Tabel Otomatis
        $('#viewDataTabel').html('<div class="text-center p-4 text-muted"><i class="fas fa-spinner fa-spin mr-2"></i> Sedang memuat data arsip...</div>');
        $('#viewDataTabel').load("<?= base_url('list/loan/table') ?>");

        // Aksi Tambah
        $('#btnTambahPeminjaman').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('ajax/create/loan') ?>",
                success: function(response) {
                    $('#viewModal').html(response).show();
                    $('#modalTambah').modal('show');
                }
            });
        });

        // Aksi Edit
        $('#viewDataTabel').on('click', '.btnEdit', function(e) {
            e.preventDefault();
            let id = $(this).data('id'); 
            
            $.ajax({
                url: "<?= base_url('ajax/edit/loan/') ?>" + id,
                success: function(response) {
                    $('#viewModal').html(response).show();
                    $('#modalEdit').modal('show');
                },
                error: function(xhr) {
                    alert("Gagal memuat form edit. Error: " + xhr.status);
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>