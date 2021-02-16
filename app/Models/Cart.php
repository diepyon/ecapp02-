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
        $data['items'] = $this->where('user_id', $user_id)->get();//ログインユーザーのIDと同じ値を持つuser_idカラムのレコードを連想配列$dataのキー「my_carts」に格納

        $data['count']=0; //カート内の商品の個数は０からカウントアップするぜ
        $data['sum']=0; //合計金額も０からカウントアップするぜ
  
        foreach ($data['items'] as $item) {
            $data['count']++;//繰り返しごとにカウントは１ずつアップ
            $data['sum'] += $item->stock->fee;
            //cartsテーブルにおいて、ログインしているユーザーのIDとuser_idカラムが同じであるレコードの情報
            //そのレコードのstock_idを参照して、stocksテーブルの「id」が一致するレコードのfeeカラムの情報を取得
            //？？？belongtoを使っているからstocksテーブルを参照できるのはわかるが、「stock_id」カラムはどこにも指定してない。なぜ？？？
        
            //繰り返すたびにsumに数字が足されていくπ
        }
        return $data; //連想配列データを実行結果として返す
    }
    public function stock()
    {
        return $this->belongsTo('\App\Models\Stock');//Cartテーブル内に書かれたメソッドにもかかわらずストックテーブルの中身も参照できるようにするメソッド
    }
    public function addCart($stock_id)
    {
        $user_id = Auth::id(); //ログインユーザーのIDを取得
        $cart_add_info = Cart::firstOrCreate(['stock_id' => $stock_id,'user_id' => $user_id]);//ユーザーIDとストックIDの組み合わせが完全に一致するレコードが既にないか確認

       if ($cart_add_info->wasRecentlyCreated) {//Cart::firstOrCreateを格納した変数に対して直近で保存された場合はtrueを保存されていない場合はfalseを返してくれます。
           $message = 'カートに追加しました';
       } else {
           $message = 'カートに登録済みです';
       }

        return $message;
    }
    public function deleteCart($stock_id)
    {
        $user_id = Auth::id(); //ログインユーザーのIDを取得
        $delete = $this->where('user_id', $user_id)->where('stock_id', $stock_id)->delete();
        //user_idがログインユーザーと一致し、尚且つformからpostされてきた$stock_idとstock_idカラムの内容が一致するレコードを削除

        if ($delete > 0) {
            $message = 'カートから削除しました。';
        } else {
            $message = '削除できませんでした。';
        }
        return $message;
    }
    public function checkoutCart()
    {
        $user_id = Auth::id(); //ログインユーザーのIDを取得
        $checkout_items=$this->where('user_id', $user_id)->get();//決済時のカートの中身（つもり購入したもの）を取得
        $this->where('user_id', $user_id)->delete();//そしてカートにあった情報を削除
        //user_idがログインユーザーと一致し、尚且つformからpostされてきた$stock_idとstock_idカラムの内容が一致するレコードを削除
        return $checkout_items;
    }
}