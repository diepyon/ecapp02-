@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 class="text-center font-weight-bold" style="color:#555555;  font-size:1.2em; padding:24px 0px;">
                {{$aftername ?? Auth::user()->name}}さんのアカウント情報</h1>
            
            <p class="text-center"> {{$status ?? '' }}</p><br>

            <form id="search_form" action="{{url('/mypage/edit')}} " method="get" >
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="table_subject" scope="row" style="width:%">アイコン</th>
                            <td class="table_content" style="width:%">
                                <div id="preview"> 
                                    @if( Auth::user()->user_icon=="")
                                    <img
                                        src="{{asset('storage/user_icon/')}}/default_icon.jpg"
                                        id="previewImage"
                                    >
                                    @else
                                    <img
                                        src="{{asset('storage/user_icon/')}}/{{ Auth::user()->user_icon }}?<?= uniqid() ?>"
                                        id="previewImage"
                                    >
                                    @endif
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" style="width:%">ユーザーID</th>
                            <td style="width:%">{{ Auth::user()->id }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">ユーザー名</th>
                            <td>
                            {{$aftername ?? Auth::user()->name}}
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">メールアドレス</th>
                            <td>
                            {{$afteremail ?? Auth::user()->email}}
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">パスワード</th>
                            <td>
                                設定済み
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
                        <td><button id="mypage_submit" class="btn btn-outline-secondary" type="submit" id="">編集</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    @endsection
