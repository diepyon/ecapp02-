/*---
itemloop
---*/
    //マウスオンでメッセージを表示
    for (let step = 1; step <= 6; step++) {

        document.addEventListener('DOMContentLoaded', function () {
            let favorite_trigger = document.getElementById('favorite_trigger' + step)
            let favorite_expert = document.getElementById('favorite_expert' + step)

            //マウスポインターが乗ったタイミングで背景色を変更
            favorite_trigger.addEventListener('mouseover', function () {
                favorite_expert.style.opacity = '1.0'
            }, false)

            //マウスポインターが外れたタイミングで背景色を戻す
            favorite_trigger.addEventListener('mouseout', function () {
                favorite_expert.style.opacity = '0'
            }, false)

            let cart_trigger = document.getElementById('cart_trigger' + step)
            let cart_expert = document.getElementById('cart_expert' + step)

            //マウスポインターが乗ったタイミングで背景色を変更
            cart_trigger.addEventListener('mouseover', function () {
                cart_expert.style.opacity = '1.0'
            }, false)

            //マウスポインターが外れたタイミングで背景色を戻す
            cart_trigger.addEventListener('mouseout', function () {
                cart_expert.style.opacity = '0'
            }, false)
        }, false)
    }

/*---
mypage
---*/
/*プロフィールアイコンファイル選択時にプレビュー*/
function imgPreView(event) {
    var file = event.target.files[0];//1個目のfile
    var reader = new FileReader();//新しいファイルリーダー
    var preview = document.getElementById("preview");//
    var previewImage = document.getElementById("previewImage");
     
    if(previewImage != null) {
      preview.removeChild(previewImage);
    }
    reader.onload = function(event) {
      var img = document.createElement("img");
      img.setAttribute("src", reader.result);
      img.setAttribute("id", "previewImage");
      preview.appendChild(img);
    };
 
    if(file.type.match('image')){//画像が選ばれたら
        reader.readAsDataURL(file);//画像をプレビュー
    }else{//画像以外が選ばれたら
        let mimeError = '<div class=""><span id="invalid_message" class="invalid_message"><strong>選択できない形式のデータです。</strong></span></div>'
        document.getElementById('mimemessage').innerHTML = `${mimeError}`;//エラーメッセージを生成
    }
  }

 /*作品ファイル選択時にプレビュー*/
function stockPreView(event) {
    var file = event.target.files[0];//1個目のfile
    var reader = new FileReader();//新しいファイルリーダー
    var preview = document.getElementById("stockPreview");//
    var previewImage = document.getElementById("previewImage");
     
    if(previewImage != null) {
      preview.removeChild(previewImage);
    }

    if(file.type.match('image')){
    reader.onload = function(event) {
      var img = document.createElement("img");
      img.setAttribute("src", reader.result);
      img.setAttribute("id", "previewImage");
      preview.appendChild(img);
    }
    }else if(file.type.match('video')){
        var img = document.createElement("video");
        img.setAttribute("src", reader.result);
        img.setAttribute("id", "previewImage");
        }
 
  
    if(file.type.match('image')){//画像が選ばれたら
        reader.readAsDataURL(file);//画像をプレビュー
        document.getElementById('genreSelect').innerHTML = '<option value="image">画像</option>'
    }else if(file.type.match('video')){
        alert('動画やん！')
        reader.readAsDataURL(file);//画像をプレビュー
        document.getElementById('genreSelect').innerHTML = '<option value="movie">動画</option>'
    }else if(file.type.match('audio')){
        alert('オーディオやん')
        document.getElementById('genreSelect').innerHTML = '<option value="bgm">BGM</option>'
    }else{//画像以外が選ばれたら
        let mimeError = '<div class=""><span id="invalid_message" class="invalid_message"><strong>選択できない形式のデータです。</strong></span></div>'
        document.getElementById('mimemessage').innerHTML = `${mimeError}`;//エラーメッセージを生成
    }
  }


/*ファイル選択キャンセル*/
   function clear_file(){
    var area = document.getElementById('file_input_area'); 
    var temp = area.innerHTML;  
       area.innerHTML = temp;//span#file_input_are内を空にする

    var  invalidMessage = document.getElementById('mimemessage');
    invalidMessage.innerHTML =''//プロフィールアイコンに画像以外が選択されていた場合に表示されるエラーメッセージを削除
   
    if(document.getElementById('genreSelect')){
    var  genreSelect = document.getElementById('genreSelect');
    genreSelect.innerHTML =''//ファイル選択時に自動判別される製品ジャンルをクリア
    }
    var imageArea = document.getElementById('previewImage');
    imageArea.remove();//プレビュー画像削除
  }
  
