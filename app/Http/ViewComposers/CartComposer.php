<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Cart; //cartテーブルの情報を取得するから多分これがいる


class CartComposer
{
    /**
     * @var String
     */
    protected $Cart;

    public function __construct(Cart $cart)
    {
        $this->data = $cart->showCart();//CartモデルにおけるshowCartメソッドの実行結果を格納
    }

    /**
     * Bind data to the view.
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {   

        $view->with('count', $this->data['count']);
    }
}
