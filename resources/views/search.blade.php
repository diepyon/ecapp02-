@extends('layouts.app')
@section('title', 'の検索結果')
@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
       @include('layouts.searchform')

            詳細ページへのリンクとかはまだ貼ってない。<br>アイコンのデザインとかもまだ触ってない。


            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">商品一覧</h1>
            <div class="">
                <div class="d-flex flex-row flex-wrap">
                    @foreach($stocks as $stock)
                    <div class="col-xs-6 col-sm-4 col-md-4 img_box ">
                        <div class="mycart_box">
                            ジャンル：{{$stock->genre}} <br>
                            {{$stock->fee}}円<br>
                            id:{{$stock->id}}<br>
                            <div class="stock_thumbnail">
                                <img src="/image/{{$stock->path}}" alt="" class="incart">
                                <form action="favorite" method="post">
                                    @csrf
                                    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                    <div class="favorite_icon">
                                        <button><i class="far fa-heart"></i></button>
                                    </div>
                                </form>
                                <div class="genre_icon">
                                    <i class="fas fa-image" aria-hidden="true"></i>
                                </div>
                                <form action="mycart" method="post">
                                    @csrf
                                    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                    <div class="download_icon">
                                        <button><i class="fas fa-cart-arrow-down"></i></button>
                                    </div>
                                </form>
                            </div>
                            <br>
                        </div>

                    </div>
                    @endforeach
                </div>
                <div class="text-center" style="width: 200px;margin: 20px auto;">
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
