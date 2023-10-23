<?php

namespace App\Restify;

use App\Models\Fav;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use App\Models\Announce;
use App\Models\User;
use Illuminate\Http\Request;

class FavRepository extends Repository
{
    public static string $model = Fav::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            field('ID_fav'),
            field('ID_announce'),
            field('ID_user'),
        ];
    }

    //GET: /api/restify/favs/ID_user
    public function show(Request $request, $ID_user)
    {
        $fav = Fav::where('ID_user', $ID_user)->get();
        return response()->json($fav);
    }

    //DELETE: /api/restify/favs/ID_fav No funciona con JSON
    public function destroy(Request $request, $ID_fav)
    {
        Fav::destroy($ID_fav);
        $response = ["response" => 'El anuncio favorito ' . $ID_fav . ' fue eliminado'];
        return response()->json($response);
    }

    //POST /api/restify/announces Fichero JSON con los datos
    public function store(Request $request)
    {
        $data = $request->all();
        $fav = Fav::create($data);
        return response()->json($fav);
    }
}
