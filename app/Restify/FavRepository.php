<?php

namespace App\Restify;

use App\Models\Fav;
use App\Models\Announce;
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

        $ID_announce = $request->ID_announce;
        if ($ID_announce != null) {
            $favs = Fav::where('ID_user', $ID_user)
                ->where('favs.ID_announce', $ID_announce)
                ->pluck('ID_fav');
        } else {
            $favs = Fav::with(Fav::required())
                ->where('ID_user', $ID_user)
                ->orderBy('ID_fav', 'desc')
                ->paginate(10);

            foreach ($favs as $fav) {
                $announce = $fav->announce;
                $fav["announce"]->setAttribute('isFavourite', $announce->isFavourite($ID_user));
                $fav["announce"]->setAttribute('ableToEdit', $announce->ableToEdit($ID_user));
            }

        }

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
        $ID_user = auth()->user()->ID_user;
        $data = $request->all();
        $data['ID_user'] = $ID_user;
        $fav = Fav::create($data);
        return response()->json($fav);
    }
}
