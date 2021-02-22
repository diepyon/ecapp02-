<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ

class Favorite extends Model
{
    protected $guarded = [
     'id'
   ];
    public function showFavorite()//追加
    {
        $user_id = Auth::id(); //ログインしているユーザーのIDを取得
        $data['items'] = $this->where('user_id', $user_id)->get();//ログインユーザーのIDと同じ値を持つuser_idカラムのレコードを連想配列$dataのキー「my_favorites」に格納

        $data['count']=0; //お気に入り内の商品の個数は０からカウントアップするぜ
        $data['sum']=0; //合計金額も０からカウントアップするぜ
  
        foreach ($data['items'] as $item) {
            $data['count']++;//繰り返しごとにカウントは１ずつアップ
            $data['sum'] += $item->stock->fee;
            //favoritesテーブルにおいて、ログインしているユーザーのIDとuser_idカラムが同じであるレコードの情報
            //そのレコードのstock_idを参照して、stocksテーブルの「id」が一致するレコードのfeeカラムの情報を取得
            //？？？belongtoを使っているからstocksテーブルを参照できるのはわかるが、「stock_id」カラムはどこにも指定してない。なぜ？？？
        
            //繰り返すたびにsumに数字が足されていくπ
        }
        return $data; //連想配列データを実行結果として返す
    }
        public function stock()
    {
        return $this->belongsTo('\App\Models\Stock');//Favoriteテーブル内に書かれたメソッドにもかかわらずストックテーブルの中身も参照できるようにするメソッド
    }
    public function addFavorite($stock_id)
    {
        $user_id = Auth::id(); //ログインユーザーのIDを取得
        $favorite_add_info = Favorite::firstOrCreate(['stock_id' => $stock_id,'user_id' => $user_id]);//ユーザーIDとストックIDの組み合わせが完全に一致するレコードが既にないか確認

       if ($favorite_add_info->wasRecentlyCreated) {//Favorite::firstOrCreateを格納した変数に対して直近で保存された場合はtrueを保存されていない場合はfalseを返してくれます。
           $message = 'お気に入りに追加しました';
       } else {
           $message = 'お気に入りに登録済みです';
       }

        return $message;
    }
        public function deleteFavorite($stock_id)
    {
        $user_id = Auth::id(); //ログインユーザーのIDを取得

        $delete = $this->where('user_id', $user_id)->where('stock_id', $stock_id)->delete();
        //user_idがログインユーザーと一致し、尚且つformからpostされてきた$stock_idとstock_idカラムの内容が一致するレコードを削除
        if ($delete > 0) {
            $message = 'お気に入りから削除しました。';
        } else {
            $message = '削除できませんでした。';
        }
        return $message;
    }
}
