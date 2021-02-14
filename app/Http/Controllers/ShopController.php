<?php

namespace App\Http\Controllers;

use App\Models\Stock; //追加
use App\Models\Cart; //追加
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index() //追加
    {
        return view('top');
    }
    public function images() //追加
    {
        $stocks = Stock::where('genre', 'image')->get();//genreがimageのレコード（あわせてページネーションするには？）
        return view('images', compact('stocks'));
    }
    public function myCart(Cart $cart)
    {
        $items = $cart->showCart();//cartモデルのshowCartメソッドを格納
        return view('mycart', compact('items'));
    }
    public function addMycart(Request $request, Cart $cart)
    {

       //カートに追加の処理
        $stock_id=$request->stock_id;
        $message = $cart->addCart($stock_id);

        //追加後の情報を取得
        $items = $cart->showCart();
        return view('mycart', compact('items', 'message'));
    }
}
