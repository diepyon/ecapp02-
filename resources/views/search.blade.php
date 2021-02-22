<h1>検索結果</h1>


      <li>
      @foreach ($knowledge  as $list)
        <a href="/framework/detail?id={{ $list->name}}">
          {{ $list->name }}          
        </a>
      @endforeach
      </li>