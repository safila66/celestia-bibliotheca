<?php
$conn = new mysqli('localhost', 'root', '', 'celesthica');
if ($conn->connect_error) die("Connection failed");
$res = $conn->query("DESCRIBE roombookings");
while ($row = $res->fetch_array()) {
    echo $row[0] . "\n";
}
