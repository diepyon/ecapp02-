@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 class="text-center font-weight-bold" style="color:#555555;  font-size:1.2em; padding:24px 0px;">
                {{ Auth::user()->name }}さんの投稿した作品</h1>
                <a  class="btn btn-secondary btn-lg" href="{{ url('/stock/create')}}" role="button">投稿する</a>
            <p id='deleteMessage' class="text-center">{{ $message ?? '' }}</p><br>
            <div class="">
                @if($stocks->isNotEmpty())
                @foreach($stocks as $stock)
                <div class="card mb-3" style="max-width: ;">
                    <div class="no-gutters" style="display: flex;">
                        <!-- displayflexあとでcssに移して-->
                        <div class="col-3">
                            <a href="{{url('/stock/')}}/{{$stock->id}}">
                                <img src="{{$stock->thumbnail}}" alt=""
                                    class="myPost">
                            </a>
                        </div>
                        <div class="col-9">
                            <div class="card-body">
                                <a href="{{url('/stock/')}}/{{$stock->id}}">
                                    <h2 class="card-title">{{$stock->name}}</h2>
                                </a>
                                <div id="stock_info">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">{{$stock->status}}</li>
                                        <li class="list-group-item">{{$stock->width ?? ''}}x{{$stock->height?? ''}}px</li>
                                        <li class="list-group-item">{{$stock->mime ?? ''}}</li>
                                        <li class="list-group-item">{{$stock->aspectValue ?? ''}}</li>
                                        <li class="list-group-item">{{$stock->size ?? ''}}</li>
                                        <li class="list-group-item">￥{{ number_format($stock->fee)}}</li>
                                        <li class="list-group-item">
                                            @if($stock->created_at){{ $stock->created_at->format('Y/m/d')}}@endif</li>
                                        {{--日付が空でなければ変換して表示--}}
                                    </ul>
                                </div>
                            </div>
                            <div class="buttonArea">
                                <div class="jumpButton">
                                    <form id="" action="/stock/{{$stock->id}}/edit/" method="get">
                                        @csrf
                                        <button id="" class="btn btn-outline-secondary" type="submit" id="">編集</button>
                                    </form>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                                        data-target="#modalcenter_{{$stock->id}}">
                                        削除
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalcenter_{{$stock->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="modalcenter_{{$stock->id}}Title" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalcenter_{{$stock->id}}Title">確認</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    削除しますか
                                                </div>
                                                <div class="modal-footer">
                                                    <form id="" action="/stock/delete/" method="post"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                                        <button type="submit" class="btn btn-primary">削除</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">キャンセル</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- 
     <div class="d-flex flex-row flex-wrap">  
                  <div class="col-xs-6 col-sm-4 col-md-4 img_box ">
                    <div class="mycart_box">
                        {{$stock->name}}<br>
                ジャンル：{{$stock->genre}} <br>
                <div class="stock_thumbnail">
                    <a href="{{url('/stock/')}}/{{$stock->id}}">
                        <img src="{{url('/storage/stock_thumbnail')}}/{{$stock->path}}" alt="" class="incart">
                    </a>
                    <div class="genre_icon">
                        <i class="fas fa-image" aria-hidden="true"></i>
                    </div>
                </div>
                {{$stock->id}}<br>
                {{"" ?? $stock->created_at->format('Y年m月d日') }}<br>
                ￥{{number_format($stock->fee) }}<br>
                <br>
            </div>
        </div>
    </div>
    --}}
    @endforeach
    <div class="text-center" style="width: 200px;margin: 20px auto;">
        {{$stocks->links()}}
    </div>
    @else
    <p class="text-center">投稿した作品はありません。</p>
    @endif
</div>
</div>
</div>
</div>
@endsection
