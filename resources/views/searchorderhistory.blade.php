@extends('layouts.app')

@if($key=="" )
    @section('title', '購入履歴検索結果')
@else
    @section('title',    $key.'の購入履歴検索結果')
@endif

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <p>購入履歴検索</p>
            <div class="input-group mb-3">
                <form id="search_form" action="{{url('/searchorderhistory')}}">
                    <?php if(empty($genre)){$genre = '';}
        //コントローラーに書きたいが全部のビューファイルに渡す必要が出てくるのでここに記載
        //genreが空だとエラーになるので対処 ?>
                    <span class="genrebox">
                        <select class="form-control" id="genre_select" name="genre">
                            <option value="image" @if($genre=='image' ) selected @endif>画像</option>
                            <option value="movie" @if($genre=='movie' ) selected @endif>映像</option>
                            <option value="bgm" @if($genre=='bgm' ) selected @endif>BGM</option>
                        </select>
                    </span>
                    <input type="search" class="form-control" name="key" value="{{$key ?? ''}}" placeholder="keyword"
                        aria-label="" aria-describedby="button-addon2" id="search_keyword">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="search_button"><i
                                class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">
                @if($key=="" )
                購入履歴検索結果
                @else
                「{{$key ?? ''}}」の購入履歴検索結果
                @endif
            </h1>
            @if($orders->isEmpty() )
            <p class="text-center">見つかりませんでした。</p>
            @else


            @if($orders->isNotEmpty())
            <div class="d-flex flex-row flex-wrap">
                @foreach($orders as $order)
                <div class="col-xs-6 col-sm-4 col-md-4 img_box ">
                    <div class="mycart_box">
                        {{$order->name}}<br>
                        ジャンル：{{$order->genre}} <br>
                        <div class="stock_thumbnail">
                            <a href="{{url('/product/')}}/{{$order->stock_id}}">
                                <img src="/storage/stock_thumbnail/{{$order->path}}" alt="" class="incart">
                            </a>
                            <div class="genre_icon">
                                <i class="fas fa-image" aria-hidden="true"></i>
                            </div>
                        </div>
                        {{$order->id}}<br>
                        {{$order->created_at->format('Y年m月d日') }}<br>
                        購入時の金額：￥{{number_format($order->fee_at_that_time) }}{{-- 購入時の金額を取得 --}}<br>
                        <br>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center" style="width: 200px;margin: 20px auto;">
                {{$orders->appends(request()->input())->links() }}
            </div>
            @else
            <p class="text-center">購入履歴はありません</p>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection
