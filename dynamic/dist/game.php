<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ゲーム画面｜みんニャでかんたんBINGO</title>
<meta name="description" content="みんニャでかんたんBINGOで遊んでにゃ〜">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- favicon -->
<link rel="icon" type="image/x-icon" href="img/favicon.ico">
<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon-180x180.png">
<!-- css -->
<link rel="stylesheet" href="css/base.css">
<link rel="stylesheet" href="css/game.css">
</head>
<body id="main">
<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/Bingo.php';

//var_dump($_POST);
//var_dump($_GET);

$bingoApp = new \MyApp\Bingo();

$bingoApp->getMaxRank();

//音声入力された。
if (isset($_GET['bingo'])) {
    echo "<p>音声入力された文字は「" . $_GET['bingo'] . "」です</p>";

    //ビンゴと言われたかチェックする
    if ($_GET['bingo'] === "bingo") {
        //ビンゴしたかチェックする
        $bingoApp->checkBingo($_COOKIE['name']);
    }
}

//リセットボタンが押された
if (isset($_GET['reset'])) {
    echo "番号reset!!!";
    $bingoApp->resetNum();
}

if (isset($_GET['resetuser'])) {
    echo "ユーザーreset!!!";
    $bingoApp->resetUser();

}

//ユーザー登録ボタンが押された
if (isset($_GET['user'])) {
    echo "add user";
    $bingoApp->addUser($_GET['user'], $_GET['num1'], $_GET['num2'], $_GET['num3'], $_GET['num4'], $_GET['num5']);
}

$numbers = $bingoApp->getAll();
$users = $bingoApp->getAllUsers();
//var_dump($users);
//var_dump($numbers);

if (isset($_GET['comment'])) {
    if (count($numbers) !== 31) {
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
?>
<div class="wrap"> 
  <!-- START / header ========== -->
  <header>
    <h1><img src="img/logo.png" alt="みんニャでかんたんBINGO"></h1>
  </header>
  <!-- END / header ========== -->
  <div class="contents"> <!-- START / スロットまわす ========== -->
    <section class="history"> 
      <!-- START / ボタン ========== --> 
      <!-- <a class="btn-base btn-blue">スロットまわす</a>  -->
      <form action="game.php" method="get">
        <p>
          <input type=“text” name =comment style="display:none" value="start">
          <!-- TODO:beforeとafterのマークがつかない。 -->
          <input type="submit" class="btn-base btn-blue" value="スロットまわす">
        </p>
      </form>
      <!-- END / ボタン ========== --> 
      <!-- START / NEW ========== -->
      <div class="history__newone">
        <p><span><?php if (isset($bingo)) { echo $bingo; }?></span></p>
      </div>
      <!-- END / NEW ========== -->
      <ul class="history__list">
      <?php
        foreach ($numbers as $number) {
            //var_dump($number);
            echo '<li>' . $number["number"] . '</li>';
            echo " ";
        }
      ?>
      </ul>
    </section>
    <!-- END / スロットまわす ========== --> 
    <!-- START / ビンゴさけぶ ========== -->
    <section class="post">
      <div class="post__img"> <img src="img/cat03.png" alt="さけびにゃんこ"> </div>
      <div class="post__text">
        <div class="post__box">5つの数字がそろったら<strong> ビンゴさけぶ </strong>ボタンを押して<strong> "BINGO" をさけんでください</strong> ニャ </div>
      </div>
    </section>
    <!-- START / ボタン ========== --> 
    <a class="btn-base btn-bingo" id="btn">BINGOさけぶ</a> 
    <!-- END / ボタン ========== --> 
    <!-- END / ビンゴさけぶ ========== --> 
    <!-- START / メンバー ========== -->
    <section class="member">
      <div class="member__box">
      <?php
        foreach ($users as $user) {

          $rank = $bingoApp->getRank($user["name"]);

          echo '<div class="member__item ';
          
            if ($rank === 0) {
                echo "";
            } else if($rank === '1'){
                echo "is-1st";
            } else if($rank === '2'){
            echo "is-2nd";
          } else if($rank === '3'){
            echo "is-3rd";
          } else {
            echo "is-" . $rank . "-th";
          }
          echo ' ">';
          
          //Cookieが設定されているときのみ
          if(isset($_COOKIE["name"])){
            if ($_COOKIE["name"] == $user["name"]) {
              // 自身が登録したユーザ名の場合は背景色を変更する(1ユーザのみ)
              echo '<h3 style="background-color: #FFAD3B;">' . $user["name"] . '</h3>';
            } else {
              // 他人が登録したユーザ名の場合は背景色はデフォルト
              echo '<h3>' . $user["name"] . '</h3>';
            }      
          }
          else{
              // 他人が登録したユーザ名の場合は背景色はデフォルト
              echo '<h3>' . $user["name"] . '</h3>';
          }

          //var_dump($number);
            echo '<ul><li>' . $user["num1"] . '</li><li>' . $user["num2"] . '</li><li>' . $user["num3"] . '</li><li>' . $user["num4"] . '</li><li>' . $user["num5"] . "</ul>";
          echo '</div>';
        }
        ?>
      </div>
    </section>
    <!-- END / メンバー ========== --> 
    <!-- START / ボタン ========== --> 
    <a class="btn-base btn-blue">やめる</a> 
    <!-- END / ボタン ========== --> 
  </div>
  <!-- START / footer ========== -->
  <footer class="footer">
    <div class="footer__deco">
      <ul>
        <li><span class="footer__tree01"></span></li>
        <li><span class="footer__house01"></span></li>
        <li><span class="footer__house02"></span></li>
        <li><span class="footer__house03"></span></li>
        <li><span class="footer__house04"></span></li>
        <li><span class="footer__house05"></span></li>
        <li><span class="footer__house06"></span></li>
        <li><span class="footer__tree02"></span></li>
      </ul>
    </div>
    <a class="footer__alpaca" data-scroll href="#main"></a>
    <p class="footer__copy">© team BINGO !!</p>
  </footer>
  <!-- END / footer ========== --> 
  <div id="content"></div>
</div>
<!-- smooth scroll --> 
<script src="js/smooth-scroll.min.js"></script> 
<script>var scroll = new SmoothScroll('a[href*="#"]');</script>
<script>
const speech = new webkitSpeechRecognition();
speech.lang = 'en-US';

const btn = document.getElementById('btn');
const content = document.getElementById('content');

btn.addEventListener('click', function(){
    speech.start();
});

speech.addEventListener('result', function(e){
    console.log(e);

    const text = e.results[0][0].transcript;
    content.innerText = text;

    if(text == "bingo"){
      console.log("bingo!");
      execPost("game.php",  {'bingo':text});
    }else{
      console.log("not bingo!");
      execPost("game.php",  {'bingo':text});
    }
});

/**
 * データをPOSTする
 * @param String アクション
 * @param Object POSTデータ連想配列
 * 記述元Webページ http://fujiiyuuki.blogspot.jp/2010/09/formjspost.html
 * サンプルコード
 * <a onclick="execPost('/hoge', {'fuga':'fuga_val', 'piyo':'piyo_val'});return false;" href="#">POST送信</a>
 */
function execPost(action, data) {
 // フォームの生成
 var form = document.createElement("form");
 form.setAttribute("action", action);
 form.setAttribute("method", "get");
 form.style.display = "none";
 document.body.appendChild(form);
 // パラメタの設定
 if (data !== undefined) {
  for (var paramName in data) {
   var input = document.createElement('input');
   input.setAttribute('type', 'hidden');
   input.setAttribute('name', paramName);
   input.setAttribute('value', data[paramName]);
   form.appendChild(input);
  }
 }
 // submit
 form.submit();
}
</script>
</body>
</html>