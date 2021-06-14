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
    public function index(Orderhistory $orderhistory,Stock $stock,Request $request)
    {
        $user_id = Auth::id(); //ログインしているユーザーのIDを取得

        $order_items = DB::table('orderhistories')->where('author_id', $user_id)->orderBy('created_at', 'desc')->take(30)->get();//注文履歴テーブルより投稿者が自分（ログインユーザー）のレコードを直近30件取得
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


        $toalSalesMonth = Orderhistory::where('author_id',$user_id)
        ->whereBetween("created_at", [date("Y-m-01"),date("Y-m-t")])->sum("fee_at_that_time");//ログインユーザーの今月の売上合計(マージンとられてない状態)
                
        $totalPostsCount = Stock::where('user_id',$user_id)->where('status','publish')->count();//販売中の作品数
              
        //管理者向け機能(承認機能)

        //全部のレコードを取得してしまうけど、渡してしまって大丈夫なのか、ifで変数自体に処理を加えなくていいのか
        $inspection_items = DB::table('stocks')->where('status', 'inspection')->orderBy('created_at', 'asc')->get();//審査待ちの作品を取得

        //これも全部渡しちゃって大丈夫なのか、メールアドレスとか漏れそう
        $users = DB::table('users')->where('status','publish')->get();//削除されていないユーザーを取得

    
        $status = $request->session()->flash('status', 'Task was successful!');

        return view('home')->with([
            "order_items" => $order_items,
            "percentage" => $percentage,
            "inspection_items" => $inspection_items,
            "users" => $users,
            "toalSalesMonth"=>$toalSalesMonth,//ログインユーザーの今月の合計売上(配列にしてまとめて渡したほうがクールかも)
            "totalPostsCount"=>$totalPostsCount,
            "user_id"=>$user_id,
         ]);
    }

}
