<?php

$conn = new mysqli('localhost', 'root', '', 'celesthica');
$res = $conn->query("SELECT * FROM users");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
