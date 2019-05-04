
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/../Bingo.php';



if (isset($_POST['reset'])) {

    $bingoApp = new \MyApp\Bingo();

    $bingoApp->resetNum();
    $bingoApp->resetUser();

    echo "<script>alert('ビンゴデータをリセットしました');</script>";

}

?>

<script>
    /**
     * 確認ダイアログの返り値によりフォーム送信
    */
    function submitChk () {
        /* 確認ダイアログ表示 */
        var flag = confirm ( "ビンゴをリセットしてもよろしいですか？\n\nリセットしたくない場合は[キャンセル]ボタンを押して下さい");
        /* send_flg が TRUEなら送信、FALSEなら送信しない */
        return flag;
    }
</script>


<form action="reset.php" method="post" onsubmit="return submitChk()">
    <input type="text" name="reset" style="display:none"  value="reset" /><br/>
    <input type="submit" value="ビンゴをリセットする"/>
</form>


</body>
</html>


