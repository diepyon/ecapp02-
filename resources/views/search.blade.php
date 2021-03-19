@extends('layouts.app')

@if($key=="" )
    @section('title', '検索結果')
@else
    @section('title', $key.'の検索結果')
@endif

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">
                @include('layouts.searchform')
                @if($key=="" )
                検索結果
                @else
                「{{$key ?? ''}}」の検索結果
                @endif
            </h1>
            @if($stocks->isEmpty() )
            <p class="text-center">見つかりませんでした。</p>
            @else
            @include('layouts.itemloop')
            @endif
        </div>
    </div>
</div>
<div class="text-center" style="width: 200px;margin: 20px auto;">{{$stocks->appends(request()->input())->links()}}</div>
@endsection
