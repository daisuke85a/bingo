<?php
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/Bingo.php');

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

<!DOCTYPE html>
<html>
<head>
	<!-- title -->
	<title>bingo</title>
	
	<!-- favicon -->
	<link rel="shortcut icon" href="fabicon.ico" >
	
	<!-- font -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	
	<!-- bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
	<!-- css -->
	<link rel="stylesheet" type="text/css" href="base.css">
	
	<!-- typekit-->
	<script src="https://use.typekit.net/fbr3jfe.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
</head>
<body id="top">
<!-- START / header ========== -->
<header>
	<h1><img src="img/logo.png" alt="みんニャでかんたんBINGO"></h1>	
</header>
<!-- END / header ========== -->
<!-- START /  ========== -->
<div class="container">
	<section class="instoduce">
		<div class="row">
			<div class="col-sm-12">
				<ul>
					<li><img src="img/cat01.png" alt=""></li>
					<li>まずは下のフォームに<strong>お名前</strong>と<strong>お好きな番号（0〜30）</strong>を入力＆登録してお待ちくださいニャ</li>
				</ul>
			</div>
		</div>
	</section>
</div>
<!-- END /  ========== -->
<!-- START /  ========== -->
<div class="container">
	<section class="form">
		<div class="row">
			<div class="col-sm-12">
				<form action="start.php" method="get">
				<ul>
					<li>
						<span>お名前</span>
						<input type="text" name=user placeholder="お名前を入れてニャ">
					</li>
					<li>
						<span>番号1</span>
						<select name="num1">
							<option value="">未設定</option>
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
						<span>番号2</span>
						<select name="num2">
							<option value="">未設定</option>
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
						<span>番号3</span>
						<select name="num3">
							<option value="">未設定</option>
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
						<span>番号4</span>
						<select name="num4">
							<option value="">未設定</option>
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
						<span>番号5</span>
						<select name="num5">
							<option value="">未設定</option>
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
					<li><input type="submit" value="登録"></li>
				</ul>
				</form>
			</div>
		</div>
	</section>
</div>
<!-- END /  ========== -->
<!-- START /  ========== -->
<div class="container">
	<h2>登録済みメンバー</h2>
	<section class="member">
		<div class="row">
			<div class="col-sm-12">
				<ul>
                    <?php 

                    foreach($usesr as $user){
                        echo '<li>' . $user["name"] . '</li>';
                    }

                    ?>
				</ul>
			</div>
		</div>	
	</section>
</div>
<!-- END /  ========== -->
<a href="game/game.html"><input class="btn-base btn-blue" type="submit" value="はじめる"></a>

<footer>
	<p>team bingo</p>
</footer>
</body>	
<!-- jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- bootstrap -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- default -->
<script type="text/javascript">
  $('.bs-component [data-toggle="popover"]').popover();
  $('.bs-component [data-toggle="tooltip"]').tooltip();
</script>

<!-- pagetop -->
<script type="text/javascript">
　 $(function() {
    var showFlag = false;
    var topBtn = $('#page-top');    
    topBtn.css('bottom', '-100px');
    var showFlag = false;
    //スクロールが100に達したらボタン表示
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            if (showFlag == false) {
                showFlag = true;
                topBtn.stop().animate({'bottom' : '0px'}, 200); 
            }
        } else {
            if (showFlag) {
                showFlag = false;
                topBtn.stop().animate({'bottom' : '-100px'}, 200); 
            }
        }
    });
    //スクロールしてトップ
    topBtn.click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
});
</script>
	
<!-- matchheight -->
<script src="js/jquery.matchHeight-min.js"></script>
<script type="text/javascript">
$(function() {
    $('.point').matchHeight();
});
</script>

<!-- animation -->
<script type="text/javascript">
$('.animation').css('visibility','hidden');
$(window).scroll(function(){
 var windowHeight = $(window).height(),
     topWindow = $(window).scrollTop();
 $('.animation').each(function(){
  var targetPosition = $(this).offset().top;
  if(topWindow > targetPosition - windowHeight + 100){
   $(this).addClass("fadeInDown");
  }
 });
});
</script>
		
<!-- smooth scroll -->
<script>
	$('a[href^="#"]').click(function() {
	  // スクロールの速度
	  var speed = 400; // ミリ秒で記述
	  var href = $(this).attr("href");
	  var target = $(href == "#" || href == "" ? 'html' : href);
	  var position = target.offset().top;
	  $('body,html').animate({
		scrollTop: position
	  }, speed, 'swing');
	  return false;
	});
</script>

</html>


<!DOCTYPE_html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>bingo</title>
<body>


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
