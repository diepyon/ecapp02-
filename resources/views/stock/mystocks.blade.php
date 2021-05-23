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
                @if($stocks->isNotEmpty())
                @foreach($stocks as $stock)
                <?php
                    if($stock->genre=='image'){
                        $file = './storage/stock_sample/'.$stock->path;//販売データのファイルパスを取得
                        $imgSize = getimagesize($file);//販売画像データ情報を取得
                        $width = $imgSize[0];//販売画像データの横幅を取得
                        $height= $imgSize[1];//販売画像データの高さを取得
                        $mime =$imgSize['mime']; //ファイルタイプ取得
                        $filesize =  calcFileSize(filesize('./storage/stock_sample/'.$stock->path));
                    }
                    if($stock->status=='publish'){
                        $status = '公開';}elseif($stock->status=='inspection'){
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
                            <a href="{{url('/stock/')}}/{{$stock->id}}">
                                <img src="{{url('/storage/stock_thumbnail')}}/{{$stock->path}}" alt="" class="myPost">
                            </a>
                        </div>
                        <div class="col-9">
                            <div class="card-body">
                                <a href="{{url('/stock/')}}/{{$stock->id}}">
                                    <h2 class="card-title">{{$stock->name}}</h2>
                                </a>
                                <div id="stock_info">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">{{$status}}</li>
                                        <li class="list-group-item">{{$width ?? ''}}x{{$height?? ''}}px</li>
                                        <li class="list-group-item">{{$mime?? ''}}</li>
                                        <li class="list-group-item">アスペクト比</li>
                                        <li class="list-group-item">{{$filesize?? ''}}</li>
                                        <li class="list-group-item">￥{{ number_format($stock->fee)}}</li>
                                        <li class="list-group-item">@if($stock->created_at){{ $stock->created_at->format('Y/m/d')}}@endif</li>{{--日付が空でなければ変換して表示--}}
                                    </ul>
                                </div>
                            </div>
                            <div class="buttonArea">
                                <div class="jumpButton">
                                    <form id="search_form" action="/stock/{{$stock->id}}/edit/" method="get">
                                        @csrf
                                        <button id="" class="btn btn-outline-secondary" type="submit" id="">編集</button>
                                    </form>
                                    <form id="search_form" action="/stock/delete/" method="post">
                                        @csrf
                                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
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
                        {{$stock->name}}<br>
                ジャンル：{{$stock->genre}} <br>
                <div class="stock_thumbnail">
                    <a href="{{url('/stock/')}}/{{$stock->id}}">
                        <img src="{{url('/storage/stock_thumbnail')}}/{{$stock->path}}" alt="" class="incart">
                    </a>
                    <div class="genre_icon">
                        <i class="fas fa-image" aria-hidden="true"></i>
                    </div>
                </div>
                {{$stock->id}}<br>
                {{"" ?? $stock->created_at->format('Y年m月d日') }}<br>
                ￥{{number_format($stock->fee) }}<br>
                <br>
            </div>
        </div>
    </div>
    --}}
    @endforeach
    <div class="text-center" style="width: 200px;margin: 20px auto;">
        
    {{$stocks->appends(request()->input())->onEachSide(2)->links()}}
    </div>
    @else
    <p class="text-center">作品はありません。</p>
    @endif
</div>
</div>
</div>
</div>
@endsection
