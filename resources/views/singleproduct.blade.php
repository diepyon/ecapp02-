@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">

            <div class="input-group mb-3">
                <span lass="genrebox">
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>画像</option>
                        <option>映像</option>
                        <option>BGM</option>
                    </select>
                </span>
                <input type="text" class="form-control" placeholder="keyword" aria-label=""
                    aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                            class="fas fa-search"></i></button>
                </div>
            </div>
            @foreach($stocks as $stock)
            @section('title', $stock->name)
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">
                {{$stock->name}}</h1>
            @endforeach

            @foreach($stocks as $stock)
            <div class="row">
                <div class="col-sm-8">
                    <img src="/image/{{$stock->path}}" alt="" class="ditail_image">
                </div>
                <div class="col-sm-4">
                    <form action="/mycart" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <button type="button" class="btn btn-outline-secondary"><i class="far fa-heart"
                                aria-hidden="true">お気に入りに保存</i></button>
                    </form>
                    <form action="/mycart" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <button type="button" class="btn btn-outline-secondary"><i
                                class="fas fa-download">サンプルダウンロード</i></button>
                    </form>
                    <form action="/mycart" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <div class="">
                            <button class="btn btn-warning cart_button btn-lg btn-primary btn-lg btn-block"><i
                                    class="fas fa-cart-arrow-down">カートに追加</i></button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
