@extends('layouts.app')
@section('content')

<div class="d-flex flex-row flex-wrap">
    <div class="container-fluid">
        <div class="mx-auto" style="max-width:1200px">
            @if($stock->status == 'delete')
            <p class="text-center">この投稿は削除されました。</p>
            @elseif($user_id==$stock->user_id)
            @section('title', " [編集] ".$stock->name)
            <p class="text-center"> {{$status ?? '' }}</p><br>
            <form id="" action="/stock/{{$stock->id}}/update" method="post" enctype="multipart/form-data">
                @csrf
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="table_subject" scope="row" style="width:%">データ</th>
                            <td class="table_content" style="width:%">
                                <div id="">
                                    <div id="stockPreview">
                                        @include('layouts.stockFilePreview')
                                    </div>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row" style="width:%">作品名：</th>
                            <td style="width:%">
                                <input type="text" id="name" name="stock_name"
                                    value="{{old('stock->name') ??   $stock->name}}" required="required"
                                    autocomplete="name" autofocus="autofocus" class="form-control">
                                @error('stock_name')
                                <div class=""><span class="invalid_message"><strong>{{ $message }}</strong></span>
                                </div>
                                @enderror
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">ジャンル：</th>
                            <td>
                                <div class="form-group">

                                    <select class="form-control" id="genreSelect" name="genre" readonly>
                                        <option value="{{$stock->genre}}">画像</option>
                                    </select>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">販売価格：</th>
                            <td>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1"></label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="fee">
                                        <option value="1500" @if($stock->fee ==1500) selected @endif>￥1,500</option>
                                        <option value="5000" @if($stock->fee==5000) selected @endif>￥5,000</option>
                                        <option value="10000" @if($stock->fee ==10000) selected @endif>￥10,000</option>
                                        <option value="20000" @if($stock->fee ==20000) selected @endif>￥20,000</option>
                                    </select>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">作品説明</th>
                            <td>
                                <textarea id="detail" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                    type="text" id="" name="detail" required="required">{{ $stock->detail }}</textarea>
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
                            <td><button id="" class="btn btn-outline-secondary btn-right" type="submit"
                                    id="">更新</button>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary btn-right-continue" data-toggle="modal"
                                    data-target="#modalcenter_{{$stock->id}}" >
                                    削除
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>


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
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <div class="returnblock">
                <a href="{{url('/stock/')}}/{{$stock->id}}">
                    <p class="text-right">戻る</p>
                </a>
        </div>
            @else
            この投稿を編集する権限がありません。
            @endif
            @endsection
        </div>
    </div>
</div
