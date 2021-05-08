<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use App\Http\Requests\StockRequest; 
use App\Models\Stock; //いると思う
use App\Models\Cart; //Cartテーブルを使うぜ
use App\Models\Favorite;
use \InterventionImage;//画像リサイズライブラリ
use DB;
use Illuminate\Support\Facades\Storage;//保存やダウンロードに関するやつ

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
       $request->file('stock_file')->storeAs('private/stock_data',$uploaded_filename);
      
        if(strpos($mime,'image') !== false){
           $stock->saveStockImg($request,$user,$uploaded_filename);
        }else{
        //ポストされたデータが画像以外なら（作成段階）
        }     

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
        
        return view('stock/detail', compact('stock','user_id'))->with('message','更新しました。');
    }

    public function archive(Stock $stock)
    {
        $data = $stock->myPosts();       
        return view('stock/archive', $data);
    }



    public function delete(Request $request, Stock $stock)
    {
        $stock_record = Stock::where('id',$request->stock_id);//postされてきたstock_idを持つレコードをstocksテーブルから取得
        $cart_record = Cart::where('stock_id',$request->stock_id);//postされてきたstock_idを持つレコードをcartsテーブルから取得
        $favorite_record = Favorite::where('stock_id',$request->stock_id);//postされてきたstock_idを持つレコードをfavoritesテーブルから取得

    if($stock_record->first()->status !=='delete') {
        $message = '削除しました。';
    }else{//既に削除済みの場合
        $message = '削除できませんでした。';
    }
        $stock_record->update(['status' => 'delete']);//statusをdeleteに変更（レコード自体は消さない）
        $cart_record->delete();//cartsテーブルから該当stock_idを持つレコードを削除（みんなの買い物かごから消える）
        $favorite_record->delete();//favoritesテーブルから該当stock_idを持つレコードを削除（みんなのお気に入りから消える）

        $data = $stock->myPosts($stock_record);

        return view('stock/archive',$data)->with('message', $message);
    }

    //↓メソッド化したいが、モデルからコントローラーに変数が渡せない
    public function download(Request $request, Stock $stock)//urlを知られずにファイルをダウンロードさせる
    {
        $user_id =Auth::user()->id;//ログインユーザーのIDを取得

        $orderhistories =  DB::table('orderhistories')->where('user_id', $user_id)->get();//購入履歴テーブルからログインユーザーが購入した商品のレコードを取得

        foreach($orderhistories as $orderhistorie){
            $orderhistoriesID[]= $orderhistorie->stock_id;
        }//購入済み商品のstock_idを配列に格納

         $stock_id=$request->stock_id;//ダウンロードボタンから商品IDを取得
         $stockPath= DB::table('stocks')->where('id', $stock_id)->first()->path;//該当商品IDのファイルパスを取得
         $stockPath='private/stock_data/'.$stockPath;//実際のファイルパスを生成  
         $mimeType = Storage::mimeType($stockPath);//マイム情報を取得
         $extension = pathinfo($stockPath, PATHINFO_EXTENSION);//拡張子のみ  
         $headers = [['Content-Type' => $mimeType]];//ダウンロード用にマイムタイプをにゃほにゃほする
         $fileName =  substr(bin2hex(random_bytes(8)), 0, 8).'.'.$extension;//「ファイル名はランダム英数字.拡張子」      

         //ソースコードからstock_idを書き換えられてもダウンロードできないように対処
         if(in_array((int)$stock_id, $orderhistoriesID,true)) {//ログインユーザーの購入履歴に該当stock_idが存在する場合
            return Storage::download($stockPath, $fileName, $headers);//ファイルをダウンロードさせる処理
         }else{//ログインユーザーの購入履歴に該当stock_idが存在しない場合（ソースコードが改ざん時など）

        return redirect()->back()->with('message', "そのIDの商品は未購入なのでダウンロードできません。");
            //わかりにくい、jsでポップアップしたい
         }             
    }
}
