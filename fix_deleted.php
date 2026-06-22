<?php
$c = new mysqli('localhost', 'root', '', 'celesthica');
$c->query("UPDATE books SET deleted_at = NULL WHERE deleted_at = '0000-00-00 00:00:00'");
echo 'Fixed deleted_at';
