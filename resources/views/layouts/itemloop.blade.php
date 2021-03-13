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
                <div class="stock_thumbnail">
                    <a href="{{url('/product/')}}/{{$stock->id}}">
                        <img src="/image/{{$stock->path}}" alt="" class="incart">
                    </a>

                    @if(in_array($stock->id, $favorite_list,true))
                    <form action="/favoritedelete" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <div class="favorite_icon mouseon_icon added_favorite">
                            <span id="favorite_expert{{$loop->iteration}}"　class="icon_expert">お気に入りに登録済み </span>
                            <span id="favorite_trigger{{$loop->iteration}}"　class="trigger"><button class=""><i class="fas fa-heart"></i></button></span>
                        </div>
                    </form>
                    @else
                    <form action="favorite" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <div class="favorite_icon mouseon_icon add_favorite">
                            <span id="favorite_expert{{$loop->iteration}}"　class="icon_expert">未登録 </span>
                            <span id="favorite_trigger{{$loop->iteration}}"　class="trigger"><button class=""><i class="far fa-heart"></i></button></span>
                        </div>
                    </form>               
                    @endif
                    <div class="genre_icon">
                        <i class="fas fa-image" aria-hidden="true"></i>
                    </div>
                    <form action="mycart" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <div class="download_icon mouseon_icon">
                            <button><i class="fas fa-cart-arrow-down"></i></button>
                        </div>
                    </form>
                </div>
                <br>
            </div>

        </div>
        @endforeach
    </div>
    <div class="text-center" style="width: 200px;margin: 20px auto;">
        {{$stocks->links()}}
    </div>
</div>


<script>
for (let step = 1; step <= 6; step++) {

document.addEventListener('DOMContentLoaded', function() {
let favorite_trigger = document.getElementById('favorite_trigger'+step)
let favorite_expert = document.getElementById('favorite_expert'+step)

//マウスポインターが乗ったタイミングで背景色を変更
favorite_trigger.addEventListener('mouseover', function() {
    favorite_expert.style.opacity = '1.0'
}, false)

//マウスポインターが外れたタイミングで背景色を戻す
favorite_trigger.addEventListener('mouseout', function() {
    favorite_expert.style.opacity = '0'
}, false)
}, false)
}
</script>
