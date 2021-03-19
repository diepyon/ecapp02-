@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">

            <p class="text-center"> {{$messages ?? '' }}</p><br>

            <h1 class="text-center font-weight-bold" style="color:#555555;  font-size:1.2em; padding:24px 0px;">
                {{$aftername ?? Auth::user()->name}}さんのアカウント情報</h1>
            <form id="search_form" action="{{url('/mypage')}} " method="post">
                @csrf
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row" style="width:%">ユーザーID</th>
                            <td style="width:%">{{ Auth::user()->id }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">ユーザー名</th>
                            <td> <input type="text" id="name" name="name" value="{{$aftername ?? Auth::user()->name}}"
                                    required="required" autocomplete="name" autofocus="autofocus" class="form-control">
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">メールアドレス</th>
                            <td>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{$afteremail ?? Auth::user()->email}}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </td>
                            <td></td>
                        </tr>
                        <!--                         <tr>
                            <th scope="row">パスワード（変更しない時は空白）</th>
                            <td><input type="password" class="form-control" name="" value="" placeholder=""
                                    aria-label="" aria-describedby="button-addon2" id=""></td>
                            <td></td>
                        </tr> -->
                        <tr>
                            <th scope="row">アカウント登録日</th>
                            <td>{{Auth::user()->created_at->format('Y年m月d日') }}</td>
                            <td>
                            </td>
                        </tr>
                        <th scope="row"></th>
                        <td></td>
                        <td><button class="btn btn-outline-secondary" type="submit" id="">送信</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    @endsection
