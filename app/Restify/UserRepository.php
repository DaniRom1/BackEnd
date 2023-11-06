<?php

namespace App\Restify;

use App\Models\User;
use Illuminate\Http\Request;
use Binaryk\LaravelRestify\Filters\SearchableFilter;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

// GET: /api/restify/favs Archivo JSON: "search":ID_user
class CustomUserSearchFilter extends SearchableFilter
{
    public function filter(RestifyRequest $request, $query, $value)
    {
        $query->where('ID_user', $value);
        return response()->json($query);
    }
}

class UserRepository extends Repository
{

    public static string $model = User::class;

    public static function searchables(): array
    {
        return [
            'user' => CustomUserSearchFilter::make(),
        ];
    }

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
        $user = User::findOrFail($ID_user)
            ->update($request->all());

        return response()->json($user);
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
