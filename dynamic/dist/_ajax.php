<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/Bingo.php';

$contents = $_GET['kind'];
$bingoApp = new \MyApp\Bingo();

if($contents === 'goslot'){
    $bingo = $bingoApp->slot(0, 30);
    echo (string)$bingo;
}
else if($contents === 'voice_bingo'){
    //echo "voice_bingo_string=" .  $_GET['voice'];

    //ビンゴと言われたかチェックする
    if ($_GET['voice'] === "bingo") {
        //ビンゴしたかチェックする
        $bingoApp->checkBingo($_COOKIE['name']);
    }
    else{
        //TODO::ビンゴじゃない言葉を検出したことをユーザーに放置したい
    }

    $rank = $bingoApp->getRank($_COOKIE["name"]);

    $array = array( "name" => $_COOKIE['name'], "rank" => $rank  );

    // Origin null is not allowed by Access-Control-Allow-Origin.とかのエラー回避の為、ヘッダー付与
    header("Access-Control-Allow-Origin: *");
    echo json_encode($array);

}
else if($contents === 'add_user'){
    // echo "add_user_res_form_ajax";

    // echo $_GET['user'];
    // echo $_GET['num1'];
    // echo $_GET['num2'];
    // echo $_GET['num3'];
    // echo $_GET['num4'];
    // echo $_GET['num5'];

    $bingoApp->addUser($_GET['user'], $_GET['num1'], $_GET['num2'], $_GET['num3'], $_GET['num4'], $_GET['num5']);

    echo $_GET['user'];
}

?>