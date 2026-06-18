<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label — <?= $book['title_book'] ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            background: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        /* Tombol aksi */
        .tombol-cetak {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tombol-cetak button {
            padding: 10px 25px;
            font-size: 13px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .btn-print  { background-color: #dc3545; }
        .btn-close  { background-color: #6c757d; }
        .btn-print:hover { background-color: #c82333; }
        .btn-close:hover { background-color: #5a6268; }

        /* Keterangan kecil */
        .info-cetak {
            font-size: 11px;
            color: #666;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Label tunggal — lebih besar */
        .label-buku {
            background: white;
            border: 2px solid #333;
            border-radius: 6px;
            width: 10cm;
            min-height: 7cm;
            padding: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .label-header {
            background-color: #1a3a5c;
            color: white;
            text-align: center;
            padding: 8px;
            border-radius: 4px 4px 0 0;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .label-body {
            padding: 14px 16px;
        }

        .label-kode {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            border: 2px solid #333;
            padding: 6px;
            margin-bottom: 12px;
            letter-spacing: 3px;
            background-color: #fffde7;
        }

        .label-divider {
            border: none;
            border-top: 1px solid #ccc;
            margin: 8px 0;
        }

        .label-row {
            display: flex;
            margin-bottom: 5px;
            font-size: 12px;
            line-height: 1.5;
        }

        .label-key {
            font-weight: bold;
            min-width: 70px;
            color: #444;
            flex-shrink: 0;
        }

        .label-sep {
            margin: 0 6px;
            flex-shrink: 0;
        }

        .label-val {
            color: #111;
        }

        .label-footer {
            background-color: #f8f8f8;
            border-top: 1px solid #ddd;
            text-align: center;
            padding: 6px;
            font-size: 10px;
            color: #888;
            border-radius: 0 0 4px 4px;
        }

        /* Saat dicetak */
        @media print {
            body {
                background: white;
                padding: 10mm;
                justify-content: flex-start;
            }

            .tombol-cetak,
            .info-cetak {
                display: none;
            }

            .label-buku {
                box-shadow: none;
                width: 9cm;
                border: 2pt solid #000;
            }

            .label-header {
                background-color: #1a3a5c !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .label-kode {
                background-color: #fffde7 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol aksi -->
    <div class="tombol-cetak">
        <button class="btn-print" onclick="window.print()">&#128438; Cetak / Simpan sebagai PDF</button>
        <button class="btn-close" onclick="window.close()">&#10006; Tutup</button>
    </div>

    <div class="info-cetak">
        Label untuk 1 buku &mdash; Dicetak: <?= date('d F Y, H:i') ?> WIB
    </div>

    <!-- Label tunggal -->
    <div class="label-buku">

        <div class="label-header">
            &#128218; PERPUSTAKAAN &mdash; LIBRARY INFORMATION SYSTEM
        </div>

        <div class="label-body">

            <div class="label-kode">
                <?= strtoupper($book['code_book']) ?>
            </div>

            <hr class="label-divider">

            <div class="label-row">
                <span class="label-key">Judul</span>
                <span class="label-sep">:</span>
                <span class="label-val"><?= $book['title_book'] ?></span>
            </div>
            <div class="label-row">
                <span class="label-key">Penulis</span>
                <span class="label-sep">:</span>
                <span class="label-val"><?= $book['author_book'] ?></span>
            </div>
            <div class="label-row">
                <span class="label-key">Penerbit</span>
                <span class="label-sep">:</span>
                <span class="label-val"><?= $book['publisher_book'] ?></span>
            </div>
            <div class="label-row">
                <span class="label-key">Tahun</span>
                <span class="label-sep">:</span>
                <span class="label-val"><?= $book['published_year'] ?></span>
            </div>
            <?php if(!empty($book['isbn_book'])): ?>
            <div class="label-row">
                <span class="label-key">ISBN</span>
                <span class="label-sep">:</span>
                <span class="label-val"><?= $book['isbn_book'] ?></span>
            </div>
            <?php endif; ?>
            <?php if(!empty($book['description_book'])): ?>
            <div class="label-row">
                <span class="label-key">Ket.</span>
                <span class="label-sep">:</span>
                <span class="label-val"><?= $book['description_book'] ?></span>
            </div>
            <?php endif; ?>

        </div>

        <div class="label-footer">
            ID Buku: <?= $book['id_book'] ?>
        </div>

    </div>
    
</body>
</html>