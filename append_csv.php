<?php
$data = [
    ["ASAL MULA NEGARA", "M. Nasroen", "Aksara Baru Jakarta", "1986", "979-479-155-4", "320.11 NAS a", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Politik"],
    ["Pembangunan Berkelanjutan: Mencari Format Politik", "Yayasan Spes", "bekerja sama dengan", "1992", "979-511-590-1", "303 Spe p", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Politik"],
    ["Media Literacy in the Information Age: Current Perspective", "Robert Kubey", "Transaction Publishers", "1997", "978-1560002383", "302.23 KUB m", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Komunikasi"],
    ["GLOBAL INFORMATION AND WORLD COMMUNICATION", "Hamid Mowlana", "SAGE Publications", "1986", "978-0761952572", "302.2 Mow g", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Komunikasi"],
    ["KOMUNIKASI PEMERINTAHAN", "Erliana Hasan", "PT Refika Aditama", "2005", "979-3304-35-9", "302.2 Has k-2", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Komunikasi"],
    ["ELECTION FRAUD", "Alvarez, Thad E.", "Brookings Institution", "2008", "978-0815711392", "324.6 Alv e-1", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Politik"],
    ["Television Ethnicity and Cultural Change", "Marie Gillespie", "Routledge", "1995", "0-415-09675-8", "384.55 Gil t", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Komunikasi"],
    ["HARI HARI AKHIR TIMOR PORTUGIS", "E.M Tomodok", "Pustaka Jaya", "1994", "979-419-130-2", "959.87 Tom h", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Sejarah"],
    ["RAPERDA PENATAAN BIROKRASI DI KABUPATEN BLITAR", "Subiakto & Bag...", "Pemkab Blitar", "2003", "-", "350.532 Rap", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Sosiologi"],
    ["Technology, culture, and competitiveness: change and the world political economy", "Michael Talalay", "Routledge", "1997", "0-415-14254-7", "338.064 Tal t", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Politik"],
    ["ON DEMOCRACY", "Robert A. Dahl", "Yale University Press", "2000", "0-300-08455-2", "321 Dah o-3", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Politik"],
    ["Masyarakat yang Berhak Mendapatkan Subsidi Pemerintah", "Sudarso", "Lutfansah Mediatama", "2006", "979-24-5313-x", "338.18 Pem-1", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Sosiologi"],
    ["Buku Panduan tentang Mekanisme Kerja Anggota dan Parlemen", "Mohammad Novrizi", "IDP", "2008", "978-602-95694-2-1", "328.3 Nov b", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Sosiologi"],
    ["Pengelolaan Wisata Alam: Dalam Rangka meningkatkan Pendapatan Masyarakat", "Septi Ariadi", "Lutfansah", "2005", "979-9493-98-6", "338.4791 Ari p-4", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Sosiologi"],
    ["Television and Sexuality: Regulations and The Politic of Taste", "Jane Arthurs", "Open University Press", "2004", "335209750", "302.23 Art t-2", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Komunikasi"],
    ["Manfaat Fasilitasi Pembiayaan untuk Usaha Mikro, Kecil dan Menengah", "Septi Ariadi", "Lembaga Penelitian", "2012", "P-ISSN : 1858-0890", "338.642 Man", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Sosiologi"],
    ["Bahaya Tirani DPR", "Syamsuddin Haris", "Studi Politik", "2001", "-", "328.3 Bah", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Politik"],
    ["Program pengembangan Kecamatan (PKK)", "Suyanto", "Lutfansah Mediatama", "2002", "979-9493-25-0", "350.001 Pen -2", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Sosiologi"],
    ["Sosiologi Pendidikan Keindonesiaan", "Silfia Hanani", "Ar-Ruzz Media", "2013", "978-602-7874-42-8", "370.19 HAN s-1", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Sosiologi"],
    ["Pengantar Ilmu Politik", "F. Isjwara", "Angkasa Offset", "2016", "979-9326-00-1", "320 ISJ p-1", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Ilmu Politik"]
];

$fp = fopen('public/books_import.csv', 'a');

foreach ($data as $row) {
    array_unshift($row, ""); // prepend id
    fputcsv($fp, $row);
}

fclose($fp);
echo "Appended to CSV\n";
