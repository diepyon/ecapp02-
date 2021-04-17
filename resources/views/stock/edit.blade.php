@extends('layouts.app')
@section('content')

<div class="d-flex flex-row flex-wrap">
    <div class="mx-auto" style="max-width:1200px">

        @foreach($stocks as $stock)
        <p class="text-center"> {{$status ?? '' }}</p><br> 
        <form id="search_form" action="/stock/{{$stock->id}}/update" method="post"  enctype="multipart/form-data">
        @csrf
            <table class="table">
                <tbody>
                    <tr>
                        <th class="table_subject" scope="row" style="width:%">データ</th>
                        <td class="table_content" style="width:%">
                            <div id="">

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
                         <img src="/storage/stock_sample/{{$stock->path}}" alt="" class="ditail_image" id="previewImage">
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
                            {{ $stock->genre }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">販売価格：</th>
                        <td>
                        <div class="form-group">
                        <label for="exampleFormControlSelect1"></label>
                        <select class="form-control" id="exampleFormControlSelect1" name="fee">
                            <option value="1500"  @if($fee ==1500) selected @endif>￥1,500</option>
                            <option value="5000" @if($fee ==5000) selected @endif>￥5,000</option>
                            <option value="10000" @if($fee ==10000) selected @endif>￥10,000</option>
                            <option value="20000" @if($fee ==20000) selected @endif>￥20,000</option>
                        </select>
                    </div>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">作品説明</th>
                        <td>
                            <textarea id="detail" class="form-control" id="exampleFormControlTextarea1" rows="3"  type="text" id="" name="detail" required="required">{{ $stock->detail }}</textarea>                     
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
                        <td><button id="mypage_submit" class="btn btn-outline-secondary" type="submit" id="">更新</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        @endforeach
        @endsection

    </div>
</div>
