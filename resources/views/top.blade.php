@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 style=" text-align:center;">キャッチコピー</h1>
            @include('layouts.searchform')

            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="card" style="width: 100%;">
                            <svg class="bd-placeholder-img card-img-top" width="100%" height="180"
                                xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice"
                                focusable="false" role="img" aria-label="Placeholder: Image cap">
                                <title>Placeholder</title>
                                <rect fill="#868e96" width="100%" height="100%" /><text fill="#dee2e6" dy=".3em" x="50%"
                                    y="50%">Image cap</text>
                            </svg>
                            <div class="card-body">
                                <h5 class="card-title">画像</h5>
                                <p class="card-text">イカした画像素材を提供するぜ</p>
                                <a href="{{ url('/images')}}" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card" style="width: 100%;">
                            <svg class="bd-placeholder-img card-img-top" width="100%" height="180"
                                xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice"
                                focusable="false" role="img" aria-label="Placeholder: Image cap">
                                <title>Placeholder</title>
                                <rect fill="#868e96" width="100%" height="100%" /><text fill="#dee2e6" dy=".3em" x="50%"
                                    y="50%">Image cap</text>
                            </svg>
                            <div class="card-body">
                                <h5 class="card-title">映像</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card" style="width: 100%;">
                            <svg class="bd-placeholder-img card-img-top" width="100%" height="180"
                                xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice"
                                focusable="false" role="img" aria-label="Placeholder: Image cap">
                                <title>Placeholder</title>
                                <rect fill="#868e96" width="100%" height="100%" /><text fill="#dee2e6" dy=".3em" x="50%"
                                    y="50%">Image cap</text>
                            </svg>
                            <div class="card-body">
                                <h5 class="card-title">BGM</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
