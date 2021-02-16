@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">

            <div class="input-group mb-3">
                <span class="genrebox">
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>画像</option>
                        <option>映像</option>
                        <option>BGM</option>
                    </select>
                </span>
                <input type="text" class="form-control" placeholder="keyword" aria-label=""
                    aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                            class="fas fa-search"></i></button>
                </div>
            </div>

            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">商品詳細</h1>

        </div>
    </div>
</div>
@endsection
