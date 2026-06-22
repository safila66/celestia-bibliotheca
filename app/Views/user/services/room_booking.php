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

/* ── UI TAB & CARD RUANGAN ── */
.tabs { display: flex; gap: 24px; margin-bottom: 30px; border-bottom: 1px solid rgba(201,168,76,0.2); }
.tab { padding: 12px 0; cursor: pointer; color: var(--text-dim); font-weight: 600; border-bottom: 2px solid transparent; transition: all 0.3s; }
.tab.active { color: var(--gold); border-bottom-color: var(--gold); }
.tab:hover:not(.active) { color: var(--text); }

/* Room Grid */
.room-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;
}
.room-card {
    background: var(--panel, rgba(30,35,45,0.4)); border: 1px solid var(--border, rgba(255,255,255,0.1));
    border-radius: 12px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;
    display: flex; flex-direction: column;
}
.room-card:hover {
    transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.5); border-color: rgba(201,168,76,0.3);
}
.room-img {
    width: 100%; height: 200px; object-fit: cover; border-bottom: 1px solid rgba(255,255,255,0.05);
}
.room-info {
    padding: 24px; flex: 1; display: flex; flex-direction: column;
}
.room-title {
    font-family: 'Cinzel', serif; font-size: 22px; color: var(--gold); margin-bottom: 8px;
}
.room-meta {
    font-size: 14px; color: var(--text-dim); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
}
.room-meta span { background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 4px; }
.btn-book {
    background: var(--gold); color: #1a1a2e; padding: 12px; border: none; border-radius: 4px;
    cursor: pointer; font-weight: bold; width: 100%; font-size: 14px; margin-top: auto;
    transition: background 0.2s;
}
.btn-book:hover { background: #dfc16d; }

/* Booking Table */
.booking-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.booking-table th, .booking-table td { padding: 16px; text-align: left; border-bottom: 1px solid var(--border, rgba(255,255,255,0.1)); color: var(--text); }
.booking-table th { background: rgba(201,168,76,0.1); color: var(--gold); font-weight: bold; }
.status-badge { padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block; }
.status-approved { background: rgba(76,175,80,0.2); color: #4caf50; }
.status-pending { background: rgba(255,152,0,0.2); color: #ff9800; }

/* Modal Form */
.modal-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.8); display: none; align-items: center; justify-content: center; z-index: 1000;
}
.modal-content {
    background: var(--deep-navy); padding: 30px; border-radius: 8px; width: 100%; max-width: 500px;
    border: 1px solid var(--gold); color: #fff;
}
.modal-content h3 { margin-top: 0; color: var(--gold); margin-bottom: 20px; font-family: 'Cinzel', serif; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-size: 14px; color: #ddd; }
.form-group input, .form-group select { width: 100%; padding: 12px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.5); color: #fff; font-family: inherit; }
.time-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

/* Light Mode Overrides */
[data-theme="light"] .service-header { background: #F8F5F0; }
[data-theme="light"] .service-title { color: #A8752A; }
[data-theme="light"] .service-subtitle { color: #555; }
[data-theme="light"] .room-card { background: #fff; border-color: #ddd; }
[data-theme="light"] .room-title { color: #A8752A; }
[data-theme="light"] .room-meta span { background: #f0f0f0; color: #555; }
[data-theme="light"] .booking-table th { background: #f0f0f0; color: #333; }
[data-theme="light"] .booking-table td { border-bottom-color: #eee; color: #333; }
[data-theme="light"] .modal-content { background: #fff; border-color: #ccc; }
[data-theme="light"] .form-group input, [data-theme="light"] .form-group select { background: #fafafa; border-color: #ccc; color: #333; }
</style>

<section class="service-header">
    <h1 class="service-title"><?= esc($title) ?></h1>
    <p class="service-subtitle">Reservasi ruang baca dan diskusi sesuai kebutuhan Anda, hingga durasi 24 jam.</p>
</section>

<div class="container">
    <?php if(session()->getFlashdata('error')): ?>
        <div style="background: rgba(220, 53, 69, 0.2); color: #ffcccc; padding: 15px; border: 1px solid #dc3545; border-radius: 4px; margin-bottom: 20px; text-align: center;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('success')): ?>
        <div style="background: rgba(76, 175, 80, 0.2); color: #ccffcc; padding: 15px; border: 1px solid #4caf50; border-radius: 4px; margin-bottom: 20px; text-align: center;">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <div class="tabs">
        <div class="tab active" onclick="switchTab('catalog', event)">Katalog Ruangan</div>
        <div class="tab" onclick="switchTab('mybookings', event)">Booking Saya</div>
    </div>

    <!-- Catalog Section -->
    <div id="section-catalog">
        <div class="room-grid">
            <?php foreach($rooms as $room): ?>
            <div class="room-card">
                <img src="/assets/images/rooms/<?= esc($room['image']) ?>" class="room-img" alt="<?= esc($room['name']) ?>">
                <div class="room-info">
                    <div class="room-title"><?= esc($room['name']) ?></div>
                    <div class="room-meta">
                        <span>👥 Maks: <?= esc($room['capacity']) ?> Orang</span>
                        <span style="color: #4caf50;">Tersedia</span>
                    </div>
                    <button class="btn-book" onclick="openBookingModal('<?= esc($room['id']) ?>', '<?= esc($room['name']) ?>', <?= esc($room['capacity']) ?>)">Book Ruangan Ini</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- My Bookings Section -->
    <div id="section-mybookings" style="display: none;">
        <?php if(empty($userBookings)): ?>
            <div style="text-align: center; padding: 60px; color: var(--text-dim);">
                <div style="font-size: 48px; margin-bottom: 20px; opacity: 0.8;">🏢</div>
                <div>Anda belum memiliki riwayat booking ruangan.</div>
            </div>
        <?php else: ?>
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Ruangan</th>
                        <th>Tanggal Booking</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($userBookings as $b): ?>
                    <tr>
                        <td style="font-weight: bold;"><?= esc($b['room_name']) ?></td>
                        <td><?= esc($b['booking_date']) ?></td>
                        <td><?= esc($b['start_time']) ?></td>
                        <td><?= esc($b['end_time']) ?></td>
                        <td>
                            <?php if($b['status'] == 'approved' || $b['status'] == 'active'): ?>
                                <span class="status-badge status-approved"><?= ucfirst(esc($b['status'])) ?></span>
                                <?php if($b['status'] == 'approved'): ?>
                                    <br><button class="btn-action qr" onclick="showRoomQR(<?= $b['id'] ?>)" style="margin-top:5px; background: rgba(201,168,76,0.2); color: var(--gold); border: 1px solid var(--gold); padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 10px;">Check-In QR</button>
                                <?php endif; ?>
                            <?php elseif($b['status'] == 'completed'): ?>
                                <span class="status-badge" style="background: rgba(156,163,175,0.2); color: #9ca3af;">Completed</span>
                            <?php else: ?>
                                <span class="status-badge status-pending"><?= ucfirst(esc($b['status'])) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- QR Modal -->
<div class="modal-overlay" id="qrModal" onclick="closeRoomQR(event)">
    <div class="modal-content" onclick="event.stopPropagation()" style="text-align: center; max-width: 300px;">
        <h3 style="margin-top: 0; color: var(--gold); font-family: 'Cinzel', serif;">Scan Check-In</h3>
        <p style="font-size: 14px; color: #ddd;">Silakan scan barcode ini pada pemindai di depan ruangan.</p>
        <div style="width: 200px; height: 200px; background: #fff; margin: 20px auto; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
            <img src="" id="qrImage" style="width:180px; height:180px;">
        </div>
        <p id="qrStatusText" style="font-size: 12px; color: #ff9800; font-weight:bold;">Menunggu Check-In...</p>
        <button onclick="closeRoomQR()" style="margin-top: 10px; background: transparent; border: 1px solid #ddd; color: #ddd; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Tutup</button>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal-overlay" id="bookingModal">
    <div class="modal-content">
        <h3>Booking Form</h3>
        <p style="margin-bottom: 20px; font-size: 14px;" id="modalRoomName"></p>
        <form action="/room-booking/book" method="POST" onsubmit="return validateTime()">
            <?= csrf_field() ?>
            <input type="hidden" name="room_id" id="modalRoomId">
            <div class="form-group">
                <label>Pilih Spesifik Ruangan</label>
                <select name="room_name" id="modalRoomNameInput" required>
                    <!-- Options will be populated by JS -->
                </select>
            </div>
            
            <div class="form-group">
                <label>Tanggal Booking</label>
                <input type="date" name="booking_date" id="booking_date" required min="<?= date('Y-m-d') ?>">
            </div>
            <div class="time-grid">
                <div class="form-group">
                    <label>Waktu Mulai</label>
                    <input type="time" name="start_time" id="start_time" required>
                </div>
                <div class="form-group">
                    <label>Waktu Selesai (Maks 24 Jam)</label>
                    <input type="time" name="end_time" id="end_time" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Alasan / Keperluan Booking</label>
                <textarea name="purpose" rows="3" required style="width: 100%; padding: 12px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.5); color: #fff; font-family: inherit; resize: vertical;" placeholder="Contoh: Rapat organisasi, belajar kelompok, dll."></textarea>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 10px;">
                <button type="button" class="btn-book" style="background: transparent; border: 1px solid #ddd; color: #ddd; width: auto; padding: 10px 20px;" onclick="closeBookingModal()">Batal</button>
                <button type="submit" class="btn-book" style="background: var(--gold, #C9A84C); color: #1a1a2e; border: none; border-radius: 4px; font-weight: bold; width: auto; padding: 10px 20px;">Ajukan Booking</button>
            </div>
        </form>
    </div>
</div>

<script>
function switchTab(tab, event) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    event.target.classList.add('active');
    
    document.getElementById('section-catalog').style.display = tab === 'catalog' ? 'block' : 'none';
    document.getElementById('section-mybookings').style.display = tab === 'mybookings' ? 'block' : 'none';
}

const roomData = {
    'common': ['Ruang Diskusi AromaBulan', 'Ruang Diskusi JiwaKarsa', 'Ruang Diskusi Amanjiwa'],
    'private': ['Private Room Mars', 'Private Room Venus', 'Private Room Bumi', 'Bilik Komputer'],
    'meeting': ['Meeting Room Selene', 'Meeting Room Celeste', 'Meeting Room Bulan'],
    'class': ['Class Room Stars B-145', 'Class Room Stars S-122', 'Ruang Audio Visual Const-129'],
    'artwork': ['Artwork Room V-992 ', 'Artwork Room V-009', 'Artwork Room V-344', 'Artwork Room V-864'],
};

function openBookingModal(id, name, capacity) {
    document.getElementById('bookingModal').style.display = 'flex';
    document.getElementById('modalRoomId').value = id;
    document.getElementById('modalRoomName').innerText = `Kategori: ${name} (Maks: ${capacity} Orang)`;
    
    // Reset date/times
    document.getElementById('booking_date').value = '';
    document.getElementById('start_time').value = '';
    document.getElementById('end_time').value = '';

    // Populate the dropdown based on the category 'id'
    const select = document.getElementById('modalRoomNameInput');
    select.innerHTML = ''; // Clear existing
    if (roomData[id]) {
        roomData[id].forEach(rName => {
            let opt = document.createElement('option');
            opt.value = rName;
            opt.innerText = rName;
            select.appendChild(opt);
        });
    } else {
        let opt = document.createElement('option');
        opt.value = name;
        opt.innerText = name;
        select.appendChild(opt);
    }
}

function closeBookingModal() {
    document.getElementById('bookingModal').style.display = 'none';
}

function validateTime() {
    const start = document.getElementById('start_time').value;
    const end = document.getElementById('end_time').value;
    const select = document.getElementById('modalRoomNameInput');

    if(!start || !end) {
        alert("Pilih waktu mulai dan selesai.");
        return false;
    }
    
    if(!select.value) {
        alert("Pilih ruangan yang tersedia.");
        return false;
    }

    return true;
}

// Tambahan AJAX untuk Availability Check
document.getElementById('booking_date').addEventListener('change', checkAvailability);
document.getElementById('start_time').addEventListener('change', checkAvailability);
document.getElementById('end_time').addEventListener('change', checkAvailability);

function checkAvailability() {
    const date = document.getElementById('booking_date').value;
    const start = document.getElementById('start_time').value;
    const end = document.getElementById('end_time').value;

    if (date && start && end) {
        fetch(`/room-booking/check-availability?date=${date}&start_time=${start}&end_time=${end}`)
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('modalRoomNameInput');
            Array.from(select.options).forEach(opt => {
                if (data.booked_rooms.includes(opt.value)) {
                    opt.disabled = true;
                    if (!opt.text.includes('(Sudah Dibooking)')) {
                        opt.text = opt.value + ' (Sudah Dibooking)';
                    }
                } else {
                    opt.disabled = false;
                    opt.text = opt.value;
                }
            });

            // Jika yang sedang dipilih sekarang ternyata disabled, pindahkan ke opsi yang enabled
            if (select.selectedOptions[0] && select.selectedOptions[0].disabled) {
                const firstAvailable = Array.from(select.options).find(o => !o.disabled);
                if (firstAvailable) {
                    select.value = firstAvailable.value;
                } else {
                    select.value = "";
                }
            }
        })
        .catch(err => console.error("Error checking availability:", err));
    }
}

// QR Check-in Polling
let qrPollInterval;
function showRoomQR(bookingId) {
    document.getElementById('qrModal').style.display = 'flex';
    const scanUrl = '<?= base_url('scan/room-booking/') ?>' + bookingId;
    document.getElementById('qrImage').src = `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${encodeURIComponent(scanUrl)}`;
    document.getElementById('qrStatusText').innerText = "Menunggu Check-In...";
    document.getElementById('qrStatusText').style.color = "#ff9800";
    
    qrPollInterval = setInterval(() => {
        fetch('<?= base_url('api/check-room-booking/') ?>' + bookingId)
        .then(r => r.json())
        .then(data => {
            if (data.status === 'active') {
                clearInterval(qrPollInterval);
                document.getElementById('qrStatusText').innerText = "Check-In Berhasil! Memuat ulang...";
                document.getElementById('qrStatusText').style.color = "#4caf50";
                setTimeout(() => location.reload(), 1500);
            }
        });
    }, 3000);
}

function closeRoomQR(e) {
    document.getElementById('qrModal').style.display = 'none';
    if(qrPollInterval) clearInterval(qrPollInterval);
}
</script>
