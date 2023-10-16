<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function Register(Request $R){
        try{
            $cred = new User();
            $cred->nickname = $R->nickname;
            $cred->mail = $R->mail;
            $cred->password = Hash::make($R->password);
            $cred->save();
            $response = ['status'=>200,'message'=>'Register Successfully'];
            return response()->json($response);

        }catch(Exception $e){
            $response = ['status'=>500,'message'=>$e];
        }
    }

    function Login (Request $R){
        $user = User::where('mail',$R->mail)->first();

        if($user!='[]' && Hash::check($R->password,$user->password)){
            $token=$user->createToken('PersonalAccesToken')->plainTextToken;
            $response=['status'=>200,'token'=>$token,'user'=>$user,'mesage'=>'Successfully Login'];
            return response()->json($response);
        }else if($user=='[]'){
            $response = ['status'=>500,'message'=>'No account found with this email'];
            return response()->json($response);
        }else{
            $response = ['status'=>500,'message'=>'Wrong email or password'];
            return response()->json($response);
        }
    }

}
