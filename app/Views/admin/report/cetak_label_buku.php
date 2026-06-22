<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label Buku</title>
    <style>
        /* Reset dan pengaturan dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            background: #f0f0f0;
            padding: 15px;
        }

        /* Tombol cetak — hanya tampil di layar */
        .tombol-cetak {
            text-align: center;
            margin-bottom: 15px;
        }

        .tombol-cetak button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 30px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 5px;
        }

        .tombol-cetak button.btn-kembali {
            background-color: #6c757d;
        }

        .tombol-cetak button:hover {
            opacity: 0.85;
        }

        /* Judul halaman */
        .judul-halaman {
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: bold;
        }

        /* Kontainer semua label — layout grid */
        .grid-label {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            max-width: 19cm;
            margin: 0 auto;
        }

        /* Satu label buku */
        .label-buku {
            background: white;
            border: 2px solid #333;
            border-radius: 4px;
            padding: 10px 12px;
            min-height: 5cm;
            page-break-inside: avoid;
        }

        /* Header label — nama perpustakaan */
        .label-header {
            background-color: #1a3a5c;
            color: white;
            text-align: center;
            padding: 5px 4px;
            margin: -10px -12px 8px -12px;
            border-radius: 2px 2px 0 0;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        /* Kode buku — ditampilkan besar dan mencolok */
        .label-kode {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            border: 2px solid #333;
            padding: 4px;
            margin-bottom: 8px;
            letter-spacing: 2px;
            background-color: #fffde7;
        }

        /* Garis pemisah */
        .label-divider {
            border: none;
            border-top: 1px solid #999;
            margin: 6px 0;
        }

        /* Baris informasi buku */
        .label-row {
            display: flex;
            margin-bottom: 3px;
            line-height: 1.4;
        }

        .label-key {
            font-weight: bold;
            min-width: 60px;
            color: #333;
            flex-shrink: 0;
        }

        .label-sep {
            margin: 0 4px;
            flex-shrink: 0;
        }

        .label-val {
            color: #111;
            word-break: break-word;
        }

        /* Saat dicetak */
        @media print {
            body {
                background: white;
                padding: 5mm;
            }

            .tombol-cetak {
                display: none;
            }

            .judul-halaman {
                display: none;
            }

            .grid-label {
                gap: 6mm;
                max-width: 100%;
            }

            .label-buku {
                border: 1.5pt solid #000;
                break-inside: avoid;
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

    <!-- Tombol aksi (tidak ikut tercetak) -->
    <div class="tombol-cetak">
        <button onclick="window.print()">&#128438; Cetak / Simpan sebagai PDF</button>
        <button class="btn-kembali" onclick="window.close()">&#10006; Tutup</button>
    </div>

    <div class="judul-halaman">
        Label Buku &mdash; Dicetak: <?= date('d F Y, H:i') ?> WIB
        &mdash; Total: <?= count($books) ?> buku
    </div>

    <!-- Grid semua label -->
    <div class="grid-label">
        <?php foreach($books as $book): ?>
        <div class="label-buku">

            <div class="label-header">
                &#128218; PERPUSTAKAAN &mdash; LIBRARY INFORMATION SYSTEM
            </div>

            <div class="label-kode">
                <?= strtoupper(esc($book['call_number'] ?? '')) ?>
            </div>

            <hr class="label-divider">

            <div class="label-row">
                <span class="label-key">Judul</span>
                <span class="label-sep">:</span>
                <span class="label-val"><?= esc($book['title'] ?? '') ?></span>
            </div>
            <div class="label-row">
                <span class="label-key">Penulis</span>
                <span class="label-sep">:</span>
                <span class="label-val"><?= esc($book['author'] ?? '') ?></span>
            </div>
            <div class="label-row">
                <span class="label-key">Penerbit</span>
                <span class="label-sep">:</span>
                <span class="label-val"><?= esc($book['publisher'] ?? '') ?></span>
            </div>
            <div class="label-row">
                <span class="label-key">Tahun</span>
                <span class="label-sep">:</span>
                <span class="label-val"><?= esc($book['year'] ?? '') ?></span>
            </div>
            <?php if(!empty($book['isbn'])): ?>
            <div class="label-row">
                <span class="label-key">ISBN</span>
                <span class="label-sep">:</span>
                <span class="label-val"><?= esc($book['isbn']) ?></span>
            </div>
            <?php endif; ?>

        </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
