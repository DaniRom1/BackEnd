<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function register(Request $request){
        $user = new User();
        $user->nickname = $request->nickname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;

        $user->save();

        Auth::login($user);

        //return redirect(route());
    }

    public function login(Request $request){
        $credentials = [
            "email" => $request->email,
            "password" => $request->password,
        ];
        
        //RECUERDO DE INICIO DE SESIÓN
        $remember = ($request->has('remember') ? true : false);
        if(Auth::attempt($credentials,$remember)){
            $request->sesssion()->regenerate();
            return redirect()->intended(route());
        } else {
            //return redirect(route());
        }
        //FIN RECUERDO DE INICIO DE SESIÓN

        //return redirect(route());
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        //return redirect(route());
    }


}