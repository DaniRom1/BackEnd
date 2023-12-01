<?php
namespace App\Http\Controllers\Restify\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use GetStream\StreamChat\Client;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        /** * @var User $user */
        if (! $user = config('restify.auth.user_model')::query()
            ->whereEmail($request->input('email'))
            ->first()) {
            abort(401, 'Invalid credentials.');
        }

        if (! Hash::check($request->input('password'), $user->password)) {
            abort(401, 'Invalid credentials.');
        }

        /*STREAM CHAT*/
        $STREAM_API_KEY = 'qts5narahjsz';
        $STREAM_API_SECRET = '2b7uguhrwkt6urcrnwkwwx5tzygrt9skjnm2pzjxekgw66ybn533e47xyv5mjnz9';
        $ID_user = User::where('email', $request->input('email'))->pluck('ID_user');
        $ID_user = str_replace(['[', ']'], '', $ID_user);
        $server_client = new Client($STREAM_API_KEY, $STREAM_API_SECRET);
        $token = $server_client->createToken($ID_user);
        

        return rest($user)->indexMeta([
            'token' => $user->createToken('login')->plainTextToken,
            'chatToken' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
