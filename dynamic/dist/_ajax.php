<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/Bingo.php';

$contents = $_GET['kind'];
$bingoApp = new \MyApp\Bingo();
$numbers = $bingoApp->getAll();

if($contents === 'goslot'){
    if (count($numbers) !== 30) {
        do {
            $bingo = rand(0, 30);
            $first = true;
            foreach ($numbers as $number) {
                //var_dump($number);
                if (intval($number["number"]) === $bingo) {
                    $first = false; //既出
                    break;
                }
            }
        } while ($first === false); //既出の限り続く

        $bingoApp->insertNum($bingo);
    } else {
        echo "番号が全て出たのでビンゴを回せません！";
    }
}

echo (string)$bingo;

// $str = "AJAX REQUEST SUCCESS" . " contens=" . $contents . " bingo=" . $bingo;
// $result = nl2br($str);
// echo $result;

?>