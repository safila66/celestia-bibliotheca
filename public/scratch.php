<?php
$conn = new mysqli('localhost', 'root', '', 'celesthica');

// Insert dummy fine
$sql = "INSERT INTO fines (user_id, loan_id, amount, status, description, created_at, updated_at) 
        VALUES (1, 1, 5000, 'unpaid', 'Terlambat 5 hari (Buku: Capital)', NOW(), NOW())";
$conn->query($sql);
if ($conn->error) {
    echo "DB Error: " . $conn->error;
} else {
    echo "Fine inserted successfully!";
}
