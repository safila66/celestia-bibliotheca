<?php
$data = [
    ["Hutan dan Hujanpun Berhenti", "Farida Susanty", "", "2010", "", "", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Fiksi"],
    ["The Son of Neptune", "Rick Riordan", "", "2011", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Fiksi, Fantasi"],
    ["Mansfield Park", "Jane Austen", "", "1814", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik, Romansa"],
    ["Pride and Prejudice", "Jane Austen", "", "1813", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik, Romansa"],
    ["Autumn in Paris", "Ilana Tan", "", "2007", "", "", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Fiksi, Romansa"],
    ["Why?", "Stephanie Budiarta", "", "2015", "", "", "1", "", "", "Indonesia", "", "", "5", "5", "buku", "", "active", "", "", "", "Fiksi"],
    ["Looking for Alaska", "John Green", "", "2005", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Fiksi Remaja"],
    ["Paper Towns", "John Green", "", "2008", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Fiksi Remaja"],
    ["13 Reasons Why", "Jay Asher", "", "2007", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Fiksi Remaja"],
    ["Five Feet Apart", "Rachael Lippincott, Mikki Daughtry, Tobias Iaconis", "", "2018", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Fiksi Remaja"],
    ["White Nights", "Fyodor Dostoyevsky", "", "1848", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik"],
    ["Emma", "Jane Austen", "", "1815", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik, Romansa"],
    ["Persuasion", "Jane Austen", "", "1817", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik, Romansa"],
    ["Jane Eyre", "Charlotte Bronte", "", "1847", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik"],
    ["The Black Arrow", "Robert Louis Stevenson", "", "1888", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik, Petualangan"],
    ["The Fault in Our Stars", "John Green", "", "2012", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Fiksi Remaja"],
    ["A Midsummer Night's Dream", "William Shakespeare", "", "1600", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik, Drama"],
    ["Hamlet", "William Shakespeare", "", "1603", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik, Drama"],
    ["Mrs. Dalloway", "Virginia Woolf", "", "1925", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik"],
    ["Tales of King Arthur", "Henry Gilbert", "", "1911", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik, Fantasi"],
    ["Sense and Sensibility", "Jane Austen", "", "1811", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik, Romansa"],
    ["If We Were Villains", "M.L. Rio", "", "2017", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Thriller"],
    ["The Scarlet Letter", "Nathaniel Hawthorne", "", "1850", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik"],
    ["Northanger Abbey", "Jane Austen", "", "1817", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik"],
    ["Anna Karenina", "Leo Tolstoy", "", "1878", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik"],
    ["Oliver Twist", "Charles Dickens", "", "1838", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik"],
    ["Wuthering Heights", "Emily Bronte", "", "1847", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik"],
    ["Frankenstein", "Mary Shelley", "", "1818", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik, Horor"],
    ["Crime and Punishment", "Fyodor Dostoyevsky", "", "1866", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik"],
    ["The Phantom of the Opera", "Gaston Leroux", "", "1910", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik"],
    ["The Happy Prince and Other Tales", "Oscar Wilde", "", "1888", "", "", "1", "", "", "English", "", "", "5", "5", "buku", "", "active", "", "", "", "Klasik"]
];

$fp = fopen('public/books_import.csv', 'w');

// Headers based on phpmyadmin table 'books'
$headers = [
    "id", "title", "author", "publisher", "year", "isbn", "call_number", 
    "category_id", "description", "cover_image", "language", "pages", 
    "edition", "stock", "stock_available", "type", "file_pdf", "status", 
    "created_at", "updated_at", "deleted_at", "genres"
];
// fputcsv($fp, $headers);

foreach ($data as $row) {
    // prepend empty id
    array_unshift($row, "");
    fputcsv($fp, $row);
}

fclose($fp);
echo "CSV created at public/books_import.csv\n";
