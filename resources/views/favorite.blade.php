@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 class="text-center font-weight-bold" style="color:#555555;  font-size:1.2em; padding:24px 0px;">
                {{ Auth::user()->name }}さんのお気に入り</h1>

            <div class="">
            <p class="text-center">{{ session('message') ?? '' }}</p><br>
                @if($items->isNotEmpty())

                <div class="d-flex flex-row flex-wrap">

                    @foreach($items as $item)
                    <a href="{{url('/product/')}}/{{$item->stock->id}}">
                    <div class="mycart_box mycart_box_incart">
                        {{$item->stock->name}} <br>
                        {{ number_format($item->stock->fee)}}円 <br>
                        <img src="/image/{{$item->stock->path}}" alt="" class="incart">
                        <br>
                        <form action="/favoritedelete" method="post">
                            @csrf
                            <input type="hidden" name="stock_id" value="{{ $item->stock->id }}">
                            <input type="submit" value="お気に入りから削除する">
                        </form>
                    </div>
                    </a>
                    @endforeach
                </div>



                @else
                <p class="text-center">お気に入りは未登録です。</p>
                @endif
                <a href="/">商品一覧へ</a>
            </div>
        </div>
    </div>
</div>
@endsection