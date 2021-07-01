<?php

namespace App\Http\Controllers;

use App\User; //追加
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use \InterventionImage;//画像リサイズライブラリ
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function myPage()
    {
        return view('account');
    }

    public function myPageEdit()
    {
        return view('account_edit');
    }
    public function myPageUpdate(Request $request)// User $userいらんとおもう $user定義しなおしてるし。
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
            $password = Hash::make($request->input('password'));
            $user_record->update(['password' => $password]);
        }

        $status = "更新しました";

        return view('account')->with('aftername', $aftername)->with('afteremail', $afteremail)->with('status', $status);
    }
        public function passwordUpdate(Request $request, User $user)
    {//passwordだけモーダルで変更させる機能実装中
        $user =Auth::user();
        
        $request->validate([
        'password' => ['confirmed','required'],

    ]);
        $password = Hash::make($request->input('password'));
        $user_record = User::where('id', $user->id);
        $user_record->update(['password' => $password]);
        return view('account');//いったんメッセージなしで更新してページ移管
    }
        public function userEdit(Request $request){

            $user_record = User::where('id',$request->user_id);//postされてきたstock_idを持つレコードをstocksテーブルから取得
            $request->validate([
                'user_name' => 'required|max:15',
                'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($request->user_id)],
            ]);
            $user_record->update(['name' => $request->user_name]);
            $user_record->update(['email' => $request->email]);
            
            if ($request->input('password')!="") {//入力があった場合のみパスワード変更
                $password = Hash::make($request->input('password'));
                $user_record->update(['password' => $password]);
            }

            return redirect()->back()->with('message','ユーザー情報を更新しました');

    } 
        public function userDelete(Request $request ,User $user,$user_id){//ユーザー削除
            //ユーザー削除と同時に作品も非公開にしたい
            $user_record = User::where('id',$user_id);//postされてきたstock_idを持つレコードをstocksテーブルから取得
            $user_record->update(['status' => 'delete']);
            return redirect()->back()->with('message','削除しました')->with('user_id',$user_id)->with('modalMessage',$modalMessage);
        }
        public function withdrawal(Request $request){
            //ログインユーザーと削除対象ユーザーのIDが同じ
            //パスワードが一致している
            //のであれば
            $user_id =Auth::user()->id;
            $password=Auth::user()->password;

            if($password==Hash::make($request->password)){
                dd('パスワード一致');
            }else{
                dd('パスワード不一致'.$password.'と'.Hash::make($request->password));
            }

            if($user_id == $request->user_id){
                dd('ログインユーザーと削除ユーザー一致');
            }else{
                dd('ログインIDと削除対象IDが一致しないので退会できません。');
            }
        }
}