$(function() {
    console.log("hello");
    $("#go_slot").on("click", function(e) {
      event.preventDefault(); //submitが実行されると、画面が必ず更新されるというブラウザの仕様をキャンセルする
      console.log("go_slot");
      
      $.ajax({
        url: "./_ajax.php", 
        type: "GET",
        data: {
          kind: "goslot"
        }
      })
        // Ajaxリクエストが成功した時発動
        .done(data => {
          console.log("ajax done");
          console.log(data);
  
          $("#newnum").html(data);
          $("#history__list").prepend("<li>" + data + "</li>");
          
        })
        // Ajaxリクエストが失敗した時発動
        .fail(data => {
          console.log("ajax fail");
        })
        // Ajaxリクエストが成功・失敗どちらでも発動
        .always(data => {
  
        });
  
      //画面のリフレッシュを防ぐためにreturn falseする
      return false;
    });
  });
  