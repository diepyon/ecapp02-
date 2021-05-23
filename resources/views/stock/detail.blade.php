@extends('layouts.app')
@section('content')
<div class="d-flex flex-row flex-wrap">
    <div class="mx-auto" style="max-width:1200px">
        @if($stock->status == 'delete')
        この投稿は削除されました。
        <br><br><br>
        @elseif($user_id==$stock->user_id or Auth::user()->role=='administrator'){{--投稿者または管理者なら--}}

        @section('title', $stock->name)
        <p class="text-center"> {{ session('message') }}{{$message ?? ''}}</p><br>
        <table class="table">
            <tbody>
                <tr>
                    <th class="table_subject" scope="row" style="width:%">データ</th>
                    <td class="table_content" style="width:%">
                        <div id="">
                            @include('layouts.stockFilePreview')

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
                        <form id="" action="/download/" method="post">
                            @csrf
                            <input type="hidden" name="stock_id" value="{{$stock->id }}">
                            <button id="" class="btn btn-warning cart_button btn-lg btn-right"
                                type="submit" id="">
                                <i class="fas fa-arrow-down">データダウンロード</i>
                            </button>
                        </form>

                        <form id="" action="/stock/{{$stock->id}}/edit/" method="get">
                            @csrf
                            <button id="" class="btn btn-outline-secondary btn-right" type="submit"
                                id="">編集</button>
                        </form>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-secondary btn-right" data-toggle="modal"
                            data-target="#modalcenter_{{$stock->id}}" id="my">
                            削除
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="modalcenter_{{$stock->id}}" tabindex="-1" role="dialog"
                            aria-labelledby="modalcenter_{{$stock->id}}Title" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalcenter_{{$stock->id}}Title">確認</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        削除しますか
                                    </div>
                                    <div class="modal-footer">
                                        <form id="" action="/stock/delete/" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                            <button type="submit" class="btn btn-primary">削除</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">キャンセル</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($stock->status=='publish')
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        @else
        この投稿を編集する権限がありません。
        @endif

        <div class="returnblock">
            @if($stock->status == 'publish')
                <a href="{{url('/product/')}}/{{$stock->id}}">
                    <p class="text-right">販売ページへ移動</p>
                </a>
            @endif
            <a href="{{url('/stock')}}">
                <p class="text-right">投稿一覧へ移動</p>
            </a>
        </div>
        @include('layouts.approval')
        @endsection
    </div>

</div>
</div>
