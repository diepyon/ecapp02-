@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <p class="text-center"> {{$status ?? '' }}</p><br>
            <h1 class="text-center font-weight-bold" style="color:#555555;  font-size:1.2em; padding:24px 0px;">
                {{$aftername ?? Auth::user()->name}}さんのアカウント情報</h1>

            <form id="" action="{{url('/account/update')}} " method="post" enctype="multipart/form-data">
                @csrf
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="table_subject" scope="row" style="width:%">アイコン</th>
                            <td class="table_content">

                                <span id="file_input_area">
                                    <input type="file" class="form-control-file " id="myImage" name="profile_file"
                                        onChange="imgPreView(event)" accept=".jpg,.jpeg,.png,.gif">

                                    <span id="mimemessage">
                                        @error('profile_file')
                                        <div class=""><span
                                                class="invalid_message"><strong>{{ $message }}</strong></span></div>
                                        @enderror
                                    </span>

                                    <input type="button" id="btn1" value="クリア" onclick="clear_file();">
                                </span>

                                <div id="preview">
                                    @if( Auth::user()->user_icon=="")
                                    <img src="{{asset('storage/user_icon/')}}/default_icon.jpg" id="previewImage">
                                    @else
                                    <img src="{{asset('storage/user_icon/')}}/{{ Auth::user()->user_icon }}?<?= uniqid() ?>"
                                        id="previewImage">
                                    @endif
                                </div>
                            </td>
                            <td class="table_other"></td>
                        </tr>
                        <tr>
                            <th scope="row" style="width:%">ユーザーID</th>
                            <td style="width:%">{{ Auth::user()->id }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">ユーザー名</th>
                            <td>
                                <input type="text" id="name" name="user_name"
                                    value="{{old('user_name') ??  Auth::user()->name}}" required="required"
                                    autocomplete="name" autofocus="autofocus" class="form-control">
                                @error('user_name')
                                <div class=""><span class="invalid_message"><strong>{{ $message }}</strong></span>
                                </div>
                                @enderror
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">メールアドレス</th>
                            <td>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{old('email') ?? Auth::user()->email}}" required
                                    autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">パスワード</th>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                                    data-target="#exampleModalCenter">
                                    パスワード変更
                                </button>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">アカウント登録日</th>
                            <td>{{Auth::user()->created_at->format('Y年m月d日') }}</td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>

                            <td><button id="" class="btn btn-outline-secondary btn-right" type="submit"
                                    id="">更新</button>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary  btn-right-continue" data-toggle="modal"
                                    data-target="#withdrawalModal">
                                    退会
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <div class="returnblock">
                <a href="{{url('/account/')}}/">
                    <p class="text-right">戻る</p>
                </a>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <form id="" action="/account/passwordupdate" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">パスワード変更</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                新しいパスワードを入力してください。
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="" autocomplete="password" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <br>
                                確認のためもう1度入力してください。
                                <input id="password-confirm" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password_confirmation" value="" autocomplete="password" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                            <div class="modal-footer">
                                @csrf
                                <input type="hidden" name="stock_id" value="">
                                <button type="submit" class="btn btn-primary">変更</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="withdrawalModal" tabindex="-1" role="dialog" aria-labelledby="withdrawalModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="withdrawalModalTitle">確認</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{url('/withdrawal')}} " method="post">
                        @csrf
                        <div class="modal-body">
                            <ul>
                                <li>購入済み作品のダウンロードができなくなります</li>
                                <li>投稿済み作品は全て削除されます</li>
                                <li>まだ受け取っていない収益を受け取れなくなります</li>
                            </ul>
                            <p>上記に確認の上、退会する場合はパスワードを入力してください</p>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" value=""
                                autocomplete="password" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">退会</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
