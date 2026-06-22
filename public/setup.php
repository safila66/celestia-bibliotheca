<?php
$db = new PDO('mysql:host=localhost;dbname=celesthica', 'root', '');
try {
    $db->exec('ALTER TABLE language_classes ADD COLUMN seat_number INT NULL AFTER room, ADD COLUMN qr_code VARCHAR(255) NULL AFTER seat_number');
    echo "Success";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
