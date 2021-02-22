<?php

namespace App\Http\Controllers;

use App\Models\Stock; //追加
use App\Models\Cart; //追加
use App\Models\Favorite; //追加
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
    public function images() //stocksテーブルのgenreカラムの値がimageのレコードを取得する
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
    public function checkout(Request $request, Cart $cart)
    {
       $user = Auth::user();//ログインユーザーの情報を取得
       $mail_data['user']=$user->name; //ログインユーザーのnameカラムの情報を取得
       $mail_data['checkout_items']=$cart->checkoutCart(); //checkoutCartメソッドの実行結果を連想配列$mail_dataのキーcheckout_itemsに格納
       Mail::to($user->email)->send(new Thanks($mail_data));//ログインユーザーのemailカラムの情報（メールアドレス）を取得して、そのメールアドレスに情報を送る

        return view('checkout');
    }
    public function myFavorite(Favorite $favorite)
    {
        $data = $favorite->showFavorite();//showCartメソッドの実行結果を格納
        return view('favorite', $data);
    }
    public function addMyfavorite(Request $request, Favorite $favorite)
    {
        //お気に入りに追加
        $stock_id=$request->stock_id;
        $message = $favorite->addFavorite($stock_id);

        //追加後の情報を取得
        $data = $favorite->showFavorite();
        return view('favorite', $data)->with('message', $message);
        //配列$dataをビューファイル->メソッド実行結果を格納した$messageも渡す（$data['message']=$message;と同じ意味）
    }    
    public function deleteFavorite(Request $request, Favorite $favorite)
    {
        $stock_id=$request->stock_id;
        $message = $favorite->deleteFavorite($stock_id);//FavoriteモデルのshowFavboriteメソッドの実行結果を格納（stock_idもFavoriteモデルに連れて行ってね）

        $data = $favorite->showFavorite($stock_id);
        return view('favorite', $data)->with('message', $message);
        //配列$dataをビューファイル->メソッド実行結果を格納した$messageも渡す（$data['message']=$message;と同じ意味）
    }  
    public function favoriteButton($favorite){/*お気に入り登録されているかどうかでハートボンタンの表示を変更*/
        $user = Auth::user();//ログインユーザーの情報を取得
        

        //$message = $favorite->deleteFavorite($stock_id);
        //$data=$favorite->showFavorite($stock_id);
    }
}
