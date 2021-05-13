@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 class="text-center font-weight-bold" style="color:#555555;  font-size:1.2em; padding:24px 0px;">
                {{ Auth::user()->name }}さんの投稿した作品</h1>
            <p id='deleteMessage' class="text-center">{{ $message ?? '' }}</p><br>
            <div class="">
                <?php
            function calcFileSize($size)
            {//ファイルサイズをいい感じの単位に調整する関数
            $b = 1024;    // バイト
            $mb = pow($b, 2);   // メガバイト
            $gb = pow($b, 3);   // ギガバイト
            
            switch(true){
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
            ?>
                @if($items->isNotEmpty())
                @foreach($items as $item)
                <?php
                    if($item->genre=='image'){
                        $file = './storage/stock_sample/'.$item->path;//販売データのファイルパスを取得
                        $imgSize = getimagesize($file);//販売画像データ情報を取得
                        $width = $imgSize[0];//販売画像データの横幅を取得
                        $height= $imgSize[1];//販売画像データの高さを取得
                        $mime =$imgSize['mime']; //ファイルタイプ取得
                        $filesize =  calcFileSize(filesize('./storage/stock_sample/'.$item->path));
                    }
                    if($item->status=='publish'){
                        $status = '公開';}elseif($item->status=='inspection'){
                        $status = '審査中';
                        }else{
                        $status = 'その他';
                        }
                    //「下書き」なども追加予定
                ?>

                <div class="card mb-3" style="max-width: ;">
                    <div class="no-gutters" style="display: flex;">
                        <!-- displayflexあとでcssに移して-->
                        <div class="col-3">
                            <a href="{{url('/stock/')}}/{{$item->id}}">
                                <img src="{{url('/storage/stock_thumbnail')}}/{{$item->path}}" alt="" class="myPost">
                            </a>
                        </div>
                        <div class="col-9">
                            <div class="card-body">
                                <a href="{{url('/stock/')}}/{{$item->id}}">
                                    <h2 class="card-title">{{$item->name}}</h2>
                                </a>
                                <div id="stock_info">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">{{$status}}</li>
                                        <li class="list-group-item">{{$width ?? ''}}x{{$height?? ''}}px</li>
                                        <li class="list-group-item">{{$mime?? ''}}</li>
                                        <li class="list-group-item">アスペクト比</li>
                                        <li class="list-group-item">{{$filesize?? ''}}</li>
                                        <li class="list-group-item">￥{{ number_format($item->fee)}}</li>
                                        <li class="list-group-item">@if($item->created_at){{ $item->created_at->format('Y/m/d')}}@endif</li>{{--日付が空でなければ変換して表示--}}
                                    </ul>
                                </div>
                            </div>
                            <div class="buttonArea">
                                <div class="jumpButton">
                                    <form id="search_form" action="/stock/{{$item->id}}/edit/" method="get">
                                        @csrf
                                        <button id="" class="btn btn-outline-secondary" type="submit" id="">編集</button>
                                    </form>
                                    <form id="search_form" action="/stock/delete/" method="post">
                                        @csrf
                                        <input type="hidden" name="stock_id" value="{{ $item->id }}">
                                        <button id="" class="btn btn-outline-secondary" type="submit" id="">削除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 
     <div class="d-flex flex-row flex-wrap">  
                  <div class="col-xs-6 col-sm-4 col-md-4 img_box ">
                    <div class="mycart_box">
                        {{$item->name}}<br>
                ジャンル：{{$item->genre}} <br>
                <div class="stock_thumbnail">
                    <a href="{{url('/stock/')}}/{{$item->id}}">
                        <img src="{{url('/storage/stock_thumbnail')}}/{{$item->path}}" alt="" class="incart">
                    </a>
                    <div class="genre_icon">
                        <i class="fas fa-image" aria-hidden="true"></i>
                    </div>
                </div>
                {{$item->id}}<br>
                {{"" ?? $item->created_at->format('Y年m月d日') }}<br>
                ￥{{number_format($item->fee) }}<br>
                <br>
            </div>
        </div>
    </div>
    --}}
    @endforeach
    <div class="text-center" style="width: 200px;margin: 20px auto;">
        {{$items->links()}}
    </div>
    @else
    <p class="text-center">投稿した作品はありません。</p>
    @endif
</div>
</div>
</div>
</div>
@endsection
