@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 class="text-center font-weight-bold" style="color:#555555;  font-size:1.2em; padding:24px 0px;">
                {{ Auth::user()->name }}さんのカートの中身</h1>

            <div class="">
                <p class="text-center">{{ $message ?? '' }}</p><br>

                @if($items->isNotEmpty())
                <div class="row">
                    <div class="col-sm-8">
                        <div class="d-flex flex-row flex-wrap">
                            @foreach($items as $item)
                            <div class="mycart_box mycart_box_incart">
                                {{$item->stock->name}} <br>
                                {{ number_format($item->stock->fee)}}円 <br>
                                <img src="/image/{{$item->stock->path}}" alt="" class="incart">
                                <br>
                                <form action="/cartdelete" method="post">
                                    @csrf
                                    <input type="hidden" name="stock_id" value="{{ $item->stock->id }}">
                                    <input type="submit" value="カートから削除する">
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-center p-2">
                            個数：{{$count}}個<br>
                            <p style="font-size:1.2em; font-weight:bold;">合計金額:{{number_format($sum)}}円</p>
                        </div>

                        <form action="/checkout" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg text-center buy-btn">購入する</button>
                        </form>
                    </div>
                </div>
                @else
                <p class="text-center">カートはからっぽです。</p>
                @endif
                <a href="/"><p style="text-align:center;">商品一覧へ</p></a>
            </div>
        </div>
    </div>
</div>
@endsection
