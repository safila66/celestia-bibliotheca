<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Anggota</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f0f0; padding: 20px; }
        
        .tombol-cetak { text-align: center; margin-bottom: 20px; }
        .tombol-cetak button { background-color: #dc3545; color: white; border: none; padding: 10px 30px; font-size: 14px; border-radius: 4px; cursor: pointer; margin: 0 5px; }
        .tombol-cetak button.btn-kembali { background-color: #6c757d; }
        
        .grid-kartu { display: grid; grid-template-columns: repeat(auto-fill, 8.5cm); gap: 15px; justify-content: center; }
        
        /* Desain Kartu (Ukuran standar ID Card: 8.5cm x 5.4cm) */
        .kartu-member {
            width: 8.5cm;
            height: 5.4cm;
            background: linear-gradient(135deg, #0a0f18 0%, #1a2332 100%);
            border: 1px solid #c9a84c;
            border-radius: 8px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            page-break-inside: avoid;
        }

        .kartu-header {
            background: rgba(201,168,76,0.15);
            border-bottom: 1px solid rgba(201,168,76,0.3);
            padding: 8px;
            text-align: center;
        }

        .kartu-title {
            color: #c9a84c;
            font-family: 'Times New Roman', serif;
            font-weight: bold;
            font-size: 12px;
            letter-spacing: 1px;
            margin: 0;
        }

        .kartu-body {
            padding: 10px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .kartu-photo {
            width: 2.2cm;
            height: 2.8cm;
            background: #fff;
            border: 2px solid #c9a84c;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #888;
            overflow: hidden;
        }
        
        .kartu-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .kartu-info {
            flex: 1;
            font-size: 10px;
            line-height: 1.4;
        }

        .kartu-name {
            font-weight: bold;
            font-size: 14px;
            color: #fff;
            margin-bottom: 5px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding-bottom: 4px;
        }

        .info-row {
            display: flex;
            margin-bottom: 2px;
        }
        
        .info-label {
            color: #aaa;
            width: 40px;
        }
        
        .info-val {
            color: #e0e0e0;
            font-weight: bold;
        }

        .kartu-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: #c9a84c;
            color: #000;
            text-align: center;
            padding: 4px;
            font-size: 9px;
            font-weight: bold;
        }

        @media print {
            body { background: white; padding: 0; }
            .tombol-cetak { display: none; }
            .kartu-member {
                border: 1pt solid #c9a84c;
                box-shadow: none;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .grid-kartu { gap: 5mm; }
        }
    </style>
</head>
<body>

    <div class="tombol-cetak">
        <button onclick="window.print()">🖨️ Cetak Kartu Anggota</button>
        <button class="btn-kembali" onclick="window.close()">✖️ Tutup</button>
    </div>

    <div class="grid-kartu">
        <?php foreach($members as $m): ?>
        <div class="kartu-member">
            <div class="kartu-header">
                <h3 class="kartu-title">BIBLIOTHECA STELLARUM</h3>
            </div>
            
            <div class="kartu-body">
                <div class="kartu-photo">
                    <?php if(!empty($m['photo'])): ?>
                        <img src="<?= base_url('uploads/profiles/' . $m['photo']) ?>" alt="Foto">
                    <?php else: ?>
                        FOTO<br>3x4
                    <?php endif; ?>
                </div>
                
                <div class="kartu-info">
                    <div class="kartu-name"><?= esc($m['name'] ?? 'Anggota') ?></div>
                    
                    <div class="info-row">
                        <div class="info-label">ID</div>
                        <div class="info-val">: MEM-<?= str_pad($m['id'], 4, '0', STR_PAD_LEFT) ?></div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-val">: <?= esc($m['email'] ?? '-') ?></div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Telp</div>
                        <div class="info-val">: <?= esc($m['phone'] ?? '-') ?></div>
                    </div>
                </div>
            </div>
            
            <div class="kartu-footer">
                KARTU ANGGOTA PERPUSTAKAAN
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
