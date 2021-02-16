<?php

namespace App\Http\Controllers;

use App\Models\Stock; //追加
use App\Models\Cart; //追加
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use DB;
use Illuminate\Support\Facades\Mail; //メール
use App\Mail\Thanks;//メール

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index() //追加
    {
        return view('top');
    }
    public function images() //追加
    {
        $stocks = DB::table('stocks')->where('genre', 'image')->Paginate(6);

        return view('images', compact('stocks'));
    }
    public function singleProduct()
    {//商品個別ページを表示するメソッド
        $stocks = DB::table('stocks')->where('id', 1)->get();//どうやって個別ページを作るかが不明
        dd($stocks);
        return view('singleproduct', compact('stocks'));
    }

    public function myCart(Cart $cart)
    {
        $data = $cart->showCart();//showCartメソッドの実行結果を格納
        return view('mycart', $data);//compactは変数を配列にするメソッドなので、使わない。今回は$dataが既に配列型式
    }
    public function addMycart(Request $request, Cart $cart)
    {
        //カートに追加の処理
        $stock_id=$request->stock_id;
        $message = $cart->addCart($stock_id);

        //追加後の情報を取得
        $data = $cart->showCart();
        return view('mycart', $data)->with('message', $message);
        //配列$dataをビューファイル->メソッド実行結果を格納した$messageも渡す（$data['message']=$message;と同じ意味）
    }
    
    public function deleteCart(Request $request, Cart $cart)
    {
        $stock_id=$request->stock_id;
        $message = $cart->deleteCart($stock_id);//Cartモデルのshowcartメソッドの実行結果を格納（stock_idもCartモデルに連れて行ってね）

        $data = $cart->showCart($stock_id);
        return view('mycart', $data)->with('message', $message);
        //配列$dataをビューファイル->メソッド実行結果を格納した$messageも渡す（$data['message']=$message;と同じ意味）
    }
    public function checkout(Cart $cart)
    {
        $checkout_info = $cart->checkoutCart();
        Mail::to('test@example.com')->send(new Thanks); //メール送信処理
        return view('checkout');
    }
}
