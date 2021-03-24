@extends('layouts.app')
@section('content')

<div class="d-flex flex-row flex-wrap">
    <div class="mx-auto" style="max-width:1200px">



        <form method="post" action="{{ route('stocks.create') }}" enctype="multipart/form-data">
            @csrf
            <div class="form">
                <div class="form-title">

                    <div class="form-group">
                        <label for="exampleFormControlInput1">作品名</label>
                        @error('stock_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="txt" class="form-control" id="exampleFormControlInput1"
                            value="{{ old('stock_name') }}" placeholder="(例)富士山" name="stock_name">
                    </div>


                    <div class="form-group">
                        <label for="exampleFormControlFile1">ファイル</label>
                        <a href="/storage/upload_file.pdf">アップロードファイル</a>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="stock_file">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">ジャンル(ファイル拡張子から自動判別のほうがいいかも)</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="genre">
                            <option value="image">画像</option>
                            <option value="movie">映像</option>
                            <option value="bgm">BGM</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">販売価格</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="fee">
                            <option value="1500">￥1,500</option>
                            <option value="5000">￥5,000</option>
                            <option value="10000">￥10,000</option>
                            <option value="20000">￥20,000</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">商品説明</label>
                        @error('detail')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="detail"
                            value="{{ old('detail') }}"></textarea>
                    </div>

                    <div class="form-submit">

                        <button type="submit" class="btn btn-warning cart_button btn-lg btn-primary btn-lg btn-block"><i
                                class="fas fa-plus-square">投稿する</i></button>
                    </div>
                </div>
        </form>
        @endsection

    </div>
</div>
