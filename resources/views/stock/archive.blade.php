@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 class="text-center font-weight-bold" style="color:#555555;  font-size:1.2em; padding:24px 0px;">
                {{ Auth::user()->name }}さんのカートの作品</h1>

            <div class="">
                

                @if($items->isNotEmpty())
                <div class="row">
                    <div class="col-sm-8">
                        <div class="d-flex flex-row flex-wrap">
                            @foreach($items as $item)
                            <div class="mycart_box mycart_box_incart">
                                {{$item->stock->name}} <br>
                                {{ number_format($item->stock->fee)}}円 <br>
                                <a href ="{{url('/product/')}}/{{$item->stock->id}}">
                                    <img src="/storage/stock_sample/{{$item->stock->path}}" alt="" class="incart">
                                </a>
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
                            作品数：件<br>
                        </div>


                    </div>
                </div>
                @else
                <p class="text-center">投稿はありません。</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection