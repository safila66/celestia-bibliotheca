<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
/* Header Styles */
.service-header {
    background: linear-gradient(180deg, var(--deep-navy) 0%, #0d1025 100%);
    padding: 120px 20px 60px;
    text-align: center;
    border-bottom: 1px solid rgba(201,168,76,0.15);
}
.service-title {
    font-family: 'Cinzel', serif; font-size: 36px;
    color: var(--gold); letter-spacing: 0.08em;
    margin-bottom: 16px;
}
.service-subtitle {
    color: var(--ivory); opacity: 0.8; font-size: 16px;
}

/* Main Container */
.container {
    max-width: 1200px; margin: 40px auto 100px;
    padding: 0 20px;
}

/* Grid Layout */
.ref-grid {
    display: grid; grid-template-columns: 1fr 2fr; gap: 40px; align-items: start;
}
@media(max-width: 900px) {
    .ref-grid { grid-template-columns: 1fr; }
}

/* Librarian Specialists */
.specialist-card {
    background: var(--panel, rgba(30,35,45,0.4));
    border: 1px solid var(--gold); border-radius: 8px; padding: 20px; margin-bottom: 20px;
}
.sp-title { font-family: 'Cinzel', serif; font-size: 20px; color: var(--gold); margin-bottom: 20px; border-bottom: 1px solid rgba(201,168,76,0.3); padding-bottom: 10px; }
.sp-item { display: flex; gap: 15px; margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px; }
.sp-item:last-child { border: none; margin-bottom: 0; padding-bottom: 0; }
.sp-icon { font-size: 30px; }
.sp-info h4 { margin: 0 0 5px 0; color: var(--text); font-size: 16px; }
.sp-info .spec { color: #2196f3; font-size: 13px; font-weight: bold; margin-bottom: 5px; }
.sp-info .sch { color: var(--text-dim); font-size: 13px; }

/* Collections */
.coll-title { font-family: 'Cinzel', serif; font-size: 24px; color: var(--gold); margin-bottom: 20px; }
.books-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;
}
.book-card {
    background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 15px; text-align: center;
}
.book-card img { width: 100px; height: 150px; object-fit: cover; border-radius: 4px; margin-bottom: 15px; }
.book-card h5 { margin: 0 0 5px 0; color: var(--text); font-size: 14px; }
.book-card button {
    background: transparent; border: 1px solid var(--gold); color: var(--gold); padding: 8px; width: 100%; border-radius: 4px; margin-top: 10px; cursor: pointer; transition: 0.2s;
}
.book-card button:hover { background: var(--gold); color: #1a1a2e; }

/* My Loans Section */
.my-loans { margin-top: 60px; }
.booking-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.booking-table th, .booking-table td { padding: 16px; text-align: left; border-bottom: 1px solid var(--border, rgba(255,255,255,0.1)); color: var(--text); }
.booking-table th { background: rgba(201,168,76,0.1); color: var(--gold); font-weight: bold; }
.status-badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
.status-active { background: rgba(33,150,243,0.2); color: #2196f3; }
.status-returned { background: rgba(76,175,80,0.2); color: #4caf50; }

/* Modal */
.modal-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.8); display: none; align-items: center; justify-content: center; z-index: 1000;
}
.modal-content {
    background: var(--deep-navy); padding: 30px; border-radius: 8px; width: 100%; max-width: 400px;
    border: 1px solid var(--gold); color: var(--text);
}
.modal-content h3 { margin-top: 0; color: var(--gold); margin-bottom: 20px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-size: 14px; color: var(--text-dim); }
.form-group select { width: 100%; padding: 12px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: var(--text); }
.btn-submit { background: var(--gold); color: #1a1a2e; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; }

/* Light Mode Overrides */
[data-theme="light"] .service-header { background: #F8F5F0; }
[data-theme="light"] .service-title { color: #A8752A; }
[data-theme="light"] .service-subtitle { color: #555; }
[data-theme="light"] .specialist-card { background: #fff; }
[data-theme="light"] .sp-title { color: #A8752A; }
[data-theme="light"] .sp-info h4 { color: #333; }
[data-theme="light"] .book-card { background: #fff; border-color: #ddd; }
[data-theme="light"] .book-card h5 { color: #333; }
[data-theme="light"] .booking-table th { background: #f0f0f0; color: #333; }
[data-theme="light"] .booking-table td { border-bottom-color: #eee; color: #333; }
[data-theme="light"] .modal-content { background: #fff; border-color: #ccc; }
[data-theme="light"] .form-group select { background: #fafafa; border-color: #ccc; color: #333; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="service-header">
    <h1 class="service-title"><?= esc($title) ?></h1>
    <p class="service-subtitle">Konsultasi mendalam dengan pustakawan spesialis dan akses koleksi referensi.</p>
</section>

<div class="container">
    <div class="ref-grid">
        <!-- Sidebar: Specialists -->
        <div>
            <div class="specialist-card">
                <div class="sp-title">Jadwal Pustakawan Spesialis</div>
                <?php foreach($librarians as $lib): ?>
                <div class="sp-item">
                    <div class="sp-icon">👩‍🏫</div>
                    <div class="sp-info">
                        <h4><?= esc($lib['name']) ?></h4>
                        <div class="spec"><?= esc($lib['specialty']) ?></div>
                        <div class="sch">🕒 <?= esc($lib['schedule']) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <div style="font-size: 13px; color: var(--text-dim); margin-top: 15px; font-style: italic;">
                    *Pustakawan siap membantu penelusuran literatur mendalam pada jam-jam tersebut.
                </div>
            </div>
        </div>

        <!-- Main Content: Collections -->
        <div>
            <div class="coll-title">Pencarian Jurnal Ilmiah (DOAJ Open Access)</div>
            <p style="color: var(--text-dim); margin-bottom: 20px;">Cari dan baca ribuan jurnal Open Access dari seluruh dunia secara gratis dan legal.</p>
            
            <form action="/referensi" method="GET" style="margin-bottom: 20px; display: flex; gap: 10px;">
                <input type="text" name="q" value="<?= esc($keyword) ?>" placeholder="Cari topik jurnal... (Cth: computer science, library)" style="flex: 1; padding: 12px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.5); color: #fff;">
                <button type="submit" style="background: var(--gold); color: #1a1a2e; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Cari</button>
            </form>

            <div class="books-grid">
                <?php if(empty($doajArticles)): ?>
                    <p style="color: var(--text-dim); grid-column: 1 / -1;">Tidak ditemukan artikel untuk pencarian ini.</p>
                <?php else: ?>
                    <?php foreach($doajArticles as $article): ?>
                    <div class="book-card" style="display: flex; flex-direction: column; text-align: left;">
                        <div style="flex: 1;">
                            <div style="font-size: 11px; color: var(--gold); margin-bottom: 5px; text-transform: uppercase;"><?= esc($article['journal']) ?> <?= esc($article['year']) ? " (" . esc($article['year']) . ")" : "" ?></div>
                            <h5 style="margin: 0 0 10px 0; font-size: 15px; line-height: 1.4;"><?= esc($article['title']) ?></h5>
                            <div style="font-size: 12px; color: var(--text-dim); margin-bottom: 15px;">By: <?= esc($article['author']) ?></div>
                        </div>
                        <a href="<?= esc($article['link']) ?>" target="_blank" style="display: block; background: transparent; border: 1px solid var(--gold); color: var(--gold); padding: 8px; text-align: center; border-radius: 4px; text-decoration: none; font-size: 13px; transition: 0.2s;" onmouseover="this.style.background='var(--gold)'; this.style.color='#1a1a2e';" onmouseout="this.style.background='transparent'; this.style.color='var(--gold)';">Baca Artikel Full-Text</a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- My Reference Loans -->
    <div class="my-loans">
        <div class="coll-title">Riwayat Pinjaman Referensi Saya</div>
        <?php if(empty($myLoans)): ?>
            <p style="color: var(--text-dim);">Belum ada pinjaman koleksi referensi.</p>
        <?php else: ?>
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Sampul</th>
                        <th>Judul Buku</th>
                        <th>Metode Pinjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($myLoans as $loan): ?>
                    <tr>
                        <td><img src="/assets/covers/<?= esc($loan['cover_image'] ?? 'default-cover.jpg') ?>" style="width: 40px; border-radius: 4px;"></td>
                        <td style="font-weight: bold;"><?= esc($loan['title']) ?></td>
                        <td><?= $loan['type'] == 'ebook' ? '📱 E-Book (Digital)' : '📖 Baca di Tempat (Offline)' ?></td>
                        <td><?= esc($loan['created_at']) ?></td>
                        <td>
                            <span class="status-badge status-<?= esc($loan['status']) ?>"><?= ucfirst(esc($loan['status'])) ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- Borrow Modal -->
<div class="modal-overlay" id="borrowModal">
    <div class="modal-content">
        <h3>Pinjam Referensi</h3>
        <p style="margin-bottom: 20px; font-size: 14px;" id="modalBookTitle"></p>
        <form action="/referensi/borrow" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="book_id" id="modalBookId">
            <div class="form-group">
                <label>Pilih Metode Peminjaman</label>
                <select name="type" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="ebook">Pinjam sebagai E-Book (Akses Digital)</option>
                    <option value="offline">Baca di Tempat (Datang ke Perpustakaan)</option>
                </select>
                <div style="font-size: 12px; color: #ff9800; margin-top: 10px;">
                    *Koleksi referensi dilarang dibawa pulang atau menggunakan layanan Book Delivery.
                </div>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn-submit" style="background: transparent; border: 1px solid var(--text-dim); color: var(--text);" onclick="closeBorrowModal()">Batal</button>
                <button type="submit" class="btn-submit">Proses Pinjaman</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function openBorrowModal(id, title) {
    document.getElementById('borrowModal').style.display = 'flex';
    document.getElementById('modalBookId').value = id;
    document.getElementById('modalBookTitle').innerText = 'Buku: ' + title;
}

function closeBorrowModal() {
    document.getElementById('borrowModal').style.display = 'none';
}
</script>
<?= $this->endSection() ?>
