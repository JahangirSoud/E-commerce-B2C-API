<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\forgotRepositories;
use Mail;
use App\Mail\fogotMail;
class forgotController extends Controller
{
    public function __construct(forgotRepositories $forgotRepositories){
        $this->forgotRepositories = $forgotRepositories;
    }
    public function forgotPassword(Request $request){
        try{
            $formData = $request->all();
            $validator = \Validator::make($formData,[
                'email'=>'required'
            ]);
            if($validator->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validator->getMessageBag()
                ],401);
            }
            $email= $request->email;
            if((User::where('email',$email)->first())===NULL){
                return response()->json([
                    'message'=>'Invalied Email address'
                ],401);
            }
            $token = rand(10,100000);
            DB::table('password_resets')->insert([
                'email'=>$email,
                'token'=>$token,
            ]);
            try{
                Mail::to($email)->send(new fogotMail($token));
                return response()->json([
                    'message'=> 'Mail send successfully'],201);
            }catch(Exception $exception){
            return response()->json([
                'message'=>$exception->getMessage()
            ],401);
            }
        }catch(Exception $exception){
            return response()->json([
                'message'=>$exception->getMessage()
            ],401);
        }
    }

    public function resetPassword(Request $request){
        $formData = $request->all();
        $validator = \Validator::make($formData,[
            'email'=>'required',
            'token' => 'required',
            'password' => 'required|min:6'

        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> $validator->getMessageBag(),
            ],401);
        };
        $email =$request->email;
        $token =$request->token;
        $password = Hash::make($request->password);
        $emailCheck = DB::table('password_resets')->where('email',$email)->first();
        $tokenCheck = DB::table('password_resets')->where('token',$token)->first();

        if(!$emailCheck){
            return response()->json([
                'message'=> 'Email Invalid',
            ],401);
        }
        if(!$tokenCheck){
            return response()->json([
                'message'=> 'Token Invalid',
            ],401);
        }
        DB::table('users')->where('email',$email)->update(['password'=>$password]);
        DB::table('password_resets')->where('email',$email)->delete();
        return response()->json([
            'message'=> 'Password change Successfully',
        ],200);
    }
}
