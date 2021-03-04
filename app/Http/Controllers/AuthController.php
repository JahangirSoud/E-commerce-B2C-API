<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\authRepositories;




class AuthController extends Controller
{
    public function __construct(authRepositories $authRepositories){
        $this->authRepositories = $authRepositories;
    }
    public function login(Request $request){
        try{
            $formData = $request->all();
            $validator = \Validator::make($formData,[
                'email' => 'required',
                'password' => 'required'
            ]);
            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->getMessageBag()->first(),
                    'error' => $validator->getMessageBag(),
                ],401);
            }
            try{
                if($this->authRepositories->checkIfAuthenticated($request)){
                    $user= $this->authRepositories->findUserByEmailAddress($request->email);
                    $token= $user->createToken('app')->accessToken;
                    return response()->json([
                        'message'=>'success',
                        'token'=>$token,
                        'user'=>$user
                    ],200);
                }
            }catch(Exception $exception){
                return rsponse()->json([
                    'success' => false,

                ],401);
            }
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password'

            ],401);

        }catch(Exception $exception){
            return rsponse()->json([
                'success' => false,
            ]);
        }

    }
    public function register(Request $request){
        try{
            $formData = $request->all();
            $validator = \Validator::make($formData,[
                'name' => 'required',
                'email' => 'required|max:50|min:5|unique:users',
                'password' => 'required|min:6'
            ],[
                    'name.required' => 'Please give your name',
                    'email.required' => 'Please give your email address',
                    'email.unique' => 'Your email address is already used, Please Login or use another',
                    'password.required' => 'Please give your password',
                ]);
            if($validator->fails()){
                return response()->json([
                    'success'=> false,
                    'message' => $validator->getMessageBag()->first(),
                    'error' => $validator->getMessageBag(),
                ],401);
            }
            $user = $this->authRepositories->createUser($request);
            $token = $user->createToken('app')->accessToken;
            return response()->json([
                'success' => true,
                'token' => $token,
                'data' => $user,
            ],200);

        }catch(Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ],401);
        }

        
    }
}
