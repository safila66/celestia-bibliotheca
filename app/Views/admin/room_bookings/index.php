<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 15px;">
    <h2 style="font-family: 'Cinzel', serif; color: var(--gold); font-weight: bold; margin: 0; font-size: 24px;">Room Bookings</h2>
    
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="javascript:void(0);" onclick="createBooking()" style="padding: 8px 16px; background: var(--gold); color: #04060f; border: none; font-weight: bold; text-decoration: none; border-radius: 4px;">+ Reservasi Ruangan</a>
    </div>
</div>

<div class="card" style="background: var(--deep-navy); padding: 20px; border-radius: 8px; border: 1px solid rgba(201,168,76,0.3);">
    <div class="table-wrap" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--ivory); min-width: 900px;">
            <thead>
                <tr style="border-bottom: 2px solid var(--gold); background: rgba(201,168,76,0.1);">
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">No</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Member</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Ruangan</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Tanggal</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Waktu</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase;">Keperluan</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase; text-align: center;">Status</th>
                    <th style="padding: 12px 10px; font-family: 'Raleway', sans-serif; font-size: 11px; color: var(--gold); text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bookings)): ?>
                    <?php $i = 1; foreach ($bookings as $row): ?>
                    <tr style="border-bottom: 1px solid rgba(201,168,76,0.2); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px;"><?= $i++ ?></td>
                        <td style="padding: 12px 10px; font-family: 'Cinzel', serif; font-size: 14px; font-weight: 600; color: var(--gold);">
                            <?= esc($row['user_name'] ?? '-') ?>
                        </td>
                        <td style="padding: 12px 10px; color: var(--moon-silver); font-size: 13px; font-weight: bold;">
                            <?= esc($row['room_name']) ?>
                        </td>
                        <td style="padding: 12px 10px; color: var(--text-dim); font-size: 13px;">
                            <?= date('d/m/Y', strtotime($row['booking_date'])) ?>
                        </td>
                        <td style="padding: 12px 10px; color: var(--text-dim); font-size: 13px;">
                            <?= date('H:i', strtotime($row['start_time'])) ?> - <?= date('H:i', strtotime($row['end_time'])) ?>
                        </td>
                        <td style="padding: 12px 10px; color: var(--text-dim); font-size: 12px;">
                            <?= esc($row['purpose']) ?>
                        </td>
                        <td style="padding: 12px 10px; text-align: center;">
                            <?php
                                $statusMap = [
                                    'pending'   => ['label' => 'Menunggu', 'bg' => 'rgba(212, 184, 114, 0.15)', 'fg' => '#d4b872', 'border' => '#d4b872'],
                                    'approved'  => ['label' => 'Disetujui','bg' => 'rgba(126, 200, 160, 0.15)', 'fg' => '#7ec8a0', 'border' => '#7ec8a0'],
                                    'rejected'  => ['label' => 'Ditolak',  'bg' => 'rgba(224, 112, 112, 0.15)', 'fg' => '#e07070', 'border' => '#e07070'],
                                    'completed' => ['label' => 'Selesai',  'bg' => 'rgba(150, 150, 150, 0.15)', 'fg' => '#a0a0a0', 'border' => '#707070'],
                                ];
                                $s = $statusMap[$row['status']] ?? ['label' => esc($row['status']), 'bg' => 'rgba(150, 150, 150, 0.15)', 'fg' => '#a0a0a0', 'border' => '#707070'];
                            ?>
                            <span style="background: <?= $s['bg'] ?>; border: 1px solid <?= $s['border'] ?>; padding: 4px 8px; border-radius: 15px; font-size: 11px; color: <?= $s['fg'] ?>; white-space: nowrap;">
                                <?= $s['label'] ?>
                            </span>
                        </td>
                        <td style="padding: 12px 10px; text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <button onclick="editBooking(<?= $row['id'] ?>)" style="background: #c9a84c; color: #04060f; border: none; padding: 6px 10px; border-radius: 4px; font-size: 11px; cursor: pointer; font-weight: bold;" title="Edit">✏️</button>
                                <a href="<?= base_url('admin/delete/room-booking/' . $row['id']) ?>" style="background: #963c3c; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none; font-size: 11px; font-weight: bold;" onclick="return confirm('Hapus reservasi ruangan ini?')" title="Hapus">🗑️</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-dim); font-style: italic;">
                            <div style="font-size: 40px; margin-bottom: 10px;">🚪</div>
                            Belum ada jadwal reservasi ruangan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
    <div id="editFormContent" style="width: 100%; display: flex; justify-content: center;"></div>
</div>

<div id="createModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
    <div id="createFormContent" style="width: 100%; display: flex; justify-content: center;"></div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function editBooking(id) {
        $('#editModal').css('display', 'flex');
        $('#editFormContent').html('<div style="color:var(--gold); padding:20px; background: var(--deep-navy); border: 1px solid var(--gold); border-radius: 8px;">Memuat data... ⏳</div>');
        
        $.ajax({
            url: "<?= base_url('admin/ajax/edit/room-booking/') ?>" + id,
            type: "GET",
            success: function(response) {
                $('#editFormContent').html(response);
            },
            error: function(xhr) {
                $('#editFormContent').html('<div style="background: #fff; color: #000; padding: 20px; border-radius: 8px;">' + xhr.responseText + '</div>');
            }
        });
    }

    function createBooking() {
        $('#createModal').css('display', 'flex');
        $('#createFormContent').html('<div style="color:#7ec8a0; padding:20px; background: var(--deep-navy); border: 1px solid #7ec8a0; border-radius: 8px;">Mempersiapkan formulir... ⏳</div>');
        
        $.ajax({
            url: "<?= base_url('admin/ajax/create/room-booking') ?>",
            type: "GET",
            success: function(response) {
                $('#createFormContent').html(response);
            },
            error: function(xhr) {
                $('#createFormContent').html('<div style="background: #fff; color: #000; padding: 20px; border-radius: 8px;">' + xhr.responseText + '</div>');
            }
        });
    }
</script>
<?= $this->endSection() ?>
