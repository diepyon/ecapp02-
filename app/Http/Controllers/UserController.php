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
use \InterventionImage;//画像リサイズライブラリ

//use Illuminate\Support\Facades\Mail; //メール
//use App\Mail\Thanks;//メール

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function myPage()
    {
        return view('mypage');
    }

    public function myPageEdit()
    {
        return view('mypage_edit');
    }
    public function myPageUpdate(Request $request, User $user)
    {
        $user =Auth::user();

        $request->validate([
    'user_name' => 'required|max:15',
    'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($user->id)],
    'profile_file'=>'mimes:jpg,png',
    'password' => 'confirmed',
    ]);
        $aftername = $request->input('user_name');
        $afteremail = $request->input('email');

        $password = Hash::make($request->input('password'));
        $user_record = User::where('id', $user->id);
        $user_record->update(['name' => $request->user_name]);
        $user_record->update(['email' => $request->email]);
       
        if ($request->file('profile_file')=="") {//変更があった場合のみアイコン更新（アップロードした画像を表示させておいて、クリアしたらデフォルトに戻すとかでもいいかも）
            $file="";
        } else {
            $file=$request->file('profile_file')->getClientOriginalName();
            //$filename = pathinfo($file, PATHINFO_FILENAME);//ファイル名のみ
            $extension = pathinfo($file, PATHINFO_EXTENSION);//拡張子のみ
            $fileinfo = $request->file('profile_file');
            $save_path = storage_path('app/public/user_icon/'.$user->id.'.'.$extension);

            InterventionImage::make($fileinfo)
            ->resize(500, 500, function ($constraint) {//縦横比を維持しながら圧縮
                $constraint->aspectRatio();
            }
            )->save($save_path,100);//100%の品質で保存

            $filepath = $user->id.'.'.$extension;
            $user_record->update(['user_icon' => $filepath]);
        }

        if ($request->input('password')!="") {//入力があった場合のみパスワード変更
            $user_record->update(['password' => $password]);
        }

        $status = "更新しました";

        return view('mypage')->with('aftername', $aftername)->with('afteremail', $afteremail)->with('status', $status);
    }
}
