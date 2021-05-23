<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orderhistory;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Stock;//belongstoでいるのか？

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Orderhistory $orderhistory)
    {
        $user_id = Auth::id(); //ログインしているユーザーのIDを取得

        $order_items = DB::table('orderhistories')->where('author_id', $user_id)->orderBy('created_at', 'desc')->get();//注文履歴テーブルより投稿者が自分（ログインユーザー）のレコードを全件取得
        $stock_items = DB::table('stocks')->where('user_id', $user_id)->where('status', 'publish')->orderBy('created_at', 'desc')->get();//stocksテーブルより自分の投稿した公開中の商品レコードを取得
        $stocks_items_count_all=count($stock_items);//ログインユーザーの公開済み製品の個数をカウント

        //ログインユーザーの商品ジャンルごとの個数を確認
        $stocks_items_count_image =count($stock_items->where('genre','image'));
        $stocks_items_count_movie =count($stock_items->where('genre','movie'));
        $stocks_items_count_sound =count($stock_items->where('genre','sound'));
        
        

         //ログインユーザーの商品ジャンルの割合を取得(四捨五入)
        if(!empty($stocks_items_count_all)){//アイテムの合計要素数が0だと算数の計算でバグるので回避
            $percentage['image'] = round($stocks_items_count_image/$stocks_items_count_all*100);
            $percentage['movie'] = round($stocks_items_count_movie/$stocks_items_count_all*100);
            $percentage['sound'] = round($stocks_items_count_sound/$stocks_items_count_all*100);
        }else{
            $percentage['image'] = 0;
            $percentage['movie'] = 0;
            $percentage['sound'] = 0;
        }

        //集計しようと頑張ってるけど無理やったやつ
        foreach($order_items as $order_item){
            $stock_id= $order_item->stock_id;
        }
    
        //$stock_count = array_count_values($stock_id);//それぞれのstock_idの出現回数を取得
        ///$unique_stocks = array_unique($stock_id);//stock_id配列より重複を削除
        //管理者向け機能

        //全部のレコードを取得してしまうけど、渡してしまって大丈夫なのか、ifで変数自体に処理を加えなくていいのか
        $inspection_items = DB::table('stocks')->where('status', 'inspection')->orderBy('created_at', 'asc')->get();

        //これも全部渡しちゃって大丈夫なのか、メールアドレスとか漏れそう
        $users = DB::table('users')->get();
   
        return view('home')->with([
            "order_items" => $order_items,
            "percentage" => $percentage,
            "inspection_items" => $inspection_items,
            "users" => $users,
         ]);
    } 

}
