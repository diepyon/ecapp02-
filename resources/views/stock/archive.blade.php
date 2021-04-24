@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 class="text-center font-weight-bold" style="color:#555555;  font-size:1.2em; padding:24px 0px;">
                {{ Auth::user()->name }}さんの投稿した作品</h1>
                <p class="text-center">{{ $message ?? '' }}</p><br>
            <div class="">
            @if($items->isNotEmpty())
            <div class="d-flex flex-row flex-wrap">
                @foreach($items as $item)
                <div class="col-xs-6 col-sm-4 col-md-4 img_box ">
                    <div class="mycart_box">
                        {{$item->name}}<br>
                        ジャンル：{{$item->genre}} <br>
                        <div class="stock_thumbnail">
                            <a href="{{url('/stock/')}}/{{$item->id}}">
                                <img src="{{url('/storage/stock_thumbnail')}}/{{$item->path}}" alt="" class="incart">
                            </a>
                            <div class="genre_icon">
                                <i class="fas fa-image" aria-hidden="true"></i>
                            </div>
                        </div>
                        {{$item->id}}<br>
                        {{"" ?? $item->created_at->format('Y年m月d日') }}<br>
                       ￥{{number_format($item->fee) }}<br>
                        <br>
                    </div>
                </div>
                @endforeach
            </div>
             <div class="text-center" style="width: 200px;margin: 20px auto;">
              {{$items->links()}}
              </div>
            @else
           
            <p class="text-center">投稿した作品はありません。</p>
            
            @endif               


            </div>
        </div>
    </div>
</div>
@endsection