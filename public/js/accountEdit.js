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