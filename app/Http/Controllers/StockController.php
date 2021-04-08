<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use App\Http\Requests\StockRequest; 
use App\Models\Stock; //いると思う
use \InterventionImage;//画像リサイズライブラリ
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
    $user =Auth::user();

    $request->validate([
    'stock_file'=> 'required |mimes:jpg,png,gif,mp4,mp3,wav,m4a',
    'stock_name' => 'required|max:20',
    'detail'=>'required',
    ]);

    
       $file= $request->file('stock_file')->getClientOriginalName();//アップロード前のファイル名
       $extension = pathinfo($file, PATHINFO_EXTENSION);//拡張子のみ  

       $uploaded_filename= $user->id.'_'.substr(bin2hex(random_bytes(8)), 0, 8).'.'.$extension;//アップロード後のファイル名は「ユーザーID_8文字のランダムな英数字.拡張子」  

       //データをそのまま保存（本番データだけファイルの命名方式をかえてデータベースに登録しないとパクられるかも。もしくは権限設定）
       $request->file('stock_file')->storeAs('public/stock_data',$uploaded_filename);
      
        //以下$request->file('stock_file')が画像ならという条件式がほしい
  
        /*----------
        縮小サイズで保存（ループ一覧用）
        ----------*/               
        InterventionImage::make($request->file('stock_file'))->resize(800, 280, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path(('app/public/stock_thumbnail/'.$uploaded_filename),100));//縮小サイズで保存        

        /*----------
        圧縮ありの透かし(singleページ用)
        ----------*/       
        $imagewidth =InterventionImage::make($request->file('stock_file'))->width();
        //投稿された画像の横幅を取得    

        $fontsize = $imagewidth*0.08;
        //↑イメージの横幅の0.08倍の大きさをフォントサイズとして定義

        $sample = 'sample  sample  sample  sample'."\n\n";
        for ($i =1; $i <= 5; $i++){
            $sample = $sample.$sample;
        }//sample文字をたくさん挿入
            
        $x=100; 
        $y=100;//挿入座標          
        
        InterventionImage::make($request->file('stock_file'))
        ->text($sample, $x, $y, function ($font) use($fontsize) {          
            $font->file('assets/fonts/SawarabiGothic-Regular.ttf');
            $font->size( $fontsize );        // 文字サイズ
            $font->color(array(255, 255, 255, 0.5));   // 文字の色
            $font->align('center'); // 横の揃え方（left, center, right）
            $font->valign('top');   // 縦の揃え方（top, middle, bottom）
            $font->angle(30);       // 回転（フォントが指定されていないと無視されます。）
            })
        ->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
            })//singleページ用に圧縮
        ->save(storage_path('app/public/stock_sample/'.$uploaded_filename),100);

        /*----------
        圧縮なしの透かし(サンプルダウンロード用)
        ----------*/              
        InterventionImage::make($request->file('stock_file'))
        ->text($sample, $x, $y, function ($font) use($fontsize) {          
            $font->file('assets/fonts/SawarabiGothic-Regular.ttf');
            $font->size( $fontsize );        // 文字サイズ
            $font->color(array(255, 255, 255, 0.5));   // 文字の色
            $font->align('center'); // 横の揃え方（left, center, right）
            $font->valign('top');   // 縦の揃え方（top, middle, bottom）
            $font->angle(30);       // 回転（フォントが指定されていないと無視されます。）
            })
        ->save(storage_path('app/public/stock_download_sample/'.$uploaded_filename),100);

       $stock = new Stock();//Stockモデルのインスタンスを作成する
       $stock->name = $request->stock_name;
       $stock->genre = $request->genre;
       $stock->user_id = Auth::user()->id;
       $stock->fee = $request->fee;//数字しか入力させたくない
       $stock->detail = $request->detail;
       $stock->fee =  $request->fee;
       $stock->path = $uploaded_filename;//アップロード後のファイル名をデータベースに登録
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
