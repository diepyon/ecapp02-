<?php

namespace App\Http\Controllers;

//use App\Models\Stock; //追加
//use App\Models\Cart; //追加
//use App\Models\Favorite; //追加
//use App\Models\Orderhistory; //追加
use App\User; //追加
use Illuminate\Support\Facades\Auth;//ログイン情報取得できるやつ
use Illuminate\Validation\Rule;//バリテーションルール
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
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validateWithBag('updateProfileInformation');

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }
        return view('mypage')->with('aftername', $aftername)->with('afteremail', $afteremail);
    }
}
