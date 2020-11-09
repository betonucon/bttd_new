<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected function credentials(\Illuminate\Http\Request $request)
    {
        if(is_numeric($request->get('email'))){
            return ['nik'=>$request->get('email'),'password'=>$request->get('password'),'sts'=>1];
        }else{
            return ['email' => $request->{$this->username()}, 'password' => $request->password,'sts'=>1];
        }
        return $request->only($this->username(), 'password');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
