<?php

namespace App\Http\Controllers\Restify\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:'.Config::get('config.auth.table', 'users')],
            'password' => ['required', 'confirmed'],
        ]);

        /**
         * @var User|string $user
         */
        $model = config('restify.auth.user_model');

        $user = $model::forceCreate([
            //'name' => $request->input('name'),
            'nickname' => $request->input('nickname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone_number' => $request->input('phone_number'),
            'profile_picture' => '/images/user/user-default.jpg',
            'profile_type' => 'Particular',
        ]);

        return rest($user)->indexMeta([
            'token' => $user->createToken('login')->plainTextToken,
        ]);
    }
}
