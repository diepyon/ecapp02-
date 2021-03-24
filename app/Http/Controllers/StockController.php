<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use App\Http\Requests\StockRequest; 
use App\Models\Stock; //いると思う
use DB;

//https://note.com/koushikagawa/n/n9057d1a236f9
//を参考に作成

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function showCreateForm()
    {
        return view('/stock/create');
    }

    public function create(Request $request)
    {
    //dd($request->file('stock_file'));

    $request->file('stock_file')->store('public');//ファイル保存メソッド

    //$filename = pathinfo($request->file('stock_file'), PATHINFO_FILENAME);//ファイル名のみ



    //$extension = pathinfo(file('stock_file'), PATHINFO_EXTENSION);//拡張子のみ


    $request->validate([
    'stock_name' => 'required|max:2',
    'detail'=>'required',
    ]);
       // Stockモデルのインスタンスを作成する
       $stock = new Stock();
       $stock->name = $request->stock_name;
       $stock->genre = $request->genre;
       $stock->user_id = Auth::user()->id;
       $stock->fee = $request->fee;//数字しか入力させたくない
       $stock->detail = $request->detail;
       $stock->fee =  $request->fee;

       //$stock->subgenre = "";
       $stock->path = "a.jpg";
       $stock->created_at = now();
       $stock->updated_at = now();
      
       $stock->save();
       //「投稿する」をクリックしたら投稿情報表示ページへリダイレクト        
       return redirect()->route('stocks.detail', [
           'stock_id' => $stock->id,
       ]);
    }

    public function detail($stocks_id)
    {
        $stocks = DB::table('stocks')->where('id', $stocks_id)->get();
        return view('stock/detail', compact('stocks'));
    }
}
