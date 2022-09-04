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
    protected $redirectTo = '/';//redirecciona a la home

    /**
     * Create a new controller instance.
     * Además seteo la URL de redirección, que luego es leida por AuthenticateUsers.sendLoginResponse()
     *
     * @return void
     */
    public function __construct()
    {
        redirect()->setIntendedUrl(url()->previous());
        $this->middleware('guest')->except('logout');
    }

    public function username() //Devuelve el campo por el cual se logueara el usuario
    {
        return 'username';
    }
}
