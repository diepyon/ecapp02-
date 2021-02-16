@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">

            <div class="input-group mb-3">
                <span class="genrebox">
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

            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">商品一覧</h1>
            <div class="">
                <div class="d-flex flex-row flex-wrap">
                    @foreach($stocks as $stock)
                    <div class="col-xs-6 col-sm-4 col-md-4 img_box ">
                        <div class="mycart_box">
                            ジャンル：{{$stock->genre}} <br>
                            {{$stock->fee}}円<br>
                            <div class="stock_thumbnail">
                                <img src="/image/{{$stock->path}}" alt="" class="incart">
                                <div class="genre_icon">
                                    <i class="fas fa-image" aria-hidden="true"></i>
                                </div>
                            </div>
                            <br>

                            <form action="mycart" method="post">
                                @csrf
                                <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                <input type="submit" value="カートに入れる">
                            </form>
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
