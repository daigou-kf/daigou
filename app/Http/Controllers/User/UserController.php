<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\UserSettings;

class UserController extends Controller
{
    public function disable_welcome(Request $request){
        $user = Auth::user();
        $user_settings = $user->settings;
        if($request->get('disable_welcome') == "on"){
            $user_settings->show_welcome = 0;
            $user_settings->save();
        }
        return redirect()->back();
    }

    public function disable_delivery_reminder(Request $request){
        $user = Auth::user();
        $user_settings = $user->settings;
        if($request->get('disable_delivery_reminder') == "on"){
            $user_settings->show_delivery_reminder = 0;
            $user_settings->save();
        }
        return redirect()->back();
    }

    public function edit_password()
    {
        $page = 'dashboard';
        return view('home.info.edit_password', compact('page'));
    }

    public function change_password(Request $request)
    {
        $old_password = $request->old_password;
        $user = Auth::user();

        if (Hash::check($old_password, $user->password)) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:6|confirmed',
            ]);
            if ($validator->fails()) {
                return redirect(route('home_edit_password'))
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect(route('home_dashboard'))->with('success', '更新成功');
            }

        } else {
            return redirect(route('home_dashboard'))->with('fail', '密码错误');
        }

    }
}
