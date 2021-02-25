<div class="input-group mb-3">
    <span class="genrebox">
        <select class="form-control" id="genre_select">
            <option>画像</option>
            <option>映像</option>
            <option>BGM</option>
        </select>
    </span>
    <input type="search" class="form-control" name="search" value="{{request('search')}}" placeholder="keyword"
        aria-label="" aria-describedby="button-addon2" id="search_keyword">
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit" id="search_button"><i
                class="fas fa-search"></i></button>
    </div>
</div>
