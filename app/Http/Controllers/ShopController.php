<?php

namespace App\Http\Controllers;

use App\Models\Stock; //追加
use App\Models\Cart; //追加
use App\Models\Favorite; //追加
use App\Models\Orderhistory; //追加
use App\Models\User; //登録されているユーザー情報を引っ張りたくて追加した
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use DB;
use Illuminate\Support\Facades\Mail; //メール
use App\Mail\Thanks;//メール
use Intervention\Image\Facades\Image;//画像加工のライブラリ
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index() //追加
    {
        return view('top');
    }
    public function images() //stocksテーブルのgenreカラムの値がimageのレコードを取得する
    {
        $stocks = DB::table('stocks')->where('genre', 'image')->where('status', 'publish')->Paginate(4);//genreがimageのデータをページネーションで取得
        return view('images', compact('stocks'));
    }

    public function searchItems(Request $request)
    {
        #キーワード受け取り
        $key = $request->input('key');//inputタグに入力されたキーワードを取得
        $genre = $request->genre;//selectタグからジャンルのvalueを取得

        #クエリ生成(Stockテーブルを参照)
        $query = Stock::query();
        $query->where('name', 'like', '%'.$key.'%')
                  ->Where('genre', 'like', $genre)
                  ->where('status', 'publish');
  
        #ページネーション
        $stocks = $query->orderBy('created_at', 'desc')->paginate(2);
       
        return view('search', compact('stocks'))->with('genre', $genre)->with('key', $key);
        //->with('genre', $genre)も渡さないとフォームの入力内容をページ移管後に維持できない
    }

    
    public function singleProduct(Stock $stock,$stocks_id)//コントローラーから{{stock_id}}を取得
    {//商品個別ページを表示するメソッド
        $stock_record = DB::table('stocks')->where('id', $stocks_id)->first();//商品の情報を取得
        $author_id = ($stock_record->user_id);//商品投稿者のidを取得
        $user = DB::table('users')->where('id', $author_id)->first();//商品投稿者の情報を取得
        $file = './storage/stock_sample/'.$stock_record->path;//販売データのファイルパスを取得

        //genreが画像ならのif文が欲しい
        $imgSize = getimagesize($file);//販売画像データ情報を取得
        $width = $imgSize[0];//販売画像データの横幅を取得
        $height= $imgSize[1];//販売画像データの高さを取得
        $mime =$imgSize['mime']; 
        $filesize =  $stock->calcFileSize(filesize('./storage/stock_sample/'.$stock_record->path));
        $aspect=$stock->aspect($width, $height);  
        return view('singleproduct', compact('stock_record', 'user','width','height','mime','filesize','aspect'));
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
        return redirect()->back()->with('message', $message);
        //配列$dataをビューファイル->メソッド実行結果を格納した$messageも渡す（$data['message']=$message;と同じ意味）
    }
    
    public function deleteCart(Request $request, Cart $cart)
    {
        $stock_id=$request->stock_id;  
        $message = $cart->deleteCart($stock_id);//Cartモデルのshowcartメソッドの実行結果を格納（stock_idもCartモデルに連れて行ってね）
        $data = $cart->showCart($stock_id);
        return redirect()->back()->with('message', $message);//ページを移管させたくないから今いるページに移管
        //配列$dataをビューファイル->メソッド実行結果を格納した$messageも渡す（$data['message']=$message;と同じ意味）
    }
    public function checkout(Request $request, Cart $cart, Favorite $favorite)//cartモデムとfavoriteモデルも使うぜ
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
        return redirect()->back()->with('message', $message);//ページを移管させたくないから今いるページに移管
        //配列$dataをビューファイル->メソッド実行結果を格納した$messageも渡す（$data['message']=$message;と同じ意味）
    }
    public function deleteFavorite(Request $request, Favorite $favorite)
    {
        $stock_id=$request->stock_id;
        $message = $favorite->deleteFavorite($stock_id);//FavoriteモデルのshowFavboriteメソッドの実行結果を格納（stock_idもFavoriteモデルに連れて行ってね）
        $data = $favorite->showFavorite($stock_id);
        return redirect()->back()->with('message', $message);//ページを移管させたくないから今いるページに移管
        //配列$dataをビューファイル->メソッド実行結果を格納した$messageも渡す（$data['message']=$message;と同じ意味）
    }

    public function searchOrderHistory(Orderhistory $orderhistory, Request $request)
    {//注文履歴を検索するメソッド
        #キーワード受け取り
        $key = $request->input('key');//inputタグに入力されたキーワードを取得
        $genre = $request->genre;//selectタグからジャンルのvalueを取得

        #クエリ生成(Stockテーブルを参照)
        $query = Orderhistory::query();
       
        $query->where('name', 'like', '%'.$key.'%')
                  ->Where('genre', 'like', $genre);
                
        #ページネーション
        $orders = $query->orderBy('created_at', 'desc')->paginate(2);//最終的に数ふやす
        $data = $orderhistory->showOrderHistory();//検索されなければは全権表示するの実行結果を格納
        return view('searchorderhistory')->with('orders', $orders)->with('key', $key)->with('genre', $genre)->with($data);
        //->with('genre', $genre)も含めないとジャンルプルダウンが検索語に維持できなさそう
    }

    public function orderHistory(Orderhistory $orderhistory)
    {
        $data = $orderhistory->showOrderHistory();
        return view('orderhistory', $data);//compactは変数を配列にするメソッドなので、使わない。今回は$dataが既に配列型式
    }
}
