<?php

namespace App\Http\Controllers;

//use App\Models\Stock; //追加
//use App\Models\Cart; //追加
//use App\Models\Favorite; //追加
//use App\Models\Orderhistory; //追加
use App\User; //追加
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


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
    $file=$request->file('profile_file')->getClientOriginalName();
    //$filename = pathinfo($file, PATHINFO_FILENAME);//ファイル名のみ
    $extension = pathinfo($file, PATHINFO_EXTENSION);//拡張子のみ
    $request->file('profile_file')->storeAs('public/user_icon',$user->id.'.'.$extension);//拡張子いる
    $filepath=$user->id.'.'.$extension;//これをカラムに登録

    $request->validate([
    'user_name' => 'required|max:15',
    'email' => ['required',Rule::unique('users')->ignore($user->id)],
    'profile_file'=>'mimes:jpg,png',
    ]);        
        $aftername = $request->input('user_name');
        $afteremail = $request->input('email');
        $password = Hash::make($request->input('password'));
        $user_record = User::where('id', $user->id);
        $user_record->update(['name' => $request->user_name]);
        $user_record->update(['email' => $request->email]); 
        $user_record->update(['user_icon' => $filepath]); 

        if ($request->input('password')==="") {
            $user_record->update(['password' => $request->password]);
        }
        return view('mypage')->with('aftername', $aftername)->with('afteremail', $afteremail);
    }
}
