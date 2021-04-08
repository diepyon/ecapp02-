<p class="text-center">{{ session('message') ?? '' }}</p>

<div class="">
    <div class="d-flex flex-row flex-wrap">
        @foreach($stocks as $stock)
        <div class="col-xs-6 col-sm-4 col-md-4 img_box ">
            <div class="mycart_box">
                {{$loop->iteration}}回目<br>
                id:{{$stock->id}}<br>
                ジャンル：{{$stock->genre}} <br>
                {{$stock->fee}}円<br>
                @if(in_array($stock->id, $orderhistory_data['orderhistory_list'],true))

                <div class="stock_thumbnail">
                    <a href="{{url('/product/')}}/{{$stock->id}}">
                        <img src="/storage/stock_thumbnail/{{$stock->path}}" alt="" class="incart purchased">
                    </a>

                    <div class="purchased_txt">
                        購入済み
                    </div>
                    <div class="genre_icon">
                        <i class="fas fa-image" aria-hidden="true"></i>
                    </div>
                </div>
                @else
                <div class="stock_thumbnail">
                    <a href="{{url('/product/')}}/{{$stock->id}}">
                        <img src="/storage/stock_thumbnail/{{$stock->path}}" alt="" class="incart not_purchased">
                    </a>
                    @if(in_array($stock->id, $favorite_data['favorite_list'],true))
                    <form action="/favoritedelete" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <div class="favorite_icon mouseon_icon added_favorite">
                            <span id="favorite_expert{{$loop->iteration}}" 　class="icon_expert">登録済み</span>
                            <span id="favorite_trigger{{$loop->iteration}}" 　class="trigger"><button class=""><i
                                        class="fas fa-heart"></i></button></span>
                        </div>
                    </form>
                    @else
                    <form action="favorite" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <div class="favorite_icon mouseon_icon add_favorite">
                            <span id="favorite_expert{{$loop->iteration}}" 　class="icon_expert">お気に入りに追加</span>
                            <span id="favorite_trigger{{$loop->iteration}}" 　class="trigger"><button class=""><i
                                        class="far fa-heart"></i></button></span>
                        </div>
                    </form>
                    @endif
                    <div class="genre_icon">
                        <i class="fas fa-image" aria-hidden="true"></i>
                    </div>

                    @if(in_array($stock->id, $cart_data['cart_list'],true))
                    <form action="mycart" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <div class="download_icon mouseon_icon ">
                            <span id="cart_expert{{$loop->iteration}}" 　class="icon_expert">カートに追加済み</span>
                            <span id="cart_trigger{{$loop->iteration}}" 　class="trigger"><button><i
                                        class="fas fa-cart-arrow-down"></i></button></span>
                        </div>
                    </form>
                    @else
                    <form action="mycart" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <div class="download_icon mouseon_icon ">
                            <span id="cart_expert{{$loop->iteration}}" 　class="icon_expert">カートに追加</span>
                            <span id="cart_trigger{{$loop->iteration}}" 　class="trigger"><button><i
                                        class="fas fa-cart-arrow-down"></i></button></span>
                        </div>
                    </form>
                    @endif
                </div>
                @endif

                <br>
            </div>
        </div>
        @endforeach
    </div>

</div>
