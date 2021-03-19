<?php

namespace App\Http\Controllers;

//use App\Models\Stock; //追加
//use App\Models\Cart; //追加
//use App\Models\Favorite; //追加
//use App\Models\Orderhistory; //追加
use App\User; //追加
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use DB;
//use Illuminate\Support\Facades\Mail; //メール
//use App\Mail\Thanks;//メール

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function myPage() 
    {
        return view('mypage');
    }
    public function myPageUpdate(Request $request,User $user) 
    {
        $user =Auth::user();
        $aftername = $request->input('name');
        $afteremail = $request->input('email');

        $user_record = User::where('id', $user->id);

        $user_record->update(['name' => $request->name]);
        $user_record->update(['email' => $request->email]);          
        return view('mypage')->with('aftername', $aftername)->with('afteremail', $afteremail);
    }
}
