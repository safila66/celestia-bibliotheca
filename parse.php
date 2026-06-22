<?php
$json = file_get_contents('error.json');
$data = json_decode($json, true);
echo $data['message'] . "\nFile: " . $data['file'] . " on line " . $data['line'] . "\n";
