<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ

class Cart extends Model
{
    protected $guarded = [
     'id'
   ];
    public function showCart()//追加
    {
        $user_id = Auth::id(); //ログインしているユーザーのIDを取得
        return $this->where('user_id', $user_id)->get();
    } 
       public function stock()
   {
       return $this->belongsTo('\App\Models\Stock');//Cartテーブル内に書かれたメソッドにもかかわらずストックテーブルの中身も参照できるようにするメソッド
   }
       public function addCart($stock_id)
   {
       $user_id = Auth::id(); //ログインユーザーのIDを取得
       $cart_add_info = Cart::firstOrCreate(['stock_id' => $stock_id,'user_id' => $user_id]);//ユーザーIDとストックIDの組み合わせが完全に一致するレコードが既にないか確認

       if($cart_add_info->wasRecentlyCreated){//Cart::firstOrCreateを格納した変数に対して直近で保存された場合はtrueを保存されていない場合はfalseを返してくれます。
           $message = 'カートに追加しました';
       }
       else{
           $message = 'カートに登録済みです';
       }

       return $message;
   }
}

