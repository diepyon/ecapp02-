@extends('layouts.app')
@section('content')

<div class="d-flex flex-row flex-wrap">
    <div class="mx-auto" style="max-width:1200px">
        @if($stock->status == 'delete')
        この投稿は削除されました。
        @elseif($user_id==$stock->user_id)
        
        @section('title', $stock->name)
        
        <p class="text-center">   {{ session('message') }}{{$message ?? ''}}</p><br>
            <table class="table">
                <tbody>
                    <tr>
                        <th class="table_subject" scope="row" style="width:%">データ</th>
                        <td class="table_content" style="width:%">
                            <div id="">
                                <img src="/storage/stock_sample/{{$stock->path}}" alt="" class="ditail_image">
                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row" style="width:%">作品名：</th>
                        <td style="width:%">{{ $stock->name }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">ジャンル：</th>
                        <td>
                            {{ $stock->genre }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">販売価格：</th>
                        <td>
                            ￥{{ number_format($stock->fee) }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">作品説明</th>
                        <td>
                            {{ $stock->detail }}
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <th scope="row">投稿日</th>
                        <td>{{ $stock->created_at }}</td>
                        <td>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">編集日</th>
                        <td>{{ $stock->updated_at }}</td>
                        <td>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"></th>
                        <td>
                            <form id="" action="/stock/{{$stock->id}}/edit/" method="get">
                            @csrf
                                <button id="" class="btn btn-outline-secondary mypage_submit" type="submit" id="">編集</button>
                            </form>

                            <form id="" action="/stock/delete/" method="post">
                            @csrf
                            <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                <button id="" class="btn btn-outline-secondary mypage_submit" type="submit" id="">削除</button>
                            </form>
                            @if($stock->status=='publish')
                            <a href="{{url('/product/')}}/{{$stock->id}}">
                                <p class="text-right">販売ページへ移動</p>
                            </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        
        @else
        この投稿を編集する権限がありません。
        @endif
        @endsection

    </div>
</div>
