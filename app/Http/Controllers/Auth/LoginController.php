<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Http\Requests;
use JWTAuth;
use App\User;
use JWTAuthException;
use Illuminate\Support\Facades\Validator;
use Response;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {   
         $credentials = $request->only('email', 'password');
         $token = null;
        try
        {
           if(!$token = JWTAuth::attempt($credentials))
           {
                return Response::json(['response'=>'error','message'=>'invalid Email or Password']);
           }


        }catch(JWTAuthException $e)
        {
            return Response::json(['response' => 'error','message'=>'Failed to Create Token']);
        }

        return Response::json(['response'=>'success','result'=>$token]);
        
    }
}
