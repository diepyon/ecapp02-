<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use App\Http\Requests\StockRequest; 
use App\Models\Stock; //いると思う
use \InterventionImage;//画像リサイズライブラリ
use DB;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function showCreateForm()
    {
        return view('/stock/create');
    }

    public function create(Request $request ,Stock $stock)
    {
    $user =Auth::user();

    $request->validate([
    'stock_file'=> 'required |mimes:jpg,png,gif,mp4,mp3,wav,m4a',
    'stock_name' => 'required|max:20',
    'detail'=>'required',
    ]);



       $file= $request->file('stock_file')->getClientOriginalName();//アップロード前のファイル名
       $mime= $request->file('stock_file')->getClientMimeType();//アップロード前のマイムタイプ
       $extension = pathinfo($file, PATHINFO_EXTENSION);//拡張子のみ  

       $uploaded_filename= $user->id.'_'.substr(bin2hex(random_bytes(8)), 0, 8).'.'.$extension;//アップロード後のファイル名は「ユーザーID_8文字のランダムな英数字.拡張子」  

       //データをそのまま保存
       $request->file('stock_file')->storeAs('public/stock_data',$uploaded_filename);
      
        if(strpos($mime,'image') !== false){
           $stock->saveStockImg($request,$user,$uploaded_filename);
        }else{
        //ポストされたデータが画像以外なら（作成段階）
        }     

        //dd($message);

       $stock = new Stock();//Stockモデルのインスタンスを作成する
       $stock->name = $request->stock_name;
       $stock->genre = $request->genre;
       $stock->user_id = Auth::user()->id;
       $stock->fee = $request->fee;
       $stock->detail = $request->detail;
       $stock->fee =  $request->fee;
       $stock->path = $uploaded_filename;//アップロード後のファイル名をデータベースに登録
       $stock->created_at = now();
       $stock->updated_at = now();
       $stock->save();


       //「投稿する」をクリックしたら投稿情報表示ページへリダイレクト        
       return redirect()->route('stocks.detail', [
           'stock_id' => $stock->id,
       ])->with('message', '投稿しました。');
      
    }

    public function detail($stocks_id)
    {
        $user_id =Auth::user()->id;//ログインユーザーのIDを取得
        $stock = DB::table('stocks')->where('id', $stocks_id)->first();
        return view('stock/detail', compact('stock','user_id'));
    }
    
    public function edit($stocks_id)
    {    
        $user_id =Auth::user()->id;//ログインユーザーのIDを取得   
        $stock = DB::table('stocks')->where('id', $stocks_id)->first();
       
        return view('stock/edit', compact('stock','user_id'));
    }

    public function update($stocks_id,Request $request,Stock $stock)
    { 
        $user_id =Auth::user()->id;//ログインユーザーのIDを取得   
        $stock_record = Stock::where('id', $stocks_id);

        $stock_record->update(['name' => $request->stock_name]);
        $stock_record->update(['fee' => $request->fee]);

        $stock_record->update(['genre'=>$request->genre]);
        $stock_record->update(['detail' => $request->detail]);

        $request->validate([
            'stock_file'=> 'mimes:jpg,png,gif,mp4,mp3,wav,m4a',
            'stock_name' => 'required|max:20',
            'detail'=>'required',
            ]);
        $stock = DB::table('stocks')->where('id', $stocks_id)->first();
        
        //メソッド化したいのでまだ画像を差し替える処理は書いていない
        return view('stock/detail', compact('stock','user_id'))->with('message','更新しました。');
    }

    public function archive(Stock $stock)
    {
        $data = $stock->myPosts();
        return view('stock/archive', $data);
    }

    public function delete(Request $request, Stock $stock)
    {
        $stock_record = Stock::where('id',$request->stock_id);



    if($stock_record->first()->status !=='delete') {
        $message = '削除しました。';
    }else{//既に削除済みの場合
        $message = '削除できませんでした。';
    }

        $stock_record->update(['status' => 'delete']);//statusをdeleteに変更（レコード自体は消さない）

        $data = $stock->myPosts($stock_record);

        return view('stock/archive',$data)->with('message', $message);//削除後のルーティングに問題あり
      
    }
    
}
