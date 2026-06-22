<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=pmc&term=medicine&retmode=json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'mailto:library@celestia.edu');
$res = curl_exec($ch);
var_dump(curl_error($ch));
var_dump(curl_getinfo($ch, CURLINFO_HTTP_CODE));
echo "\nRESPONSE: \n";
echo substr($res, 0, 500);
