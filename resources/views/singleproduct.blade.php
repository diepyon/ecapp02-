@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            @foreach($stocks as $stock)
            @section('title', $stock->name)
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">
                {{$stock->name}}</h1>
            @endforeach

            @include('layouts.searchform')

            @foreach($stocks as $stock)
            <p class="text-center">{{ session('message') ?? '' }}</p>
            <div class="row">
                <div class="col-sm-8">
                    <img src="/image/{{$stock->path}}" alt="" class="ditail_image">
                </div>
                <div class="col-sm-4">
                @if(in_array($stock->id, $favorite_data['favorite_list'],true))
                <form style="display:inline-block;" action="/favoritedelete"artComposer method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <button class="btn btn-outline-secondary"><i class="fas fa-heart">お気に入りから削除</i></button>
                    </form>
                @else
                <form style="display:inline-block;" action="/favorite"artComposer method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <button class="btn btn-outline-secondary"><i class="far fa-heart">お気に入りに保存</i></button>
                    </form>
                @endif
                    <form style="display:inline-block;" action="/favorite"artComposer method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <button class="btn btn-outline-secondary"><i class="far fa-heart">サンプルダウンロード（未リンク）</i></button>
                    </form>

                    @if(in_array($stock->id, $cart_data['cart_list'],true))               
                    <form action="/cartdelete" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <button class="btn btn-warning cart_button btn-lg btn-primary btn-lg btn-block"><i
                                class="fas fa-cart-arrow-down">カートから削除</i></button>
                    </form>
                    @elseif(in_array($stock->id, $orderhistory_data['orderhistory_list'],true))
                    <button class="btn btn-warning cart_button btn-lg btn-primary btn-lg btn-block"><i
                                class="fas fa-arrow-down">購入済みなのでダウンロード(未リンク)</i></button> 

                    @else
                    <form action="/mycart" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <button class="btn btn-warning cart_button btn-lg btn-primary btn-lg btn-block"><i
                                class="fas fa-cart-arrow-down">カートに追加</i></button>
                    </form>
                    @endif

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection