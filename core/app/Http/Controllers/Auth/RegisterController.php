<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\GeneralSettings;
use Session;

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'registration' => [
                function($attribute, $value, $fail) {
                    if ($value == 0) {
                        return $fail("Reagistration process has been disabled by admin!");
                    }
                }
            ],
            'username' => 'required|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'country' => 'required',
            'phone' => 'required|numeric'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $gen = GeneralSettings::first();

        if ($gen->registration == 1) {
            return User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'password' => bcrypt($data['password']),
                'email_verified' => $gen->email_verification,
                'sms_verified' => $gen->sms_verification,
                'email_ver_code' => $gen->email_verification == 0? rand(1000, 9999):NULL,
                'sms_ver_code' => $gen->sms_verification == 0?rand(1000, 9999):NULL,
                'ref_username' => $data['ref'],
                'country' => $data['country'],
                'phone' => $data['phone']
            ]);
        }

    }
}
