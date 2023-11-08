<?php

namespace App\Restify;

use App\Models\Fav;
use Illuminate\Http\Request;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

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

    //GET: /api/restify/favs
    public function index(Request $request)
    {
        $ID_user = auth()->user()->ID_user;
        $favs = Fav::with(Fav::required())
            ->where('ID_user', $ID_user)
            ->paginate(15);
        return response()->json($favs);
    }

    //GET: /api/restify/favs/ID_fav
    /*
    public function show(Request $request, $ID_fav)
    {
        //$fav = Fav::findOrFail($ID_fav);
        $fav = Fav::with(Fav::required())->findOrFail($ID_fav);
        return response()->json($fav);
    }
    */

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
