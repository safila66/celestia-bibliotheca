<?php
$ch = curl_init('http://localhost:8080/profil/tab/tickets');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
if ($res === false) {
    echo "cURL ERROR: " . curl_error($ch) . "\n";
} else {
    echo "STATUS: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
    echo "RESPONSE:\n" . $res . "\n";
}
