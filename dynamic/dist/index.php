<?php
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/Bingo.php');

//var_dump($_POST);
//var_dump($_GET);

$bingoApp = new \MyApp\Bingo();

$bingoApp->getMaxRank();

if(isset($_COOKIE['name'])){
  echo "<p>私の名前は". $_COOKIE['name'] . "です</p>";
}else{
  echo"<p>ビンゴカードが未登録です</p>";
}

//音声入力された。
if(isset($_GET['bingo'])){
  echo "<p>音声入力された文字は「" . $_GET['bingo'] . "」です</p>";

  //ビンゴと言われたかチェックする
  if( $_GET['bingo'] === "bingo" ){
    //ビンゴしたかチェックする
    $bingoApp->checkBingo($_COOKIE['name']);
  }
}

//リセットボタンが押された
if(isset($_GET['reset'])){
  echo "番号reset!!!";
  $bingoApp->resetNum();
}

if(isset($_GET['resetuser'])){
  echo "ユーザーreset!!!";
  $bingoApp->resetUser();

}

//ユーザー登録ボタンが押された
if(isset($_GET['user'])){
  echo "add user";
  $bingoApp->addUser($_GET['user'],$_GET['num1'],$_GET['num2'],$_GET['num3'],$_GET['num4'],$_GET['num5']);
}

$numbers = $bingoApp->getAll();
$users = $bingoApp->getAllUsers();
//var_dump($users);
//var_dump($numbers);

if(isset($_GET['comment'])){
  if (count($numbers) !== 30 ){  
    do{
      $bingo = rand(0,30);
      $first = true;
      foreach($numbers as $number){
        //var_dump($number);
        if(intval($number["number"]) === $bingo){
          $first = false; //既出
          break;
        }
      }
    }while($first === false); //既出の限り続く

    $bingoApp->insertNum($bingo);
  }else{
    echo "番号が全て出たのでビンゴを回せません！";
  }
}


?>
  
<!DOCTYPE_html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>bingo</title>
<body>

  <button id="btn">Bingoしたらこのボタンを押して「Bingo」と言う</button>
  <div id="content"></div>

    <?php if(isset($bingo)) 
      echo "<h2>いま出た数字</h2><p>" . $bingo . "</p>";
    ?>
 
  <h2>今までに出た数字</h2>
  <?php 
    foreach($numbers as $number){
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
      foreach($users as $user){
        //var_dump($number);
        echo "<tr><td>" . $user["name"] . "</td><td>" . $user["num1"] . "</td><td>". $user["num2"] . "</td><td>". $user["num3"] ."</td><td>". $user["num4"] ."</td><td>". $user["num5"] ."</td>";
        
        $rank = $bingoApp->getRank($user["name"]);
        if($rank === 0){
          echo "<td></td></tr>";
        }
        else{
          echo "<td>" . $rank . "</td></tr>";
        }
      }
    echo "</table>";
  ?>

  <h3>ビンゴカードの登録</h3>
  <form action="index.php" method="get">
    <p><label>名前
    <input type="text" name=user placeholder="名前"></p>

    <p><label>番号1</label>
    <input type="number" name=num1 placeholder="番号1" min="0" max="30"></p>
    <p><label>番号2</label>
    <input type="number" name=num2 placeholder="番号2" min="0" max="30"></p>
    
    <p><label>番号3</label>
    <input type="number" name=num3 placeholder="番号3" min="0" max="30"></p>
    
    <p><label>番号4</label>
    <input type="number" name=num4 placeholder="番号4" min="0" max="30"></p>
    
    <p><label>番号5</label>
    <input type="number" name=num5 placeholder="番号5" min="0" max="30"></p>
    
    <p><input type="submit" value="登録"></p>
    
  </form> 


  <h3>ビンゴカードのリセット</h3>

    <form action="index.php" method="get">
    <p>
     <input type=“text” name =resetuser style="display:none" value="reset">
     <input type="submit" value="全ビンゴカードをリセットする">
    </p>
  </form> 

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
      execPost("index.php",  {'bingo':text});
    }else{
      console.log("not bingo!");
      execPost("index.php",  {'bingo':text});
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
