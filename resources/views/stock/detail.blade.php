@extends('layouts.app')
@section('content')

<div class="d-flex flex-row flex-wrap">
<div class="mx-auto" style="max-width:1200px">

@foreach($stocks as $stock)
<p>タイトル：{{ $stock->name }}</p>
<p>投稿者：{{ $stock->user_id }}</p>
<p>ジャンル：{{ $stock->genre }}</p>
<p>販売価格：￥{{ $stock->fee }}</p>
<p>投稿日：{{ $stock->created_at }}</p>
<p>編集日：{{ $stock->updated_at }}</p>
<p>作品説明：{{ $stock->detail }}</p>

@endforeach

@endsection

</div>
</div>