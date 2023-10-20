<?php

namespace App\Restify;

use App\Models\User;
use Illuminate\Http\Request;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class UserRepository extends Repository
{

    public static array $search = ['nickname', 'email'];


    public static string $model = User::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            field('ID_user'),
            field('nickname')->rules('required'),

            field('email')->storingRules('required', 'unique:users')->messages([
                'required' => 'This field is required.',
            ]),
            field('phone_number'),
            field('profile_picture'),
            field('profile_type'),
        ];
    }

    //PATCH: /api/restify/announces/ID_announce Fichero JSON con cambios
    public function update(Request $request, $ID_user)
    {
        $user = User::findOrFail($ID_user)
            ->update($request->all()); 

        return response()->json($user);
    }

    //GET: /api/restify/announces/ID_announce
    public function show(Request $request, $ID_user)
    {
        $user = User::findOrFail($ID_user);
        return response()->json($user);
    }

    //DELETE: /api/restify/announces/ID_announce No funciona con JSON
    public function destroy(Request $request, $ID_user)
    {
        User::destroy($ID_user);
        $response = ["response" => 'El usuario ' . $ID_user . ' fue eliminado'];
        return response()->json($response);
    }

    
}
