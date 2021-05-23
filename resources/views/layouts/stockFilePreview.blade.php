{{--投稿・投稿変数ページに表示するやプレビューファイル--}}
<?php
    //メソッド化したらdetailでもeditでもsingleでも使いまわせると思う
    if($stock->genre == 'image'){//genreがimageならそのままのファイル名をサムネイルに使う
        $thunbmbnail_file =$stock->path;
    }elseif($stock->genre == 'movie'){
        $thunbmbnail_file = pathinfo($stock->path, PATHINFO_FILENAME).'.jpg';
    }else{//その他（サウンドも別で考えなあかん）
        $thunbmbnail_file =null;
    }
?>

@if($stock->genre=='image')
<img src="/storage/stock_sample/<?php echo $thunbmbnail_file;?>" alt="" class="ditail_image">
@elseif($stock->genre=='movie')
<img src="/storage/stock_thumbnail/<?php echo $thunbmbnail_file;?>" alt="" class="ditail_image">
@else
サウンドも作らなかん
@endif