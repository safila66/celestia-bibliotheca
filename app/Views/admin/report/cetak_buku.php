<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        /* Pengaturan tampilan halaman */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #000;
        }

        /* Header report */
        .header-report {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header-report h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header-report p {
            margin: 4px 0 0 0;
            font-size: 12px;
            color: #555;
        }

        /* Tabel data */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background-color: #343a40;
            color: #fff;
            padding: 8px;
            text-align: left;
            border: 1px solid #999;
            font-size: 11px;
        }

        table td {
            padding: 6px 8px;
            border: 1px solid #ccc;
            vertical-align: top;
            font-size: 11px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Tombol cetak — hanya tampil di layar, tidak ikut tercetak */
        .tombol-cetak {
            text-align: right;
            margin-bottom: 15px;
        }

        .tombol-cetak button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 20px;
            font-size: 13px;
            border-radius: 4px;
            cursor: pointer;
        }

        .tombol-cetak button:hover {
            background-color: #c82333;
        }

        /* Saat dicetak: sembunyikan tombol, pastikan semua terlihat */
        @media print {
            .tombol-cetak {
                display: none;
            }

            body {
                margin: 10px;
            }

            table th {
                background-color: #343a40 !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Cetak (hanya muncul di layar, tidak ikut tercetak) -->
    <div class="tombol-cetak">
        <button onclick="window.print()">
            &#128438; Cetak / Simpan sebagai PDF
        </button>
    </div>

    <!-- Header report -->
    <div class="header-report">
        <h2>report Data Buku</h2>
        <p>Library Information System</p>
        <p>Dicetak pada: <?= date('d F Y, H:i') ?> WIB</p>
    </div>

    <!-- Tabel Data Buku -->
    <table>
        <thead>
            <tr>
                <th width="40">No.</th>
                <th>Judul Buku</th>
                <th>Kode</th>
                <th>ISBN</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 0; ?>
            <?php foreach($books as $book): ?>
                <?php $no++; ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $book['title_book'] ?></td>
                    <td><?= $book['code_book'] ?></td>
                    <td><?= $book['isbn_book'] ?></td>
                    <td><?= $book['author_book'] ?></td>
                    <td><?= $book['publisher_book'] ?></td>
                    <td><?= $book['published_year'] ?></td>
                    <td><?= $book['description_book'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
