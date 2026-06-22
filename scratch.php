<?php
$conn = new mysqli('localhost', 'root', '', 'celesthica');
$result = $conn->query("DESCRIBE deliveries");
while ($row = $result->fetch_assoc()) {
    print_r($row);
}
