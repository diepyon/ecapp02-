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
        public function approval(Request $request,Stock $stock) {//投稿のステータスを公開に変える
            $stock_record = Stock::where('id', $request->stock_id);//承認ボタンが押された投稿idのレコードを取得
            
            if($stock_record->first()->genre=='movie'){//動画の時は　
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
                $stock->videoEncode($media,$width,$height);//サンプル用ファイル生成するための動画変換処理        
            
            }elseif($stock_record->first()->genre=='audio'){//音源の時は
           
                $ffMpeg = FFMpeg::fromDisk('local')->open(['private/stock_data/'.$stock_record->first()->path])->export();

                if(pathinfo($stock_record->first()->path, PATHINFO_EXTENSION)!=='wav'){//データがwav以外なら     
                    //音源をwavに変換                    
                    $ffMpeg->inFormat(new \FFMpeg\Format\Audio\Wav);
                    $ffMpeg->save('private/stock_data/'.pathinfo($stock_record->first()->path, PATHINFO_FILENAME).'.wav');                      
                }

                if(pathinfo($stock_record->first()->path, PATHINFO_EXTENSION)!=='mp3'){//データがmp3以外なら
                    //音源をmp3に変換
                    $ffMpeg->inFormat(new \FFMpeg\Format\Audio\Mp3);
                    $ffMpeg->save('private/stock_data/'.pathinfo($stock_record->first()->path, PATHINFO_FILENAME).'.mp3');  
                }                

                    //サンプル音源を生成
                    $ffMpeg = FFMpeg::fromDisk('local')->open(['private/stock_data/'.$stock_record->first()->path, 'private/sample_parts/sample.m4a'])->export();
                    $ffMpeg->addFilter('[0][1]', 'amix=inputs=2:duration=longest', '[a]');
                    $ffMpeg->addFormatOutputMapping(new \FFMpeg\Format\Video\WebM, Media::make('local', 'public/stock_download_sample/'. pathinfo($stock_record->first()->path, PATHINFO_FILENAME).'.mp3'), ['[a]']);
                    $ffMpeg->save();         
            }
            
            $stock_record->update(['status' => 'publish']);
            return redirect()->back()->with('message', "承認しました。");
        }
        
        public function reject(Request $request,Stock $stock) {
            $stock_record = Stock::where('id',$request->stock_id)->first();//postされてきたstock_idを持つレコードをstocksテーブルから取得
    
            //いらなくなるサンプルデータや元データも削除したい（ユーザー誤バンに備えて削除から3か月たったら消すとかのほうがいいかも）
        
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

