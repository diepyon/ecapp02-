/*作品ファイル選択時にプレビュー*/
function stockPreView(event) {
    var file = event.target.files[0]; //1個目のfile
    var reader = new FileReader(); //新しいファイルリーダー（ファイルタグにファイルがセットされているかの判定？）
    var preview = document.getElementById("stockPreview"); //stockPreviewというIDを持つ要素を取得
    var previewFile = document.getElementById("previewFile"); //previewFileというIDを持つ要素を取得

    if (previewFile != null) {
        preview.removeChild(previewFile);
    }

    if (file.type.match('image')) { //選択されたファイルが画像なら
        reader.onload = function (event) {
            var img = document.createElement("img"); //imgタグを生成
            img.setAttribute("src", reader.result); //生成するimgタグのsrcにはURLを格納します。
            img.setAttribute("id", "previewFile"); //生成するimgタグのidにはpreviewFileを格納します。
            preview.appendChild(img); //id「stockPreview」をもつエレメントの中にimgタグを追加
            document.getElementById('genreSelect').innerHTML = '<option value="image">画像</option>' //ジャンルのセレクトボックスを画像に変更
        }
        reader.readAsDataURL(file); //画像をプレビュー
    } else if (file.type.match('video')) { //選択されたファイルが動画なら
        // Blob URLの作成
        var blobUrl = window.URL.createObjectURL(file);

        // HTMLに書き出し (src属性にblob URLを指定)
        document.getElementById("stockPreview").innerHTML = '<video  id="previewFile" src="' + blobUrl + '" controls></video>';
        document.getElementById('genreSelect').innerHTML = '<option value="movie">動画</option>' //ジャンルのセレクトボックスを画像に変更

    } else if (file.type.match('audio')) {
        document.getElementById('genreSelect').innerHTML = '<option value="audio">オーディオ</option>'

    } else { //想定されないファイルが選ばれたら
        let mimeError = '<div class=""><span id="invalid_message" class="invalid_message"><strong>選択できない形式のデータです。</strong></span></div>'
        document.getElementById('mimemessage').innerHTML = `${mimeError}`; //エラーメッセージを生成
    }
}

    /*ファイル選択キャンセル*/
    function clear_file() {
        var area = document.getElementById('file_input_area');
        var temp = area.innerHTML;
        area.innerHTML = temp; //span#file_input_are内を空にする

        var invalidMessage = document.getElementById('mimemessage');
        invalidMessage.innerHTML = '' //プロフィールアイコンに画像以外が選択されていた場合に表示されるエラーメッセージを削除

        if (document.getElementById('genreSelect')) {
            var genreSelect = document.getElementById('genreSelect');
            genreSelect.innerHTML = '' //ファイル選択時に自動判別される製品ジャンルをクリア
        }
        var imageArea = document.getElementById('previewFile');
        if(imageArea){imageArea.remove()} //プレビュー画像削除
    }
