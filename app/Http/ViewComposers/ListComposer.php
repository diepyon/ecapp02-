<?php
//お気に入り、カート、購入履歴の情報をまとめて複数のviewに渡すためのcomposer
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Cart; 
use App\Models\Favorite;
use App\Models\Orderhistory;


class ListComposer
{
    /**
     * @var String
     */
    protected $Cart;

    public function __construct(Favorite $favorite, Cart $cart,Orderhistory $orderhistory)
    {
        //$this->data = $cart->showCart();//CartモデルにおけるshowCartメソッドの実行結果を格納
        $this->favorite_data = $favorite->showFavorite();//お気に入り登録中の商品情報取得
        $this->cart_data = $cart->showCart();//カートに入っている商品の情報を取得
        $this->orderhistory_data  = $orderhistory->showOrderHistory();//購入履歴の商品情報を取得
    }

    /**
     * Bind data to the view.
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {   
        $view->with('favorite_data', $this->favorite_data)->with('cart_data', $this->cart_data)->with('orderhistory_data', $this->orderhistory_data);
    }
}
