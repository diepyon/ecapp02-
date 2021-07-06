@extends('layouts.app')

@section('content')
<div class="container-fluid">
        <div class="mx-auto" style="max-width:1200px">

        @if(Auth::user()->role=='administrator')
               
               <p> {{ session('message') }}</p>
               <div class="card text-white bg-dark mb-3" id="userManage" style="">
                   <div class="card-header">ユーザー管理</div>
                   <div class="card-body">
                       <table class="table table-striped table-dark">
                           <thead>
                               <tr>
                                   <th scope="col">ID</th>
                                   <th scope="col">ユーザー名</th>
                                   <th scope="col">メールアドレス</th>
                                   <th scope="col">権限</th>
                                   <th scope="col">投稿数</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach ($users as $user)
                               <tr>
                                   <th scope="row">{{$user->id}}</th>
                                   <td>{{$user->name}}</td>
                                   <td>{{$user->email}}</td>

                                   <td>{{$user->role}}</td>
                                   <td>aaa</td>
                                   <td>

                                       <!-- Button trigger modal -->
                                       <button type="button" class="btn btn-secondary" data-toggle="modal"
                                           data-target="#editModal{{$user->id}}">
                                           編集
                                       </button>
                                       <!-- Modal -->
                                       <form id="" action="{{url('/account/edit')}} " method="post"
                                           enctype="multipart/form-data">
                                           @csrf
                                           <input type="hidden" value="{{$user->id}}" name="user_id">

                                           <div class="modal fade" id="editModal{{$user->id}}" tabindex="-1"
                                               role="dialog" aria-labelledby="editModal{{$user->id}}Title"
                                               aria-hidden="true">
                                               <div class="modal-dialog modal-dialog-centered" role="document">
                                                   <div class="modal-content">
                                                       <div class="modal-header">
                                                           <h5 class="modal-title" id="editModal{{$user->id}}Title">編集
                                                           </h5>
                                                           <button type="button" class="close" data-dismiss="modal"
                                                               aria-label="Close">
                                                               <span aria-hidden="true">&times;</span>
                                                           </button>
                                                       </div>


                                                       <div class="modal-body">
                                                           <table class="table">
                                                               <tbody>
                                                                   <tr>
                                                                       <th style="width:25%" scope="row"
                                                                           style="width:%">ID</th>
                                                                       <td style="width:%">{{ $user->id }}</td>
                                                                   </tr>
                                                                   <tr>
                                                                       <th scope="row">名前</th>
                                                                       <td>
                                                                           <input type="text" id="name"
                                                                               name="user_name"
                                                                               value="{{old('user_name') ??  $user->name}}"
                                                                               required="required" autocomplete="name"
                                                                               autofocus="autofocus"
                                                                               class="form-control">
                                                                           @error('user_name')
                                                                           <div class=""><span
                                                                                   class="invalid_message"><strong>{{ $message }}</strong></span>
                                                                           </div>
                                                                           @enderror
                                                                       </td>

                                                                   </tr>
                                                                   <tr>
                                                                       <th scope="row">Email</th>
                                                                       <td>
                                                                           <input id="email" type="email"
                                                                               class="form-control @error('email') is-invalid @enderror"
                                                                               name="email"
                                                                               value="{{old('email') ?? $user->email}}"
                                                                               required autocomplete="email">

                                                                           @error('email')
                                                                           <span class="invalid-feedback" role="alert">
                                                                               <strong>{{ $message }}</strong>
                                                                           </span>
                                                                           @enderror
                                                                       </td>

                                                                   </tr>
                                                                   <tr>
                                                                       <th scope="row">パスワード</th>
                                                                       <td>
                                                                           <input id="password" type="password"
                                                                               class="form-control @error('password') is-invalid @enderror"
                                                                               name="password" value="" autocomplete=""
                                                                               placeholder="変更する場合のみ入力">
                                                                       </td>
                                                                   </tr>
                                                                   <tr>
                                                                       <th scope="row">登録日</th>
                                                                       <td>{{$user->created_at}}</td>

                                                                   </tr>
                                                               </tbody>
                                                           </table>
                                                       </div>
                                                       <div class="modal-footer">

                                                           <button type="submit" class="btn btn-primary">更新</button>

                                                           <button type="button" class="btn btn-secondary"
                                                               data-dismiss="modal">キャンセル</button>
                                       </form>
                   </div>
               </div>
           </div>
       </div>


       <!-- Button trigger modal -->
       <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal{{$user->id}}">
           削除
       </button>
       <!-- Modal -->
       <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" role="dialog"
           aria-labelledby="deleteModal{{$user->id}}Title" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="deleteModal{{$user->id}}Title">確認
                       </h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>

                   <div class="modal-body">
                       @if($user->id == $user_id )
                       この画面から自分自身を削除することはできません。
                       @elseif($user->role == 'administrator' )
                       administrator権限ユーザーを削除することはできません。
                       @else
                       <p>ID:{{$user->id}}　{{$user->name}}<br></p>
                       このユーザーを削除しますか
                       @endif
                   </div>
                   <div class="modal-footer">
                       <form id="" action="/account/{{$user->id}}/delete" method="post">
                           @csrf
                           @if($user->role !== 'administrator' )
                           <button type="submit" class="btn btn-primary">削除</button>
                           @endif
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
       </td>
       </tr>
       @endforeach
       </tbody>
       </table>
   </div>
</div>
@endif

        </div>
</div>
    @endsection
