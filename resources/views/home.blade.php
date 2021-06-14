@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 style=" text-align:center;">ホーム</h1>

            </nav>



            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <p> {{ session('message') }}削除しましたメッセージはjavascriptにしてユーザー管理にジャンプさせたほうがいい（＃でスライドジャンプ）</p>

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

                @if(Auth::user()->role=='administrator')
                <div class="card text-white bg-dark mb-3" id="userManage" style="">
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

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{$user->id}}</th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>

                                    <td>{{$user->role}}</td>
                                    <td>aaa</td>
                                    <td>

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-secondary" data-toggle="modal"
                                            data-target="#editModal{{$user->id}}">
                                            編集
                                        </button>
                                        <!-- Modal -->
                                        <form id="search_form" action="{{url('/account/edit')}} " method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{$user->id}}" name="user_id">

                                            <div class="modal fade" id="editModal{{$user->id}}" tabindex="-1"
                                                role="dialog" aria-labelledby="editModal{{$user->id}}Title"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModal{{$user->id}}Title">編集
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>


                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <th style="width:25%" scope="row"
                                                                            style="width:%">ID</th>
                                                                        <td style="width:%">{{ $user->id }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">名前</th>
                                                                        <td>
                                                                            <input type="text" id="name"
                                                                                name="user_name"
                                                                                value="{{old('user_name') ??  $user->name}}"
                                                                                required="required" autocomplete="name"
                                                                                autofocus="autofocus"
                                                                                class="form-control">
                                                                            @error('user_name')
                                                                            <div class=""><span
                                                                                    class="invalid_message"><strong>{{ $message }}</strong></span>
                                                                            </div>
                                                                            @enderror
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Email</th>
                                                                        <td>
                                                                            <input id="email" type="email"
                                                                                class="form-control @error('email') is-invalid @enderror"
                                                                                name="email"
                                                                                value="{{old('email') ?? $user->email}}"
                                                                                required autocomplete="email">

                                                                            @error('email')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">パスワード</th>
                                                                        <td>
                                                                            <input id="password" type="password"
                                                                                class="form-control @error('password') is-invalid @enderror"
                                                                                name="password" value="" autocomplete=""
                                                                                placeholder="変更する場合のみ入力">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">登録日</th>
                                                                        <td>{{$user->created_at}}</td>

                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">

                                                            <button type="submit" class="btn btn-primary">更新</button>

                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">キャンセル</button>
                                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Button trigger modal -->
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal{{$user->id}}">
            削除
        </button>
        <!-- Modal -->
        <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModal{{$user->id}}Title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal{{$user->id}}Title">確認
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        @if($user->id == $user_id )
                        この画面から自分自身を削除することはできません。
                        @elseif($user->role == 'administrator' )
                        administrator権限ユーザーを削除することはできません。
                        @else
                        <p>ID:{{$user->id}}　{{$user->name}}<br></p>
                        このユーザーを削除しますか
                        @endif
                    </div>
                    <div class="modal-footer">
                        <form id="" action="/account/{{$user->id}}/delete" method="post">
                            @csrf
                            @if($user->role !== 'administrator' )
                            <button type="submit" class="btn btn-primary">削除</button>
                            @endif
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </td>
        </tr>
        @endforeach
        </tbody>
        </table>
    </div>
</div>
@endif



<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header">ダッシュボード</div>
            <div class="card-body">
                なんかかっこいいグラフ chart.js<br>
                あなたの今月の売り上げ<br>
                ￥{{$toalSalesMonth}}



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
                        <p>公開済みの作品数：{{$totalPostsCount}}件</p>
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
