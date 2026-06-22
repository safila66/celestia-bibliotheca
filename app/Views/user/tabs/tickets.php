<h3 class="section-title">TIKET & BOOKING AKTIF</h3>

<?php if (empty($roomBookings) && empty($classRegistrations)): ?>
    <div style="text-align: center; color: var(--text-dim); padding: 40px; background: rgba(255,255,255,0.02); border-radius: 8px;">
        Belum ada tiket atau booking aktif saat ini.
    </div>
<?php else: ?>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        
        <?php foreach ($roomBookings as $b): ?>
            <div style="background: rgba(201,168,76,0.05); border: 1px solid rgba(201,168,76,0.3); border-radius: 8px; padding: 20px; display: flex; flex-direction: column;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px; align-items: flex-start;">
                    <div>
                        <span style="font-size: 10px; color: var(--gold); text-transform: uppercase; letter-spacing: 0.1em; border: 1px solid var(--gold); padding: 2px 6px; border-radius: 4px;">Room Booking</span>
                        <h4 style="margin: 8px 0 4px; font-family: 'Cinzel', serif; color: var(--ivory); font-size: 18px;"><?= esc($b['room_name']) ?></h4>
                        <div style="color: var(--text-dim); font-size: 13px;">
                            <i class="far fa-calendar-alt" style="margin-right: 5px;"></i> <?= esc($b['booking_date']) ?><br>
                            <i class="far fa-clock" style="margin-right: 5px;"></i> <?= esc($b['start_time']) ?> - <?= esc($b['end_time']) ?>
                        </div>
                    </div>
                    <div style="background: rgba(76,175,80,0.2); color: #4caf50; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">
                        <?= ucfirst(esc($b['status'])) ?>
                    </div>
                </div>
                
                <button class="btn-action" onclick="showTicketQR('<?= base_url('scan/room-booking/'.$b['id']) ?>', 'Room: <?= esc($b['room_name']) ?>')" style="margin-top: auto; background: var(--gold); color: #1a1a2e; border: none; padding: 10px; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%;">
                    <i class="fas fa-qrcode" style="margin-right: 8px;"></i> Tampilkan QR Code
                </button>
            </div>
        <?php endforeach; ?>

        <?php foreach ($classRegistrations as $c): ?>
            <div style="background: rgba(138,180,248,0.05); border: 1px solid rgba(138,180,248,0.3); border-radius: 8px; padding: 20px; display: flex; flex-direction: column;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px; align-items: flex-start;">
                    <div>
                        <span style="font-size: 10px; color: #8ab4f8; text-transform: uppercase; letter-spacing: 0.1em; border: 1px solid #8ab4f8; padding: 2px 6px; border-radius: 4px;">Language Class</span>
                        <h4 style="margin: 8px 0 4px; font-family: 'Cinzel', serif; color: var(--ivory); font-size: 18px;">Language: <?= esc($c['language']) ?></h4>
                        <div style="color: var(--text-dim); font-size: 13px;">
                            <i class="far fa-calendar-alt" style="margin-right: 5px;"></i> <?= esc($c['schedule_date']) ?> <br>
                            <i class="far fa-clock" style="margin-right: 5px;"></i> <?= esc($c['session_time']) ?> <br>
                            <i class="fas fa-door-open" style="margin-right: 5px;"></i> <?= esc($c['room']) ?> - Seat <?= esc($c['seat_number']) ?>
                        </div>
                    </div>
                    <div style="background: rgba(76,175,80,0.2); color: #4caf50; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">
                        <?= ucfirst(esc($c['status'])) ?>
                    </div>
                </div>
                
                <button class="btn-action" onclick="showTicketQR('<?= base_url('scan/language/'.$c['id']) ?>', 'Class: <?= esc($c['language']) ?>')" style="margin-top: auto; background: #8ab4f8; color: #1a1a2e; border: none; padding: 10px; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%;">
                    <i class="fas fa-qrcode" style="margin-right: 8px;"></i> Tampilkan QR Code
                </button>
            </div>
        <?php endforeach; ?>

    </div>
<?php endif; ?>


