<?php
$c = stream_context_create(['http' => ['ignore_errors' => true]]);
$res = file_get_contents('http://localhost:8080/profil/tab/tickets', false, $c);
echo strip_tags($res);
