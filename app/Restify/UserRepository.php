<?php

namespace App\Restify;

use App\Models\User;
use Illuminate\Http\Request;
use Binaryk\LaravelRestify\Filters\SearchableFilter;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;


class UserRepository extends Repository
{

    public static string $model = User::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            field('ID_user'),
            field('nickname'),

            field('email')->storingRules('required', 'unique:users')->messages([
                'required' => 'This field is required.',
            ]),
            field('phone_number'),
            field('profile_picture'),
            field('profile_type'),
        ];
    }

    //PATCH: /api/restify/users/ID_user Fichero JSON con cambios
    public function update(Request $request, $ID_user)
    {
        $userData = $request->all();
        $ID_user = auth()->user()->ID_user;
        $basePath = "http://192.168.1.95:8000/images/user/";
        $picName = "profile_picture_" . $ID_user . "jpg";

        if (isset($userData['profile_picture'])) {
            $userData['profile_picture'] = $basePath . $picName;
        }

        $user = User::findOrFail($ID_user)->update($userData);

        return response()->json($user);

        /*$user = User::findOrFail($ID_user)
            ->update($request->all());

        return response()->json($user);*/
    }

    //GET: /api/restify/users/ID_user
    public function show(Request $request, $ID_user)
    {
        //$user = User::findOrFail($ID_user);
        //$user = User::with('announces', 'favs')->findOrFail($ID_user);
        $user = User::with(User::required())->findOrFail($ID_user);
        foreach ($user->announces as $announce) {
            $announce->setAttribute('isFavourite', $announce->isFavourite($ID_user));
        }

        return response()->json($user);
    }

    //DELETE: /api/restify/users/ID_user No funciona con JSON
    public function destroy(Request $request, $ID_user)
    {
        User::destroy($ID_user);
        $response = ["response" => 'El usuario ' . $ID_user . ' fue eliminado'];
        return response()->json($response);
    }


}
