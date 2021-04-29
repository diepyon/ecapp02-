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

                @foreach($items as $item)

                <?php //dd($item->created_at); ?>

                <div class="card mb-3" style="max-width: ;">
                    <div class="no-gutters" style="display: flex;">
                        <!- displayflexあとでcssに移して-!>
                            <div class="col-3">
                                <a href="{{url('/stock/')}}/{{$item->id}}">
                                    <img src="{{url('/storage/stock_thumbnail')}}/{{$item->path}}" alt=""
                                        class="myPost">
                                </a>
                            </div>
                            <div class="col-7">
                                <div class="card-body">
                                    <a href="{{url('/stock/')}}/{{$item->id}}">
                                        <h2 class="card-title">{{$item->name}}</h2>
                                    </a>
                                    <p class="card-text">
                                        {{ $item->created_at->format('Y/m/d') }}<br>
                                        ￥{{number_format($item->fee) }}<br>
                                    </p>
                                </div>
                            </div>

                            <div class="col-2 buttonArea">
                               <div class="jumpButton">
                                <form id="search_form" action="/stock/{{$item->id}}/edit/" method="get">
                                    @csrf
                                    <button id="mypage_submit" class="btn btn-outline-secondary" type="submit"
                                        id="">編集</button>
                                </form>

                                <form id="search_form" action="/stock/delete/" method="post">
                                    @csrf
                                    <input type="hidden" name="stock_id" value="{{ $item->id }}">
                                    <button id="mypage_submit" class="btn btn-outline-secondary" type="submit"
                                        id="">削除</button>
                                </form>
                                </div> 
                            </div>



                    </div>
                </div>

                {{-- 
     <div class="d-flex flex-row flex-wrap">  
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
    </div>
    --}}
    @endforeach

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
