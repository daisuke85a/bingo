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
    echo "ユーザーreset!!!";
    echo "番号reset!!!";

    $bingoApp->resetUser();
    $bingoApp->resetNum();
}

//ユーザー登録ボタンが押された
if (isset($_GET['user'])) {
    echo "add user";
    $bingoApp->addUser($_GET['user'], $_GET['num1'], $_GET['num2'], $_GET['num3'], $_GET['num4'], $_GET['num5']);
}

$numbers = $bingoApp->getAll();
$users = $bingoApp->getAllUsers();

if (isset($_GET['comment'])) {
    $bingo = $bingoApp->slot(0, 30);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
  <body class="body game">
    <main class="main" id="main">
      <h1 class="headline"><img src="./game/logo.814d17e3.png" alt="みんニャでかんたんBINGO"></h1>
      <section class="history">

	  <form action="game.php" method="get">
    <p>
	 <input type=“text” name =comment style="display:none" value="start">
	 <!-- TODO:beforeとafterのマークがつかない。 -->
     <input type="submit" class="buttonPrimary" id="go_slot" value="スロットを回す">
    </p>
  </form>
        <!-- <button class="buttonPrimary">スロットまわす</button> -->
        <div class="history__newone">
		  <p><span>\NEW/</span><span  id = "newnum">
		  <?php if (isset($bingo)) {
  			  echo $bingo;
			}
		  ?>
		  </span></p>
        </div>
        <ul class="history__list" id="history__list">
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

	echo '<h3>' . $user["name"] . '</h3>';

	//var_dump($number);
    echo '<ul><li>' . $user["num1"] . '</li><li>' . $user["num2"] . '</li><li>' . $user["num3"] . '</li><li>' . $user["num4"] . '</li><li>' . $user["num5"] . "</ul>";
	echo '</div>';
}
?>

      </section>
    </main>
    <footer class="footer">
    <form action="game.php" method="get">
    <p>
     <input type=“text” name =reset style="display:none" value="reset">
     <!-- TODO:やめるボタンに猫脚と＞のマークが消えてしまった。多分buttonからinputに変更したのが原因 -->
     <input type="submit" class="buttonPrimary" value="やめる">
    </p>
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

    console.log("voice_bingo");
      
      $.ajax({
        url: "./_ajax.php", 
        type: "GET",
        data: {
          kind: "voice_bingo"
        }
      })
        // Ajaxリクエストが成功した時発動
        .done(data => {
          console.log("ajax done");
          console.log(data);
          
        })
        // Ajaxリクエストが失敗した時発動
        .fail(data => {
          console.log("ajax fail");
        })
        // Ajaxリクエストが成功・失敗どちらでも発動
        .always(data => {
  
        });


    // if(text == "bingo"){
    //   console.log("bingo!");
    //   execPost("game.php",  {'bingo':text});
    // }else{
    //   console.log("not bingo!");
    //   execPost("game.php",  {'bingo':text});
    // }
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
<script src="ajax.js"></script>
</body>
</html>
