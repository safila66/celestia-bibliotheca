<?php
$c = new mysqli('localhost', 'root', '', 'celesthica');
$r = $c->query('SELECT id, name FROM categories LIMIT 5');
while ($row = $r->fetch_assoc()) {
    print_r($row);
}
