<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h2>Manajemen Kategori</h2>
    <button class="btn btn-primary" id="btnTambahKategori">+ Tambah Kategori Baru</button>
</div>

<div class="card">
    <div style="padding: 1rem;">
        <div id="viewDataTabel"></div>
    </div>
</div>

<div id="viewModal" style="display:none;"></div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        
        // Fungsi untuk me-load tabel
        function loadTabelKategori() {
            $('#viewDataTabel').html('<div class="text-center p-4 text-muted"><i class="fas fa-spinner fa-spin mr-2"></i> Sedang memuat data kategori...</div>');
            // PASTIKAN URL INI SESUAI DENGAN ROUTES KAMU
            $('#viewDataTabel').load("<?= base_url('admin/categories/table') ?>"); 
        }

        // Jalankan fungsi load tabel saat halaman pertama kali dibuka
        loadTabelKategori();

        // 1. Aksi Tombol Tambah (Menampilkan Modal)
        $('#btnTambahKategori').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('admin/categories/create') ?>", // Endpoint form tambah
                success: function(response) {
                    $('#viewModal').html(response).show();
                    $('#modalTambah').modal('show');
                },
                error: function(xhr) {
                    alert("Gagal memuat form tambah. Error: " + xhr.status);
                }
            });
        });

        // 2. Aksi Tombol Edit (Menampilkan Modal)
        $('#viewDataTabel').on('click', '.btnEdit', function(e) {
            e.preventDefault();
            let id = $(this).data('id'); 
            
            $.ajax({
                url: "<?= base_url('admin/categories/edit/') ?>" + id, // Endpoint form edit
                success: function(response) {
                    $('#viewModal').html(response).show();
                    $('#modalEdit').modal('show');
                },
                error: function(xhr) {
                    alert("Gagal memuat form edit. Error: " + xhr.status);
                }
            });
        });

        // 3. Aksi Tombol Hapus (Konfirmasi & Hapus Data)
        $('#viewDataTabel').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            let id = $(this).data('id');

            if (confirm('Apakah kamu yakin ingin menghapus kategori ini?')) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/categories/delete/') ?>" + id, // Endpoint hapus
                    data: {
                        _method: 'DELETE' // Memalsukan method DELETE untuk CodeIgniter 4
                    },
                    success: function(response) {
                        // Refresh tabel otomatis setelah berhasil dihapus
                        loadTabelKategori();
                        alert('Data kategori berhasil dihapus!');
                    },
                    error: function(xhr) {
                        alert("Gagal menghapus data. Error: " + xhr.status);
                    }
                });
            }
        });

    });
</script>
<?= $this->endSection() ?>
