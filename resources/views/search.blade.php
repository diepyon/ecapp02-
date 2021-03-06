@extends('layouts.app')
@section('title', 'の検索結果')
@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            @include('layouts.searchform')
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">商品一覧</h1>
            @if($stocks->isEmpty() )
            <p class="text-center">見つかりませんでした。</p>
            @else
                @include('layouts.itemloop')
            @endif            
        </div>
    </div>
</div>
@endsection
