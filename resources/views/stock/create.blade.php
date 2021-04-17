@extends('layouts.app')
@section('content')

<div class="d-flex flex-row flex-wrap">
    <div class="mx-auto" style="max-width:1200px">
        <form method="post" action="/stock" enctype="multipart/form-data">
            @csrf
            <div class="form">
                <div class="form-title">

                    <div class="form-group">
                        <label for="exampleFormControlInput1">作品名</label>
                        <input type="txt" class="form-control" id="exampleFormControlInput1"
                            value="{{ old('stock_name') }}" placeholder="(例)富士山" name="stock_name">
                        @error('stock_name')
                        <div><span class="invalid_message"><strong>{{ $message }}</strong></span></div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <span id="file_input_area">
                            <input type="file" class="form-control-file " id="myImage" name="stock_file"
                                onChange="stockPreView(event)" accept=".jpg,.jpeg,.png,.gif,.mp3,.wav,.m4a,.mp4">

                            <span id="mimemessage">
                                @error('stock_file')
                                <div class=""><span class="invalid_message"><strong>{{ $message }}</strong></span></div>
                                @enderror
                            </span>
                            <input type="button" id="btn1" value="クリア" onclick="clear_file();">
                        </span>

                        <div id="stockPreview">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">ジャンル</label>
                        <select class="form-control" id="genreSelect" name="genre" readonly>

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
                        <div><span class="invalid_message"><strong>{{ $message }}</strong></span></div>
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
