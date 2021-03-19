@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            @include('layouts.searchform')
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">商品一覧</h1>
            @include('layouts.itemloop')
        </div>
    </div>
</div>
<div class="text-center" style="width: 200px;margin: 20px auto;">{{$stocks->links()}}</div>
@endsection
