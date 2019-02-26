<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/Bingo.php';

//var_dump($_POST);
//var_dump($_GET);

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
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>ゲーム画面です | みんニャでかんたんBINGO</title>
    <meta name="description">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c:400,700,800">
    <link rel="stylesheet" type="text/css" href="./game/game.78a35d31.css">
  </head>
  <body class="body game">
    <main class="main" id="main">
      <h1 class="headline"><img src="./game/logo.814d17e3.png" alt="みんニャでかんたんBINGO"></h1>
      <section class="history">
        <button class="buttonPrimary">スロットまわす</button>
        <div class="history__newone">
          <p><span>\NEW/</span><span>99</span></p>
        </div>
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
      <section class="post">
		<p class="post__note">5つの数字がそろったら<b>ビンゴさけぶ</b>ボタンを押して<b>ビンゴをさけんでください</b>ニャ</p>
		<button class="buttonSecondary" id="btn">ビンゴさけぶ</button>
      </section>
      <section class="member">
        <div class="member__item">
          <h3>参加者 17</h3>
          <ul>
            <li>1</li>
            <li>88</li>
            <li>3</li>
            <li>7</li>
            <li>5</li>
          </ul>
        </div>
        <div class="member__item is-1st">
          <h3>参加者 16</h3>
          <ul>
            <li>1</li>
            <li>88</li>
            <li>3</li>
            <li>7</li>
            <li>5</li>
          </ul>
        </div>
        <div class="member__item is-2nd">
          <h3>参加者 18</h3>
          <ul>
            <li>1</li>
            <li>88</li>
            <li>3</li>
            <li>7</li>
            <li>5</li>
          </ul>
        </div>
        <div class="member__item">
          <h3>参加者 19</h3>
          <ul>
            <li>1</li>
            <li>88</li>
            <li>3</li>
            <li>7</li>
            <li>5</li>
          </ul>
        </div>
        <div class="member__item">
          <h3>参加者 8</h3>
          <ul>
            <li>1</li>
            <li>88</li>
            <li>3</li>
            <li>7</li>
            <li>5</li>
          </ul>
        </div>
        <div class="member__item is-10th">
          <h3>参加者 1</h3>
          <ul>
            <li>1</li>
            <li>88</li>
            <li>3</li>
            <li>7</li>
            <li>5</li>
          </ul>
        </div>
        <div class="member__item">
          <h3>参加者 44</h3>
          <ul>
            <li>1</li>
            <li>88</li>
            <li>3</li>
            <li>7</li>
            <li>5</li>
          </ul>
        </div>
      </section>
    </main>
    <footer class="footer">
      <button class="buttonPrimary">やめる</button>
      <div class="footer__deco">
        <button class="footer__tree01"></button>
        <button class="footer__house01"></button>
        <button class="footer__house02"></button>
        <button class="footer__house03"></button>
        <button class="footer__house04"></button>
        <button class="footer__house05"></button>
        <button class="footer__house06"></button>
        <button class="footer__tree02"></button><a class="footer__alpaca" href="#main"></a>
      </div>
      <p class="footer__copy">&copy; team BINGO !!</p>
    </footer>



  <div id="content"></div>

    <?php if (isset($bingo)) {
    echo "<h2>いま出た数字</h2><p>" . $bingo . "</p>";
}

?>

  <h2>今までに出た数字</h2>
  <?php
foreach ($numbers as $number) {
    //var_dump($number);
    echo $number["number"];
    echo " ";
}
?>
  <form action="index.php" method="get">
    <p>
     <input type=“text” name =comment style="display:none" value="start">
     <input type="submit" value="ビンゴを回す">
    </p>
  </form>

  <form action="index.php" method="get">
    <p>
     <input type=“text” name =reset style="display:none" value="reset">
     <input type="submit" value="ビンゴをリセットする">
    </p>
  </form>

  <h2>ビンゴカード</h2>

  <h3>ビンゴカードリスト</h3>
  <?php
echo "<table>";
echo "<tr><th>名前</th><th>番号1</th><th>番号2</th><th>番号3</th><th>番号4</th><th>番号5</th><th>順位</th></tr>";
foreach ($users as $user) {
    //var_dump($number);
    echo "<tr><td>" . $user["name"] . "</td><td>" . $user["num1"] . "</td><td>" . $user["num2"] . "</td><td>" . $user["num3"] . "</td><td>" . $user["num4"] . "</td><td>" . $user["num5"] . "</td>";

    $rank = $bingoApp->getRank($user["name"]);
    if ($rank === 0) {
        echo "<td></td></tr>";
    } else {
        echo "<td>" . $rank . "</td></tr>";
    }
}
echo "</table>";
?>


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
