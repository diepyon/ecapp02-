<div class="input-group mb-3">
<form id="search_form" action="{{url('/search')}}">    
<span class="genrebox">
        <select class="form-control" id="genre_select" name="genre">
            <option value="image"@if(strstr($url = $_SERVER['REQUEST_URI'],'image')==true) selected @endif >画像</option>
            <option value="movie" @if(strstr($url = $_SERVER['REQUEST_URI'],'movie')==true) selected @endif>映像</option>
            <option value="bgm" @if(strstr($url = $_SERVER['REQUEST_URI'],'bgm')==true) selected @endif>BGM</option>
        </select>
    </span>
    <input type="search" class="form-control" name="key" value="{{$key ?? ''}}" placeholder="keyword"
        aria-label="" aria-describedby="button-addon2" id="search_keyword">
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit" id="search_button"><i
                class="fas fa-search"></i></button>
    </div>
</form>
</div>
