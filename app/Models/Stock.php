<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use Illuminate\Support\Facades\Storage;//ファイルアップロード・削除関連
use \InterventionImage;//画像リサイズライブラリ
use FFMpeg;
//videoのwatermark関連で必要そうなもの
use FFMpeg\Format\VideoInterface;
use FFMpeg\Media\Video;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFilter;

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
   //自分の投稿を一覧
   {
       $user_id = Auth::id(); //ログインしているユーザーのIDを取得
       $data['stocks'] = $this->where('user_id', $user_id)->where('status', 'publish')->orWhere('status', 'inspection')->orderBy('created_at', 'desc')->paginate(30);
      //公開状態の投稿のみ表示（deleteなら非表示、下書きなども今は非表示）
       return $data; //連想配列データを実行結果として返す
   }

   public function searchPosts(){
        $user_id = Auth::id(); //ログインしているユーザーのIDを取得
        
        $query = Stock::query(); //クエリ生成(Stockテーブルを参照) 
        $data['stocks'] =$query->where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(30);;
                  //->where('status', 'publish');
        return $data; //連想配列データを実行結果として返す
   }

   public function deleteStock($stock_id)//statusを削除変更するメソッド（レコード自体は消さない）
   {
    $user_id = Auth::id(); //ログインユーザーのIDを取得
    $uploaded_filename=$this->where('id', $stock_id)->first()->path;//データのファイル名を取得

    Storage::delete(['public/stock_sample/'.$uploaded_filename, 'public/stock_download_sample/'.$uploaded_filename]);//販売データとループ用サムネイル以外削除（全部消すと買った人が困るから）
   }

   function gcd( $a, $b ) {
        //最大公約数を計算
        if( $a === 0 ) return $a ;
        $diff = $a > $b ? $a - $b : $b - $a ;
        $A = $diff ;
        $B = $b ;
        if( $B - $A ) {
            $A = $b ;
            $B = $diff ;
        }
        while( true ) {
            if( $B === 0 ) return $A ;
            $A %= $B ;
            if( $A === 0 ) return $B ;
            $B %= $A ;
        }
    }

    static function aspect($a, $b)
        {//アスペクト比を求める関数
            if ($a === 0) {
                return $a ;
            }
            $diff = $a > $b ? $a - $b : $b - $a ;
            $A = $diff ;
            $B = $b ;
            if ($B - $A) {
                $A = $b ;
                $B = $diff ;
            }
            while (true) {
                if ($B === 0) {
                    return $a/$A.':'. $b/$A ;
                }
                $A %= $B ;
                if ($A === 0) {
                    return $a/$B.':'. $b/$B ;
                }
                $B %= $A ;
            }
        }
    static function calcFileSize($size)
        {//ファイルサイズをいい感じの単位に調整する関数
          $b = 1024;    // バイト
          $mb = pow($b, 2);   // メガバイト
          $gb = pow($b, 3);   // ギガバイト
        
          switch (true) {
            case $size >= $gb:
              $target = $gb;
              $unit = 'GB';
              break;
            case $size >= $mb:
              $target = $mb;
              $unit = 'MB';
              break;
            default:
              $target = $b;
              $unit = 'KB';
              break;
          }
            $new_size = round($size / $target, 2);
            $file_size = number_format($new_size, 2, '.', ',') . $unit;
            return $file_size;
        }
    static function videoEncode($media,$width,$height){

//おもいから今はコメントアウト、後で外す        
/*         if($width > 3840){//横が3840以上なら4Kに変換して保存
            $media->addFilter(function ($filters)use ($width,$height) {
                $filters->resize(new \FFMpeg\Coordinate\Dimension(3840,2160));
            })
            ->export()
            ->toDisk('public')
            ->inFormat(new \FFMpeg\Format\Video\X264('aac'))
            ->save('sample_4K.mp4');            
        }elseif($width == 3840){//横が4kジャストならそのままコピー(requestにすると書き方変わると思う&4kよりでかい素材がないからそもそも変換ができるのか不明)
           if(Storage::disk('local')->exists('public/sample_4k.mp4')==false){Storage::copy('public/kengo.mp4', 'public/sample_4k.mp4');}//まだファイルが存在しないならコピー
        } */
        
/*         if($width >= 1920){//横が1920以上ならHDに変換して保存
            $media->addFilter(function ($filters)use ($width,$height) {
                $changeWidth = round($width*1080/$height);
                if($changeWidth%2==1){$changeWidth = $changeWidth+1;}  
                $filters->resize(new \FFMpeg\Coordinate\Dimension($changeWidth, 1080));
            })
            ->export()
            ->toDisk('public')
            ->inFormat(new \FFMpeg\Format\Video\X264('aac'))
            ->save('sample_HD.mp4');
        } */


        //SD画質に変換
        $media->addFilter(function ($filters)use ($width,$height) {
            $changeWidth = round($width*480/$height);
            if($changeWidth%2==1){$changeWidth = $changeWidth+1;}           
            $filters->resize(new \FFMpeg\Coordinate\Dimension($changeWidth, 480));
        })
        ->export()
        ->toDisk('local')
        ->inFormat(new \FFMpeg\Format\Video\X264('aac'))
        ->save('private/sample_SD.mp4');



        //ビデオ画質変換関数(ビデオ縦幅,保存先とデータ名)($mediaをスコープ内に渡せない)
/*         function resizeVideo($size,$saveat) {
            $media->addFilter(function ($filters)use ($width,$height) {
                $changeWidth = round($width*$size/$height);
                if($changeWidth%2==1){$changeWidth = $changeWidth+1;}           
                $filters->resize(new \FFMpeg\Coordinate\Dimension($changeWidth, $size));
            })
            ->export()
            ->toDisk('local')
            ->inFormat(new \FFMpeg\Format\Video\X264('aac'))
            ->save('private/.'.$saveat);//いったんsaveat
        } */
        //resizeVideo(480,'sample_SD.mp4');//sd画質に変換する関数を実行


        //watermark追加関数（ロゴのパス,編集元データ,保存先）
        function addWatermark($logo,$sourceFile,$saveat){
            $watermark = new WatermarkFilter(storage_path($logo),[
                'position'=>'relative',
                'bottom' => 0,
                'right' => 0,
            ]);
    
            FFMpeg::open($sourceFile)
                ->export()
                ->inFormat(new \FFMpeg\Format\Video\X264('aac'))
                ->addFilter($watermark)
                ->save($saveat);            
        }

        addWatermark('app/private/watermark/logo.png','private/sample_SD.mp4','private/watermark_sd.mp4');//sd画質のデータにサンプルロゴを追加


    }
}
