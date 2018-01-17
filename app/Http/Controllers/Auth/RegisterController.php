<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserSignUp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Response;

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
    protected $redirectTo = '/home';

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /*For Register data*/
    protected function register(Request $request,$token = null)
    {

        try
        {
            // For validation

            $validator = $this->validator($request->all());

            if($validator->fails())
            {
                 $messages = $validator->messages();
                 $name = $messages->first('name');
                 $email = $messages->first('email',['required|email|unique:users']);
                 $password = $messages->first('password',['required|min:6|confirmed']);
                 $dob = $messages->first('dob');
                 
                 $gender = $messages->first('gender');
                 
                  return Response::json(['status'=>0,'message'=>$messages]);
            }else
            {
                //insert database
               $result = User::create([
                        'name' => $request->name,
                        'ud_id' => $request->ud_id,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                    ]);
                if($result)
                {

                    UserSignUp::create(
                        ['user_id' => $result->id, 'dob' =>$request->dob,'gender'=>$request->gender]
                    );

                    return Response::json(['data' => $result,'error'=> false ,'message' => 'Register Successfully','status' => 200 ]);
                }else
                {
                    return Response::json(['status'=>0,'error'=>true,'message'=>'Register Not Successfully']);
                }
                
            }


        }catch (Exception $e){

              return Response::json(['status' => 0]);
        }


    }
}
