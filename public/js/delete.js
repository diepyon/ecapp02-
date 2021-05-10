let message = document.getElementById('deleteMessage').textContent //ブレードよりID[message]の中身のテキストを取得
alert(message);//取得した「削除しました」などのメッセージをアラートで表示

//１つ上の階層にリダイレクト
let url = '../';
location.href=url