<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'celesthica');
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
$stmt = $mysqli->prepare("UPDATE books SET cover_image = '../images/tsoa_book_cover.jpg' WHERE title LIKE '%Achilles%'");
$stmt->execute();
echo $mysqli->affected_rows . " rows updated.";
$mysqli->close();
?>
