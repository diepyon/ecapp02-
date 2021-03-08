<p class="text-center">{{ session('message') ?? '' }}</p>
<div class="">
    <div class="d-flex flex-row flex-wrap">
        @foreach($stocks as $stock)
        <div class="col-xs-6 col-sm-4 col-md-4 img_box ">
            <div class="mycart_box">
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
                            <span class="expert">お気に入りに登録済み </span>
                            <span class="trigger"><button class=""><i class="fas fa-heart"></i></button></span>
                        </div>
                    </form>
                    @else
                    <form action="favorite" method="post">
                        @csrf
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <div class="favorite_icon mouseon_icon">
                        <span class="expert">お気に入りに未登録 </span>
                            <span class="trigger"><button class=""><i class="far fa-heart"></i></button></span>
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


<div id="favorite_expert1">1</div>
<div id="favoriteexpert2">2</div>
<div id="favoriteexpert3">3</div>
<div id="favoriteexpert4">4</div>
<div id="favoriteexpert5">5</div>
<div id="favoriteexpert6">6</div>

<script>
for (let step = 1; step < 6; step++) {
//1-9
}

document.addEventListener('DOMContentLoaded', function() {
 let favorite_expert01 = document.getElementById('favorite_expert01')

 //マウスポインターが乗ったタイミングで背景色を変更
 favorite_expert01.addEventListener('mouseover', function() {
  this.style.backgroundColor = 'Yellow'
 }, false)

 //マウスポインターが外れたタイミングで背景色を戻す
 favorite_expert01.addEventListener('mouseout', function() {
  this.style.backgroundColor = ''
 }, false)
}, false)
</script>
