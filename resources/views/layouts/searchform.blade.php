<div class="input-group mb-3">
    <form id="search_form" action="{{url('/search')}}">
        <?php if(empty($genre)){$genre = '';}
        //コントローラーに書きたいが全部のビューファイルに渡す必要が出てくるのでここに記載
        //genreが空だとエラーになるので対処 ?>
        <span class="genrebox">
            <select class="form-control" id="genre_select" name="genre">
                <option value="image" @if($genre =='image') selected @endif>画像</option>
                <option value="movie" @if($genre =='movie') selected @endif>映像</option>
                <option value="bgm"   @if($genre =='bgm') selected @endif>BGM</option>
            </select>
        </span>
        <input type="search" class="form-control" name="key" value="{{$key ?? ''}}" placeholder="keyword" aria-label=""
            aria-describedby="button-addon2" id="search_keyword">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" id="search_button"><i
                    class="fas fa-search"></i></button>
        </div>
    </form>
</div>
