<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use DB;



class Orderhistory extends Model
{
    protected $guarded = [
        'id'
       ];
       public function showOrderHistory()
       {
           $user_id = Auth::id(); //ログインしているユーザーのIDを取得
           $data['loops'] = $this->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
           //ログインユーザーのIDと同じ値を持つuser_idカラムのレコードを連想配列$dataのキー「items」に格納

           $data['items'] = $this->where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(30);
    
           foreach ($data['loops'] as $loop) {
                $data['orderhistory_list'][] = $loop->stock->id;
           }
           $data['orderhistory_list'][] ='dammy'; 

           ;

           return $data; //連想配列データを実行結果として返す
       }
       
       public function stock()
       {
           return $this->belongsTo('\App\Models\Stock');//orderhistoriesテーブル内に書かれたメソッドにもかかわらずストックテーブルの中身も参照できるようにするメソッド
       }
}

