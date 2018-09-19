<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.phone');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate_phone($request);
        if($user = User::where('phone',$request->phone)){
            $response = $this->broker()->sendResetLink(
                $request->only('phone')
            );

            return $response == Password::RESET_LINK_SENT
                ? $this->sendResetLinkResponse($response)
                : $this->sendResetLinkFailedResponse($request, $response);
        } else {
            return back()->withErrors(['phone' => '号码不存在']);
        }

    }

    public function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->withErrors(
            ['phone' => trans($response)]
        );
    }

    public function validate_phone($request){
        $this->validate($request,['phone' => 'required|size:10|string']);
    }
}
