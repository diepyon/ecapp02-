@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="">
       <div class="mx-auto" style="max-width:1200px">
            <h1 style=" text-align:center;">画像を検索</h1>
            <div class="input-group mb-3">
                <span class="genrebox">
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>画像</option>
                        <option>映像</option>
                        <option>BGM</option>
                    </select>
                    </span>
                    <input type="text" class="form-control" placeholder="keyword" aria-label="" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                    </div>    
                </div>

                 @foreach($stocks as $stock)
                      ジャンル：{{$stock->genre}} <br>
                      {{$stock->name}} <br>
                      {{$stock->fee}}円<br>
                      <img src="/image/{{$stock->imgpath}}" alt="" class="incart" >
                      <br>
                      {{$stock->detail}} <br>
                      {{$stock->path}} <br>
                      ------------------------<br>
                 @endforeach
                
        </div>     
   </div>
</div>
@endsection