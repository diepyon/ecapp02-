<div class="row">
    <div class="col-sm-8">
    ここにロゴ付きのサンプル動画
    </div>
    <div class="col-sm-4" id="single_form">

        <div id="stock_info">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">{{$width}}x{{$height}}px</li>
                <li class="list-group-item">{{$mime}}</li>
                <li class="list-group-item">{{$filesize}}</li>
                <li class="list-group-item">{{$aspect}}</li>
                <li class="list-group-item">￥{{ number_format($stock_record->fee)}}</li>
            </ul>
        </div>

        @if(in_array($stock_record->id, $favorite_data['favorite_list'],true))
        <form style="display:inline-block;" action="/favoritedelete" method="post">
            @csrf
            <input type="hidden" name="stock_id" value="{{ $stock_record->id }}">
            <button class="btn btn-outline-secondary"><i class="fas fa-heart"></i>お気に入りから削除</button>
        </form>
        @else
        <form style="display:inline-block;" action="/favorite" method="post">
            @csrf
            <input type="hidden" name="stock_id" value="{{ $stock_record->id }}">
            <button class="btn btn-outline-secondary"><i class="far fa-heart"></i>お気に入りに保存</button>
        </form>
        @endif

        <a class="btn btn-outline-secondary" href="{{ url('/storage/stock_download_sample/')}}/{{$stock_record->path}}"
            role="button" download><i class="fas fa-arrow-down"></i>サンプルダウンロード</a>

        @if(in_array($stock_record->id, $cart_data['cart_list'],true))
        <form action="/cartdelete" method="post">
            @csrf
            <input type="hidden" name="stock_id" value="{{ $stock_record->id }}">
            <button class="btn btn-warning cart_button btn-lg btn-primary btn-lg btn-block"><i
                    class="fas fa-cart-arrow-down">カートから削除</i></button>
        </form>
        @elseif(in_array($stock_record->id, $orderhistory_data['orderhistory_list'],true))

        <form id="search_form" action="/download/" method="post">
            @csrf
            <input type="hidden" name="stock_id" value="{{$stock_record->id }}">
            <button id="" class="btn btn-warning cart_button btn-lg btn-primary btn-lg btn-block" type="submit" id="">
                <i class="fas fa-arrow-down">データダウンロード</i>
            </button>
        </form>

        @else
        <form action="/mycart" method="post">
            @csrf
            <input type="hidden" name="stock_id" value="{{ $stock_record->id }}">
            <button class="btn btn-warning cart_button btn-lg btn-primary btn-lg btn-block"><i
                    class="fas fa-cart-arrow-down">カートに追加</i></button>
        </form>

        @endif

        <div id="author">
            @if($user->user_icon)
            <img src="{{asset('storage/user_icon/')}}/{{ $user->user_icon }}" id="previewImage">
            @else
            <img src="{{asset('storage/user_icon/default_icon.jpg')}}" id="previewImage">
            @endif
            投稿者　{{ $user->name }}
        </div>
    </div>
</div>
