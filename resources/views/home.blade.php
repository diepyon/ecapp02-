@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 style=" text-align:center;">ホーム</h1>


            @if (session('flash_message'))
                <div class="flash_message bg-success text-center py-3 my-0">
                    {{ session('flash_message') }}
                </div>
            @endif

            <div class=”container”>
                <div class="card">
                    <div class="card-header">メニュー（PCは左寄せにしたい</div>
                    <div class="card-body">
                        <a class="dropdown-item" href="{{ url('/stock') }}">
                            <i class="fas fa-boxes"></i>投稿作品
                        </a>
                        審査中<br>
                        公開中<br>
                        非公開<br>
                        審査落ち<br>
                        <br>
                        ・収益一覧<br><br>
                        <a class="dropdown-item" href="/account">
                            アカウント
                        </a>
                    </div>
                </div>

                @if(Auth::user()->role=='administrator')
                <div class="card text-white bg-dark mb-3">
                    <div class="card-header">審査依頼</div>
                    <div class="card-body">
                        投稿者があなたの審査を待っている作品一覧
                        @if($inspection_items->isNotEmpty())
                        <div class='text-nowrap table-responsive'>
                            <table class="table table-striped table-dark table-fixed">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">作品名</th>
                                        <th scope="col">投稿者</th>
                                        <th scope="col">投稿日</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inspection_items as $inspection_item)
                                    <tr>
                                        <th scope="row">{{$inspection_item->id}}</th>
                                        <td><a href="{{ url('/stock').'/'.$inspection_item->id}}"
                                                class="">{{$inspection_item->name}}</a></td>
                                        <td>{{$users->where('id',$inspection_item->user_id)->first()->name}}</td>
                                        <td>{{$inspection_item->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p>未承認の作品はありません。</p>
                        @endif
                    </div>
                </div>
                @endif

                <div class="card text-white bg-dark mb-3" style="">
                    <div class="card-header">ユーザー管理</div>
                    <div class="card-body">
                        <table class="table table-striped table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">ユーザー名</th>
                                    <th scope="col">メールアドレス</th>
                                    <th scope="col">パスワード</th>
                                    <th scope="col">権限</th>
                                    <th scope="col">投稿数</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{$user->id}}</th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td></td>
                                    <td>{{$user->role}}</td>
                                    <td>aaa</td>
                                    <td>更新<br>削除</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="card">
                            <div class="card-header">ダッシュボード</div>
                            <div class="card-body">
                                なんかかっこいいグラフ chart.js<br>
                                今月の売り上げ等を記載
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header">作品種別</div>
                            <div class="card-body">
                                円グラフ
                                <p>picture:{{$percentage['image']}}%</p>
                                <p>sound:{{$percentage['sound']}}%</p>
                                <p>movie:{{$percentage['movie']}}%<p>
                                        <br>
                                        <p>作品を投稿する</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">お知らせ</div>
                        <div class="card-body">
                            ここにお知らせ
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header"> {{Auth::user()->name}}さんの作品が売れた履歴（直近30件）</div>
                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif

                            @if($order_items->isNotEmpty())
                            スマホ作品名はみ出すから文字数をスマホの場合だけ調整したい<br>
                            あと日時がはみ出す
                            <div class='text-nowrap table-responsive'>
                                <table class="table table-fixed">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">作品名</th>
                                            <th scope="col">販売時の金額</th>
                                            <th scope="col">売れた日時</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order_items as $order_item)
                                        <tr>
                                            <th scope="row">{{$order_item->stock_id}}</th>
                                            <td>{{$order_item->name}}</td>
                                            <td>￥{{number_format($order_item->fee_at_that_time)}}</td>
                                            <td>{{$order_item->created_at}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <p>まだ {{Auth::user()->name}}さんの作品は売れていません。</p>
                            @endif
                            <p>もっと見る(未リンク)</p>
                            <p>収益一覧</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
