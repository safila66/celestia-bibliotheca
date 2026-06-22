<?= $this->extend('layouts/template') ?>

<?= $this->section('styles') ?>
<style>
.cinema-bg {
    background: #111827; min-height: 100vh; color: #fff; padding-top: 100px; padding-bottom: 50px;
}
.seat-container {
    max-width: 800px; margin: 0 auto; background: #1f2937; padding: 30px; border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
}
.movie-title { text-align: center; font-size: 24px; font-weight: bold; margin-bottom: 5px; color: var(--gold); }
.movie-meta { text-align: center; color: #9ca3af; font-size: 14px; margin-bottom: 30px; }

.screen {
    background: linear-gradient(to bottom, rgba(255,255,255,0.2) 0%, transparent 100%);
    height: 60px; width: 80%; margin: 0 auto 40px; border-top: 4px solid #fff;
    border-radius: 50% 50% 0 0 / 10px 10px 0 0;
    position: relative; text-align: center; padding-top: 5px; font-weight: bold; letter-spacing: 5px; color: #9ca3af; font-size: 12px;
}

.seats-grid {
    display: grid; grid-template-columns: repeat(10, 1fr); gap: 10px; justify-content: center;
    margin-bottom: 40px;
}
.seat {
    aspect-ratio: 1; background: #374151; border-radius: 6px 6px 2px 2px;
    display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; color: #9ca3af;
    cursor: pointer; transition: 0.2s; border: 1px solid rgba(255,255,255,0.1);
}
.seat:hover:not(.occupied) {
    background: #4b5563; color: #fff;
}
.seat.occupied {
    background: #ef4444; color: #fee2e2; cursor: not-allowed; border-color: #ef4444; opacity: 0.5;
}
.seat.selected {
    background: #10b981; color: #fff; border-color: #10b981; box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
}

.legend {
    display: flex; justify-content: center; gap: 20px; margin-bottom: 30px;
}
.legend-item { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #d1d5db; }
.legend-box { width: 20px; height: 20px; border-radius: 4px; }
.legend-available { background: #374151; border: 1px solid rgba(255,255,255,0.1); }
.legend-selected { background: #10b981; }
.legend-occupied { background: #ef4444; opacity: 0.5; }

.bottom-bar {
    background: #1f2937; border-top: 1px solid rgba(255,255,255,0.1);
    padding: 20px; display: flex; justify-content: space-between; align-items: center;
    position: sticky; bottom: 0; border-radius: 0 0 12px 12px;
}
.selected-seat-info { font-size: 18px; font-weight: bold; color: var(--gold); }
.btn-confirm {
    background: var(--gold); color: #1a1a2e; padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 16px; transition: 0.2s;
}
.btn-confirm:disabled { background: #6b7280; color: #9ca3af; cursor: not-allowed; }
.btn-confirm:not(:disabled):hover { background: #dfc16d; transform: translateY(-2px); }

</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="cinema-bg">
    <div class="seat-container">
        
        <?php if(session()->getFlashdata('error')): ?>
            <div style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; padding: 15px; border-radius: 8px; border: 1px solid #ef4444; margin-bottom: 20px;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="movie-title">Bahasa <?= esc($lang) ?></div>
        <div class="movie-meta"><?= date('d M Y', strtotime($date)) ?> | <?= esc($time) ?> | Reguler Class</div>

        <div class="screen">SCREEN</div>

        <div class="seats-grid">
            <?php for($i = 1; $i <= 100; $i++): ?>
                <?php $isOccupied = in_array($i, $bookedSeats); ?>
                <div class="seat <?= $isOccupied ? 'occupied' : 'available' ?>" data-seat="<?= $i ?>" <?= $isOccupied ? '' : 'onclick="selectSeat('.$i.')"' ?>>
                    <?= $i ?>
                </div>
            <?php endfor; ?>
        </div>

        <div class="legend">
            <div class="legend-item"><div class="legend-box legend-available"></div> Tersedia</div>
            <div class="legend-item"><div class="legend-box legend-selected"></div> Pilihanmu</div>
            <div class="legend-item"><div class="legend-box legend-occupied"></div> Terisi</div>
        </div>

        <form action="<?= base_url('language-class/register') ?>" method="POST" id="bookingForm">
            <?= csrf_field() ?>
            <input type="hidden" name="language" value="<?= esc($lang) ?>">
            <input type="hidden" name="schedule_date" value="<?= esc($date) ?>">
            <input type="hidden" name="session_time" value="<?= esc($time) ?>">
            <input type="hidden" name="seat_number" id="inputSeatNumber" value="">
            
            <div class="bottom-bar">
                <div>
                    <div style="font-size: 12px; color: #9ca3af;">Kursi Terpilih:</div>
                    <div class="selected-seat-info" id="selectedSeatLabel">-</div>
                </div>
                <button type="submit" class="btn-confirm" id="btnConfirm" disabled>Konfirmasi Kursi</button>
            </div>
        </form>

    </div>
</div>

<script>
let selectedSeat = null;

function selectSeat(seatNum) {
    // Remove selected class from all
    document.querySelectorAll('.seat.available').forEach(el => el.classList.remove('selected'));
    
    // Add selected class to clicked
    const seatEl = document.querySelector(`.seat[data-seat="${seatNum}"]`);
    if(seatEl && !seatEl.classList.contains('occupied')) {
        seatEl.classList.add('selected');
        selectedSeat = seatNum;
        
        // Update UI & Form
        document.getElementById('selectedSeatLabel').innerText = seatNum;
        document.getElementById('inputSeatNumber').value = seatNum;
        document.getElementById('btnConfirm').disabled = false;
    }
}
</script>

<?= $this->endSection() ?>
