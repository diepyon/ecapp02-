<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use Illuminate\Support\Facades\Storage;//ファイルアップロード・削除関連
use \InterventionImage;//画像リサイズライブラリ

class Stock extends Model
{
   protected $guarded = [
     'id'
   ];
   public function user()
   {
       return $this->belongsTo('\App\Models\Stock');//stockテーブルのくせにuserテーブルのデータを参照できるやつ
   }

   static function saveStockImg($request ,$user,$uploaded_filename){
        //ポストされたファイルが画像なら      
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
   }


   public function myPosts()
   //
   {
       $user_id = Auth::id(); //ログインしているユーザーのIDを取得
       $data['loops'] = $this->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
       //ログインユーザーのIDと同じ値を持つuser_idカラムのレコードを連想配列$dataのキー「items」に格納

       $data['items'] = $this->where('user_id', $user_id)->where('status', 'publish')->orderBy('created_at', 'desc')->paginate(30);
      //公開状態の投稿のみ表示（deleteなら非表示、下書きなども今は非表示）

       foreach ($data['loops'] as $loop) {
            $data['orderhistory_list'][] = $loop->id;
       }
       $data['orderhistory_list'][] ='dammy'; 

       return $data; //連想配列データを実行結果として返す
   }
   public function deleteStock($stock_id)//statusを削除変更するメソッド（レコード自体は消さない）
   {
    $user_id = Auth::id(); //ログインユーザーのIDを取得

    $uploaded_filename=$this->where('id', $stock_id)->first()->path;//データのファイル名を取得

    Storage::delete(['public/stock_sample/'.$uploaded_filename, 'public/stock_download_sample/'.$uploaded_filename]);//販売データとループ用サムネイル以外削除（全部消すと買った人が困るから）
    


/*     $delete = $this->where('user_id', $user_id)->where('id', $stock_id)->delete();//投稿者がログインユーザーかつ該当商品のIDであれば削除

    //user_idがログインユーザーと一致し、尚且つformからpostされてきた$stock_idとstock_idカラムの内容が一致するレコードを削除
    if ($delete > 0) {
        $message = '投稿を削除しました。';
    } else {
        $message = '削除できませんでした。';
    }
    return $message;   */   
   }

}
