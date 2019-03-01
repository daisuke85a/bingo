
document.getElementById('add_user').onclick = function(){
  event.preventDefault(); //submitが実行されると、画面が必ず更新されるというブラウザの仕様をキャンセルする
  console.log("add_user");

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
    if (xhr.readyState === 4) { //通信が完了した時
      if(xhr.status === 200) { //通信が成功した時
        console.log(xhr.responseText);

        //ユーザーを追加
        var user = document.createElement('li');
        var text = document.createTextNode(xhr.responseText);
        user.appendChild(text);
        document.getElementById('user-list').appendChild(user);

      } else{ //通信が失敗した時

      }
    }
  };

  var user = document.getElementById('user');
  var num1 = document.getElementById('num1');
  var num2 = document.getElementById('num2');
  var num3 = document.getElementById('num3');
  var num4 = document.getElementById('num4');
  var num5 = document.getElementById('num5');
  console.log(user.value);
  console.log(num1.value);
  console.log(num2.value);
  console.log(num3.value);
  console.log(num4.value);
  console.log(num5.value);

  var str = '_ajax.php?kind=add_user&user=' + user.value +'&num1=' + num1.value + '&num2=' + num2.value 
  + '&num3=' + num3.value +'&num4=' + num4.value + '&num5=' + num5.value;

  console.log(str);

  xhr.open('GET', str , true);
  xhr.send(null);


  return false;
}