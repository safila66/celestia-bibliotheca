<?= $this->extend('admin/template') ?>

<?= $this->section('styles') ?>
<style>
.tabs {
    display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 10px; overflow-x: auto;
}
.tab-btn {
    background: var(--panel); border: 1px solid var(--border); color: var(--text);
    padding: 8px 16px; font-family: 'Cinzel', serif; font-size: 0.8rem; letter-spacing: 0.05em;
    cursor: pointer; border-radius: 4px; transition: 0.2s; white-space: nowrap;
}
.tab-btn:hover { background: var(--deep); border-color: var(--gold-dim); }
.tab-btn.active {
    background: var(--gold-dim); color: var(--bg); border-color: var(--gold); font-weight: bold;
}
.tab-content { display: none; }
.tab-content.active { display: block; }
select.form-control-sm {
    padding: 4px 8px; font-size: 0.75rem; border-radius: 4px; border: 1px solid var(--border); background: var(--deep); color: var(--text);
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h2>Monitoring Layanan Tambahan</h2>
</div>

<div class="tabs">
    <button class="tab-btn active" onclick="showTab('referensi')">Layanan Referensi</button>
    <button class="tab-btn" onclick="showTab('sitasi')">Cek Sitasi</button>
    <button class="tab-btn" onclick="showTab('konsultasi')">Konsultasi Pustakawan</button>
    <button class="tab-btn" onclick="showTab('mendeley')">Mendeley Class</button>
    <button class="tab-btn" onclick="showTab('language')">Language Class</button>
</div>

<!-- TAB: REFERENSI -->
<div id="tab-referensi" class="tab-content active">
    <div class="card">
        <div class="card-header"><div class="card-title">Daftar Peminjaman Referensi (DOAJ/Jurnal)</div></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>User</th>
                        <th>Journal ID / Topik</th>
                        <th>Tujuan</th>
                        <th>Batas Waktu</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($referensi)): ?><tr><td colspan="7" style="text-align:center;">Belum ada data.</td></tr><?php endif; ?>
                    <?php foreach($referensi as $item): ?>
                    <tr>
                        <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                        <td><?= esc($item['user_name']) ?></td>
                        <td><?= esc($item['journal_id']) ?></td>
                        <td><?= esc($item['purpose']) ?></td>
                        <td><?= date('d M Y', strtotime($item['return_date'])) ?></td>
                        <td><span class="badge badge-subtle"><?= esc($item['status']) ?></span></td>
                        <td>
                            <form action="<?= base_url('admin/services/update-status/referensi/' . $item['id']) ?>" method="POST" style="display:flex; gap:5px;">
                                <?= csrf_field() ?>
                                <select name="status" class="form-control-sm">
                                    <option value="Pending" <?= $item['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Approved" <?= $item['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                                    <option value="Completed" <?= $item['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="Cancelled" <?= $item['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TAB: SITASI -->
<div id="tab-sitasi" class="tab-content">
    <div class="card">
        <div class="card-header"><div class="card-title">Daftar Pengecekan Sitasi & Plagiarisme</div></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>User</th>
                        <th>File Dokumen</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($sitasi)): ?><tr><td colspan="5" style="text-align:center;">Belum ada data.</td></tr><?php endif; ?>
                    <?php foreach($sitasi as $item): ?>
                    <tr>
                        <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                        <td><?= esc($item['user_name']) ?></td>
                        <td><a href="<?= base_url('uploads/documents/' . esc($item['file_path'])) ?>" target="_blank" style="color:var(--gold);">Unduh / Lihat</a></td>
                        <td><span class="badge badge-subtle"><?= esc($item['status']) ?></span></td>
                        <td>
                            <form action="<?= base_url('admin/services/update-status/sitasi/' . $item['id']) ?>" method="POST" style="display:flex; gap:5px;">
                                <?= csrf_field() ?>
                                <select name="status" class="form-control-sm">
                                    <option value="Pending" <?= $item['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Checking" <?= $item['status'] == 'Checking' ? 'selected' : '' ?>>Checking</option>
                                    <option value="Completed" <?= $item['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TAB: KONSULTASI -->
<div id="tab-konsultasi" class="tab-content">
    <div class="card">
        <div class="card-header"><div class="card-title">Daftar Konsultasi Pustakawan</div></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tgl Request</th>
                        <th>User</th>
                        <th>Topik</th>
                        <th>Jadwal Konsultasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($konsultasi)): ?><tr><td colspan="6" style="text-align:center;">Belum ada data.</td></tr><?php endif; ?>
                    <?php foreach($konsultasi as $item): ?>
                    <tr>
                        <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                        <td><?= esc($item['user_name']) ?></td>
                        <td><?= esc($item['topic']) ?></td>
                        <td><?= date('d M Y', strtotime($item['consultation_date'])) ?> | <?= esc($item['consultation_time']) ?></td>
                        <td><span class="badge badge-subtle"><?= esc($item['status']) ?></span></td>
                        <td>
                            <form action="<?= base_url('admin/services/update-status/konsultasi/' . $item['id']) ?>" method="POST" style="display:flex; gap:5px;">
                                <?= csrf_field() ?>
                                <select name="status" class="form-control-sm">
                                    <option value="Pending" <?= $item['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Confirmed" <?= $item['status'] == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                    <option value="Completed" <?= $item['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="Cancelled" <?= $item['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TAB: MENDELEY -->
<div id="tab-mendeley" class="tab-content">
    <div class="card">
        <div class="card-header"><div class="card-title">Daftar Pendaftar Mendeley Class</div></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tgl Daftar</th>
                        <th>User</th>
                        <th>Jadwal Kelas</th>
                        <th>Sesi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($mendeley)): ?><tr><td colspan="6" style="text-align:center;">Belum ada data.</td></tr><?php endif; ?>
                    <?php foreach($mendeley as $item): ?>
                    <tr>
                        <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                        <td><?= esc($item['user_name']) ?></td>
                        <td><?= date('d M Y', strtotime($item['schedule_date'])) ?></td>
                        <td><?= esc($item['session_time']) ?></td>
                        <td><span class="badge badge-subtle"><?= esc($item['status']) ?></span></td>
                        <td>
                            <form action="<?= base_url('admin/services/update-status/mendeley/' . $item['id']) ?>" method="POST" style="display:flex; gap:5px;">
                                <?= csrf_field() ?>
                                <select name="status" class="form-control-sm">
                                    <option value="Registered" <?= $item['status'] == 'Registered' ? 'selected' : '' ?>>Registered</option>
                                    <option value="Attended" <?= $item['status'] == 'Attended' ? 'selected' : '' ?>>Attended</option>
                                    <option value="Cancelled" <?= $item['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TAB: LANGUAGE -->
<div id="tab-language" class="tab-content">
    <div class="card">
        <div class="card-header"><div class="card-title">Daftar Pendaftar Language Class</div></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tgl Daftar</th>
                        <th>User</th>
                        <th>Bahasa</th>
                        <th>Jadwal</th>
                        <th>Room & Seat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($language)): ?><tr><td colspan="7" style="text-align:center;">Belum ada data.</td></tr><?php endif; ?>
                    <?php foreach($language as $item): ?>
                    <tr>
                        <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                        <td><?= esc($item['user_name']) ?></td>
                        <td><?= esc($item['language']) ?></td>
                        <td><?= date('d M Y', strtotime($item['schedule_date'])) ?> | <?= esc($item['session_time']) ?></td>
                        <td><?= esc($item['room']) ?> - Kursi <?= esc($item['seat_number']) ?></td>
                        <td><span class="badge badge-subtle"><?= esc($item['status']) ?></span></td>
                        <td>
                            <form action="<?= base_url('admin/services/update-status/language/' . $item['id']) ?>" method="POST" style="display:flex; gap:5px;">
                                <?= csrf_field() ?>
                                <select name="status" class="form-control-sm">
                                    <option value="Confirmed" <?= $item['status'] == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                    <option value="Attended" <?= $item['status'] == 'Attended' ? 'selected' : '' ?>>Attended</option>
                                    <option value="Cancelled" <?= $item['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function showTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    
    document.getElementById('tab-' + tabId).classList.add('active');
    event.target.classList.add('active');
}
</script>
<?= $this->endSection() ?>
