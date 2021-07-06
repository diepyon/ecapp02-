<?php
//変換関連で必要なものを移植予定
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use App\Http\Requests\StockRequest; 
use App\Models\Stock; //いると思う
use App\Models\Cart; //Cartテーブルを使うぜ
use App\Models\Favorite;
use \InterventionImage;//画像リサイズライブラリ
use DB;
use Illuminate\Support\Facades\Storage;//保存やダウンロードに関するやつ
use FFMpeg;

//videoのwatermark関連で必要そうなもの
use FFMpeg\Format\VideoInterface;
use FFMpeg\Media\Video;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFilter;

use ProtoneMedia\LaravelFFMpeg\Filesystem\Media;

use Illuminate\Http\Request;

class ConversionController extends Controller
{
        //この先移植予定conversionControllerに移植予定

        public function henkan(Stock $stock){//変換処理は審査後に走らせたほうがいい気がしてきた
            //https://qiita.com/Nishi53454367/items/1ab543782f7c36fa4b87
            //変換前のファイル取得
            $media = FFMpeg::fromDisk('local')->open('private/stock_data/kengo.mp4');
    
            $mediaStreams = $media->getStreams()[0];  
            //再生時間を取得
            $durationInSeconds = $media->getDurationInSeconds();
            // コーデックを取得
            $codec = $mediaStreams->get('codec_name');     
            // 解像度(縦)を取得
            $height = $mediaStreams->get('height');
            // 解像度(横)を取得
            $width = $mediaStreams->get('width');
            $aspect=$stock->gcd($width, $height);
            // ビットレートを取得
            $bit_rate = $mediaStreams->get('bit_rate');  
            
            $stock->videoEncode($media,$width,$height);//変換処理
    
    
    /*         // 変換後のファイル取得
            $mediaSD = FFMpeg::fromDisk('public')->open('sample_SD.mp4');
            $mediaStreamsSD = $mediaSD->getStreams()[0];
    
            // 解像度(縦)を取得
            $height_SD = $mediaStreamsSD->get('height');
    
            // 解像度(横)を取得
            $width_SD = $mediaStreamsSD->get('width');
    
            // ビットレートを取得
            $bit_rate_SD = $mediaStreamsSD->get('bit_rate'); */
    
            // Viewで確認
            return view('home');/* ->with([
                "durationInSeconds" => $durationInSeconds,
                "codec" => $codec,
                "height" => $height,
                "width" => $width,
                "bit_rate" => $bit_rate,
                "height_SD" => $height_SD,
                "width_SD" => $width_SD,
                "bit_rate_SD" => $bit_rate_SD,
            ]) */
        }
    
        public function henkan2(){//wateremarkテスト
            FFMpeg::fromDisk('local')->open('private/stock_data/kengo.mp4')
             ->addWatermark(function(WatermarkFactory $factory){ 
                 $factory->open('app/private/watermark/logo.png')      
                    ->bottom(25)
                    ->left(25);
            })
            ->export()
            ->inFormat(new X264('aac')) //inFormat(new \FFMpeg\Format\Video\X264('aac'))
            ->save('watermarkpositiontest.mp4');
        }
    
        public function gousei(){//音声合成テスト
            //動画ではなく音声にしたければ
            //・片方の音ではなくミックスするコマンドを書く
            //・出力はたぶんm4a
    
            
             $media = FFMpeg::fromDisk('local')->open('private/douga.mp4');
             $durationInSeconds =$media->getDurationInSeconds();//動画の釈を取得
    
             //dd( $durationInSeconds );//データの再生時間を取得できる
    
            FFMpeg::fromDisk('local')
            ->open(['private/douga.mp4', 'private/ongen.m4a'])
            ->export()
            ->addFormatOutputMapping(new \FFMpeg\Format\Video\X264('aac'), Media::make('local', 'private/gousei.mp4'), ['0:v', '1:a'])
            ->save();
        }
    
        public function approval(Request $request,Stock $stock) {//投稿のステータスを公開に変える
            $stock_record = Stock::where('id', $request->stock_id);//承認ボタンが押された投稿idのレコードを取得
            
            
            
            //↓動画の時は　という条件 videoEncodeの関数内に書いたほうがいいかも？？
            if($stock_record->first()->genre=='movie'){
    
            $media = FFMpeg::fromDisk('local')->open('private/stock_data/'.$stock_record->first()->path);
            $mediaStreams = $media->getStreams()[0];  
    
            //この辺要らんかも
            //再生時間を取得
            $durationInSeconds = $media->getDurationInSeconds();
            // コーデックを取得
            $codec = $mediaStreams->get('codec_name');     
            // 解像度(縦)を取得
            $height = $mediaStreams->get('height');
            // 解像度(横)を取得
            $width = $mediaStreams->get('width');
            $aspect=$stock->gcd($width, $height);
            // ビットレートを取得
            $bit_rate = $mediaStreams->get('bit_rate');  
            
            //動画の時は　という条件が必要
            $stock->videoEncode($media,$width,$height);//サンプル用ファイル生成するための動画変換処理        
        }    
        
            $stock_record->update(['status' => 'publish']);
    
            return redirect()->back()->with('message', "承認しました。");
        }
        
        public function reject(Request $request,Stock $stock) {
            $stock_record = Stock::where('id',$request->stock_id)->first();//postされてきたstock_idを持つレコードをstocksテーブルから取得
    
            //いらなくなるサンプルデータや元データも削除したい
        
            $stock_record->update(['status' => 'rejected']);//statusをrejectedに変更     
            $stock_record->update(['rejected_reason' => $request->input('reasons')]);//却下理由を格納
    
            
            return redirect()->back()->with('message', "却下しました。");
        }    
        
public function cmd(){
    $cmd = 'ls  /usr/bin/ffmpeg' ;
    //exec($cmd,$opt,$result);
    //print_r($opt);

    //cd /usr/bin/  && ls

if (!exec('apt update  2>&1', $array)) {
    //command失敗を検知して処理したい
    echo "NG";
}
    var_dump($array);
    }
}
