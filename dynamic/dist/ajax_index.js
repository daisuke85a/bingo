
document.getElementById('add_user').onclick = function(){
  event.preventDefault(); //submitが実行されると、画面が必ず更新されるというブラウザの仕様をキャンセルする
  console.log("add_user");

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
    if (xhr.readyState === 4) { //通信が完了した時
      if(xhr.status === 200) { //通信が成功した時
        console.log(xhr.responseText);
      } else{ //通信が失敗した時

      }
    }
  };

  xhr.open('GET', '_ajax.php?kind=add_user' ,true);
  xhr.send(null);


  return false;
}