<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>スタート画面｜みんニャでかんたんBINGO</title>
<meta name="description" content="みんニャでかんたんBINGOで遊んでにゃ〜">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- favicon -->
<link rel="icon" type="image/x-icon" href="img/favicon.ico">
<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon-180x180.png">
<!-- css -->
<link rel="stylesheet" href="css/base.css">
<link rel="stylesheet" href="css/top.css">
</head>
<body id="main">
<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/Bingo.php';

$bingoApp = new \MyApp\Bingo();

$bingoApp->getMaxRank();

if (isset($_COOKIE['name'])) {
    echo "<p>私の名前は" . $_COOKIE['name'] . "です</p>";
} else {
    echo "<p>ビンゴカードが未登録です</p>";
}

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

?>
<div class="wrap"> 
  <!-- START / header ========== -->
  <header>
    <h1><img src="img/logo.png" alt="みんニャでかんたんBINGO"></h1>
  </header>
  <!-- END / header ========== -->
  <div class="contents"> <!-- START / 説明 ========== -->
    <section class="instoduce">
      <div class="instoduce__img"> <img src="img/cat01.png" alt="ころがりにゃんこ"> </div>
      <div class="instoduce__text">
        <div class="instoduce__box"> まずは下のフォームに<strong>お名前</strong>と<strong>お好きな番号（0〜30）</strong>を入力＆登録してお待ちくださいニャ
          <ul>
            <li>お名前はアルファベット小文字で入力してください</li>
            <li>同じ番号は登録できません</li>
          </ul>
        </div>
      </div>
    </section>
    <!-- END / 説明 ========== --> 
    <!-- START / 登録フォーム ========== -->
    <section class="form">
      <form action="index.php" method="get">
        <p><span>お名前</span>
          <input type="text" name="user" placeholder="お名前を入れてニャ" required>
        </p>
        <ul>
          <li> <span>番号1</span>
            <select name="num1">
              <option value="">未設定</option>
              <option value="00">00</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
            </select>
          </li>
          <li> <span>番号2</span>
            <select name="num2">
              <option value="">未設定</option>
              <option value="00">00</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
            </select>
          </li>
          <li> <span>番号3</span>
            <select name="num3">
              <option value="">未設定</option>
              <option value="00">00</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
            </select>
          </li>
          <li> <span>番号4</span>
            <select name="num4">
              <option value="">未設定</option>
              <option value="00">00</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
            </select>
          </li>
          <li> <span>番号5</span>
            <select name="num5">
              <option value="">未設定</option>
              <option value="00">00</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
            </select>
          </li>
          <li>
            <input type="submit" value="登録">
          </li>
        </ul>
      </form>
    </section>
    <!-- END / 登録フォーム ========== --> 
    <!-- START / 登録済みメンバー ========== -->
    <h2>登録済みメンバー</h2>
    <section class="member">
      <ul>
	  	<?php
		foreach ($users as $user) {
    		echo '<li>' . $user["name"] . '</li>';
		}
		?>
      </ul>
    </section>
    <!-- END / 登録済みメンバー ========== --> 
	<!-- START / ボタン ========== --> 
	<!-- TODO: game.phpへのリンクが機能しない。。。 -->
    <a href="game.php" class="btn-base btn-blue">はじめる</a> 
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
</div>
<!-- smooth scroll --> 
<script src="js/smooth-scroll.min.js"></script> 
<script>var scroll = new SmoothScroll('a[href*="#"]');</script>
<script>
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