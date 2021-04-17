@extends('layouts.app')
@section('content')

<div class="d-flex flex-row flex-wrap">
    <div class="mx-auto" style="max-width:1200px">

        @foreach($stocks as $stock)
        <p class="text-center"> {{$status ?? '' }}</p><br>
        <form id="search_form" action="/stock/{{$stock->id}}/edit/" method="get">
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
                        <td><button id="mypage_submit" class="btn btn-outline-secondary" type="submit" id="">編集</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>





        @endforeach

        @endsection

    </div>
</div>
