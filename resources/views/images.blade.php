@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            @include('layouts.searchform')

            ログインユーザーがお気に入りに登録しているのは
            <br>
            @foreach($items as $item)
            id:{{$item->stock->id}}
            @endforeach
            <br>
            「お気に入りに登録しているIDと商品のIDが一致したら」という条件式の書き方がわからん<br><br>
            複数の配列（itemsとstocks)を１つのforeach文の中で同時に回す方法が不明。
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
                                <a href="{{url('/product/')}}/{{$stock->id}}">
                                    <img src="/image/{{$stock->path}}" alt="" class="incart">
                                </a>
                                <form action="favorite" method="post">
                                    @csrf
                                    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                    <div class="favorite_icon mouseon_icon">
                                        <span class="expert">aiueo</span>
                                        <button class="favorite"><i class="far fa-heart"></i></button>
                                        
                                    </div>
                                </form>
                                <div class="genre_icon">
                                    <i class="fas fa-image" aria-hidden="true"></i>
                                </div>
                                <form action="mycart" method="post">
                                    @csrf
                                    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                    <div class="download_icon mouseon_icon">
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
                    {{$stocks->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
