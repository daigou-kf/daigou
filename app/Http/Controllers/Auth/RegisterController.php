<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\PospalController;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;
use Nexmo;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        try {
            Nexmo::verify()->check(
                session()->get('verify:request_id'),
                $data['code']
            );
            return Validator::make($data, [
                'password' => 'required|string|min:6|confirmed',
                'phone' => 'required|string|min:10|max:10|unique:users',
            ]);
        } catch (Nexmo\Client\Exception\Request $e) {
            $validator = Validator::make($data, [
                'password' => 'required|string|min:6|confirmed',
                'phone' => 'required|string|min:10|max:10|unique:users',
                'code' => ['size:4',Rule::in(['000000'])],
            ]);
            return $validator;
        }



    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data['phone'] = session()->get('phone_input');
        $cuid = PospalController::get_cuid_by_phone($data['phone']);
        $data['email'] = $data['phone'];
        if($cuid != null){
            $data['cuid'] = strval($cuid);
            return User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
                'cuid' => $data['cuid'],
            ]);
        }
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
        ]);
    }
}
