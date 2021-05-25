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
    static function makeVideoThumbnail($uploaded_filename){
        
        $filiname_remove_extension= pathinfo($uploaded_filename, PATHINFO_FILENAME);//ファイル名から拡張子を除外

        //動画サムネイルを生成
        $media = FFMpeg::fromDisk('local')
        ->open('private/stock_data/'.$uploaded_filename)
        ->getFrameFromSeconds(1)//1フレーム目
        ->export()
        ->save('public/stock_thumbnail/'.$filiname_remove_extension.'.jpg');//ファイル名をjpgに変換

        
        //動画サムネイルリサイズ（でかすぎると思いから縮小）
        $fileinfo= storage_path('app/public/stock_thumbnail/'.$filiname_remove_extension.'.jpg');
        InterventionImage::make($fileinfo)->resize(750, 750, function ($constraint) {
            $constraint->aspectRatio();
        })->save($fileinfo);
    }
   

   public function myPosts()
   //自分の投稿を一覧
   {
       $user_id = Auth::id(); //ログインしているユーザーのIDを取得

       //自分の作品で、公開中または審査中の作品を取得
       $data['stocks'] = 
        $this
            ->where(function($query){
                $query->where('status', 'publish')
                ->orWhere('status', 'rejected')
                ->orWhere('status', 'inspection');
            })
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(30);
              //公開状態の投稿のみ表示（deleteなら非表示、下書きなども今は非表示）

            foreach ($data['stocks'] as $key => $stock) {

                if($stock->status=='publish'){
                    $data['stocks'][$key]['status']  = '公開';
                }elseif($stock->status=='inspection'){
                    $data['stocks'][$key]['status'] = '審査中';
                }elseif($stock->status=='rejected'){
                    $data['stocks'][$key]['status'] = '却下';
                }else{
                    $data['stocks'][$key]['status'] = 'その他';
                    }
                //「下書き」「却下」なども追加予定
                    
                if ($stock->genre=='image') {//ジャンルが画像なら
                    $sample = getimagesize('./storage/stock_sample/'.$stock->path);//private配下にあるがゆえに本データからは取得できないような情報はサンプル画像から取得する
                    $data['stocks'][$key]['size'] = $this->calcFileSize(Storage::size('/private/stock_data/'.$stock->path));//実際の販売データのファイルサイズを取得
                    $data['stocks'][$key]['mime'] = $sample['mime'];//サンプルデータからmimeタイプを取得（販売データprivateにいて取れないので）                   
                    $data['stocks'][$key]['width'] = $sample[0];//サンプルデータから横幅を取得（販売データprivateにいて取れないので）
                    $data['stocks'][$key]['height'] = $sample[1];//サンプルデータから縦幅を取得（販売データprivateにいて取れないので）    
                    $data['stocks'][$key]['thumbnail'] = url('/storage/stock_thumbnail/'.$stock->path);//サムネイル画像を取得
                    $data['stocks'][$key]['aspectValue'] =$this->aspect( $data['stocks'][$key]['width'], $data['stocks'][$key]['height'] );  //アスペクト比を取得
                    

                }elseif($stock->genre=='movie') {//ジャンルが映像なら
                    $data['stocks'][$key]['thumbnail'] = url('/storage/stock_thumbnail/'.pathinfo($stock->path, PATHINFO_FILENAME).'.jpg');//サムネイル画像を取得
                    
                }
                
            }
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
            $stock = new Stock;

                    //保存先ちゃんと決めよ
                    //ジャストサイズならそのサイズの名前で保存しよう。普通にstock_dataから名前を変えてコピーするだけかも


                    if($width > 3840){//元データが4kより大きいなら4kにリサイズ（動作未検証）
                        $stock->resizeVideo(2160,'hogehoge_movie_name_4K.mp4',$media,$width,$height);
                        $stock->addWatermark('app/private/watermark/logo.png', 'private/hogehoge_movie_name_4K.mp4', 'private/hogehoge_watermark_4K.mp4');
                    }
                    if($width >= 1920){//元データがフルHD以上ならフルHDにリサイズ
                        $stock->resizeVideo(1080,'hogehoge_movie_name_HD.mp4',$media,$width,$height);
                        $stock->addWatermark('app/private/watermark/logo_hd.png', 'private/hogehoge_movie_name_HD.mp4', 'private/hogehoge_watermark_HD.mp4',$width,$height);
                    } 

                    $stock->resizeVideo(480, 'hogehoge_movie_name_SD.mp4',$media,$width,$height);//sd画質に変換する関数を実行
                    $stock->addWatermark('app/private/watermark/logo.png', 'private/hogehoge_movie_name_SD.mp4', 'private/hogehoge_watermark_SD.mp4',$width,$height);//sd画質のデータにサンプルロゴを追加
            }

        //ビデオ画質変換関数(ビデオ縦幅,保存先とデータ名)
        private function resizeVideo($size, $saveat,$media,$width,$height)
        {
            $media->addFilter(function ($filters) use ($width, $height,$size) {
                $changeWidth = round($width*$size/$height);
    
                if ($changeWidth%2==1) {
                    $changeWidth = $changeWidth+1;
                }
                $filters->resize(new \FFMpeg\Coordinate\Dimension($changeWidth, $size));
            })
            ->export()
            ->toDisk('local')
            ->inFormat(new \FFMpeg\Format\Video\X264('aac'))
            ->save('private/'.$saveat);//いったんsaveat
        }
        
        //watermark追加関数（ロゴのパス,編集元データ,保存先）
        private function addWatermark($logo, $sourceFile, $saveat,$width,$height) 
        {
            $watermark = new WatermarkFilter(storage_path($logo), [
                'position'=>'relative',
                'bottom' => $height/3,
                'left' => $width/4,
            ]);
    
            FFMpeg::open($sourceFile)
                ->export()
                ->inFormat(new \FFMpeg\Format\Video\X264('aac'))
                ->addFilter($watermark)
                ->save($saveat);
        } 
              
}
