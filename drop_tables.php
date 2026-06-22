<?php
$db = new mysqli('localhost', 'root', '', 'celesthica');
$db->query('DROP TABLE IF EXISTS fines');
$db->query('DROP TABLE IF EXISTS roombookings');
$db->query('DROP TABLE IF EXISTS deliveries');
$db->query("DELETE FROM migrations WHERE class IN ('App\\\Database\\\Migrations\\\CreateFines', 'App\\\Database\\\Migrations\\\CreateRoomBooking', 'App\\\Database\\\Migrations\\\CreateDeliveries')");
echo "Done.";
