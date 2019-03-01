<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/Bingo.php';

$contents = $_GET['kind'];
$bingoApp = new \MyApp\Bingo();

if($contents === 'goslot'){
    $bingo = $bingoApp->slot(0, 30);
}

echo (string)$bingo;

?>