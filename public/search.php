<?php
$path = 'C:\xampp\htdocs\celestia-bibliotheca\app\Views';
$dir = new RecursiveDirectoryIterator($path);
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
foreach($files as $file) {
    $content = file_get_contents($file[0]);
    if (preg_match('/(qrserver|qris)/i', $content)) {
        echo str_replace($path, '', $file[0]) . "\n";
    }
}
echo "Done";
