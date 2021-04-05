@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <p class="text-center"> {{$status ?? '' }}</p><br>
            <h1 class="text-center font-weight-bold" style="color:#555555;  font-size:1.2em; padding:24px 0px;">
                {{$aftername ?? Auth::user()->name}}さんのアカウント情報</h1>

            <form id="search_form" action="{{url('/mypage/update')}} " method="post" enctype="multipart/form-data">
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
                                    <img src="{{asset('storage/user_icon/')}}/{{ Auth::user()->user_icon }}?<?= uniqid() ?>"
                                        id="previewImage">
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
                            <th scope="row">パスワード(変更時のみ入力)</th>
                            <td>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="" autocomplete="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">パスワード確認用(変更時のみ入力)</th>
                            <td>
                                <input id="password-confirm" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password_confirmation" value="" autocomplete="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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

                            <td><button id="mypage_submit" class="btn btn-outline-secondary" type="submit"
                                    id="">更新</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    @endsection
