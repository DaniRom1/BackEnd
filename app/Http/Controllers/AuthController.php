<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $user = new User();
            $user->nickname = $request->nickname;
            $user->mail = $request->mail;
            $user->password = Hash::make($request->password);
            $user->phone_number = $request->phone_number;
            $user->profile_picture = $request->profile_picture;
            $user->profile_type = "Usuario";
            $user->save();

            $response = ['status' => 200, 'message' => 'Register Successfully'];
            return response()->json($response);
        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => 'Usuario existente'];//$e->getMessage()];
            return response()->json($response);
        }
    }

    public function login(Request $request)
    {
        $user = User::where('mail', $request->mail)->first();

        if (!is_null($user) && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('PersonalAccessToken')->plainTextToken;
            $response = ['status' => 200, 'token' => $token, 'user' => $user, 'message' => 'Successfully Login'];
        } elseif (is_null($user)) {
            $response = ['status' => 500, 'message' => 'No account found with this email'];
        } else {
            $response = ['status' => 500, 'message' => 'Wrong email or password'];
        }

        return response()->json($response);
    }
}
