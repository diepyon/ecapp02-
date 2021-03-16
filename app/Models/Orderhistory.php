<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use DB;

use Illuminate\Database\Eloquent\Model;

class Orderhistory extends Model
{
    protected $guarded = [
        'id'
       ];
       public function showOrderHistory()
       {
           $user_id = Auth::id(); //ログインしているユーザーのIDを取得
           $data['items'] = $this->where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(2);
           //ログインユーザーのIDと同じ値を持つuser_idカラムのレコードを連想配列$dataのキー「items」に格納
            //尚且つ並べ替え
           $data['count']=0; //カート内の商品の個数は０からカウントアップするぜ
           $data['sum']=0; //合計金額も０からカウントアップするぜ
     
           foreach ($data['items'] as $item) {
           
               $data['count']++;//繰り返しごとにカウントは１ずつアップ
               $data['sum'] += $item->stock->fee;
               //cartsテーブルにおいて、ログインしているユーザーのIDとuser_idカラムが同じであるレコードの情報
               //そのレコードのstock_idを参照して、stocksテーブルの「id」が一致するレコードのfeeカラムの情報を取得
               //繰り返すたびにsumに数字が足されていく
           }

           //ここに購入履歴のループを書くと思う

           //$data['ordered_list'][] ='dammy';
           return $data; //連想配列データを実行結果として返す
       }
       public function stock()
       {
           return $this->belongsTo('\App\Models\Stock');//orderhistoriesテーブル内に書かれたメソッドにもかかわらずストックテーブルの中身も参照できるようにするメソッド
       }
}

