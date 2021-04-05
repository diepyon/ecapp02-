@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
           
            @section('title', $stock->name)
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">
                {{$stock->name}}</h1>
            
            @include('layouts.searchform')

            <p class="text-center">{{ session('message') ?? '' }}</p>
            
            <div class="row">
                <div class="col-sm-8">
                    <img src="/image/{{$stock->path}}" alt="" class="ditail_image">
                </div>
                <div class="col-sm-4" id="single_form">
                    @if(in_array($stock->id, $favorite_data['favorite_list'],true))
                    <form style="display:inline-block;" action="/favoritedelete" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <button class="btn btn-outline-secondary"><i class="fas fa-heart">お気に入りから削除</i></button>
                    </form>
                    @else
                    <form style="display:inline-block;" action="/favorite" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <button class="btn btn-outline-secondary"><i class="far fa-heart">お気に入りに保存</i></button>
                    </form>
                    @endif
                    <form style="display:inline-block;" action="/favorite" method="post">
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
 

                    <div id="author">
                    <img src="{{asset('storage/user_icon/')}}/{{ $user->user_icon }}" id="previewImage">
                    投稿者　{{ $user->name }}
                    </div>

                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection

