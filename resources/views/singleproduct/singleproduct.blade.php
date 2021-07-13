@extends('layouts.app')

@section('content')
<div class="container-fluid">
 
    <div id="app">
       @{{msg}}
        <div class="mx-auto" style="max-width:1200px">
            @if($stock_record->status == 'delete')
                <p class="text-center">この投稿は削除されました。</p>
                @else
                @section('title', $stock_record->name)
                <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">
                    {{$stock_record->name}}</h1>
                <p class="text-center">{{ session('message') ?? '' }}</p>
                    @if($stock_record->genre=='image')
                        @include('singleproduct.singleproductImage')

                    @elseif($stock_record->genre=='movie')

                        @include('singleproduct.singleproductMovie')

                    @elseif($stock_record->genre=='audio')

                        @include('singleproduct.singleproductAudio')
                    @endif                                        
            @endif
        </div>
    </div>

    
</div>
@endsection


   <script>
       new Vue({
           el: "#app",
           data: {
               msg: "Welcome"
           },
           methods: {
               sayHello() {
                   this.msg = "Hello!"
               }
           },
           mounted() {
               //表示後にやりたいことはここに書ける
               alert('hogehoge');
           }
       })
   </script>
