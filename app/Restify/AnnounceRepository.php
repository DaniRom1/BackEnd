<?php

namespace App\Restify;

use App\Models\Announce;
use App\Models\Location;
use Illuminate\Http\Request;
use Binaryk\LaravelRestify\Filters\SearchableFilter;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;


// GET: /api/restify/announces Archivo JSON: "search":Busqueda
class CustomAnnSearchFilter extends SearchableFilter
{
    public function filter(RestifyRequest $request, $query, $value)
    {
        $query->where('title', 'like', '%' . $value . '%');
        return response()->json($query);
    }
}

class AnnounceRepository extends Repository
{
    public static string $model = Announce::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            field('ID_announce'),
            field('title'),
            field('price'),
            field('description'),
            field('available'),
            field('date_announce'),
            field('type'),
            field('year'),
            field('length'),
            field('width'),
            field('power'),
            field('engines'),
            field('fuel'),
            field('flag'),
            field('ID_location'),
            field('ID_user'),
        ];
    }

    public function index(Request $request)
    {
        $ID_user = $request->ID_user;
        $announces = Announce::with(Announce::required())
            ->selectRaw('announces.*, CASE WHEN favs."ID_announce" IS NOT NULL THEN true ELSE false END AS "isFavourite"')
            ->leftJoin('favs', function ($join) use ($ID_user) {
                $join->on('announces.ID_announce', '=', 'favs.ID_announce')
                    ->where('favs.ID_user', $ID_user);
            });

        if ($request->has('search')) {
            $value = $request->get('search');
            $announces->whereRaw('LOWER(title) like ?', ['%' . strtolower($value) . '%']);
        }

        /*
        $min_price = $request->min_price;
        if ($min_price == null)
            $min_price = 0;

        $max_price = $request->max_price;
        if ($max_price == null)
            $max_price = 999999999;

        $min_year = $request->min_year;
        if ($min_year == null)
            $min_year = 0;

        $max_year = $request->max_year;
        if ($max_year == null)
            $max_year = 9999;

        $min_length = $request->min_length;
        if ($min_length == null)
            $min_length = 0;

        $max_length = $request->max_length;
        if ($max_length == null)
            $max_length = 999.99;

        $announces->whereBetween('price', [$min_price, $max_price]);
        $announces->whereBetween('year', [$min_year, $max_year]);
        $announces->whereBetween('length', [$min_length, $max_length]);
        */

        $announces = $announces->orderBy('announces.ID_announce', 'desc')->paginate(5);

        return response()->json($announces);
    }

    //GET: /api/restify/announces/ID_announce
    public function show(Request $request, $ID_announce)
    {
        $announce = Announce::with(Announce::required())->findOrFail($ID_announce);
        $ID_user = $request->ID_user;
        $announce->setAttribute('isFavourite', $announce->isFavourite($ID_user));
        return response()->json($announce);
    }

    //PATCH: /api/restify/announces/ID_announce Fichero JSON con cambios
    public function update(Request $request, $ID_announce)
    {
        $announce = Announce::findOrFail($ID_announce)
            ->update($request->all());

        return response()->json($announce);
    }

    //DELETE: /api/restify/announces/ID_announce No funciona con JSON
    public function destroy(Request $request, $ID_announce)
    {
        Announce::destroy($ID_announce);
        $response = ["response" => 'El anuncio ' . $ID_announce . ' fue eliminado'];
        return response()->json($response);
    }

    //POST /api/restify/announces Fichero JSON con los datos
    public function store(Request $request)
    {
        $data = $request->all();

        $location = $data['location'];
        $location = Location::where('localidad', $location)->first();
        $data['ID_location'] = $location->ID_location;

        $data['available'] = true;

        $announce = Announce::create($data);

        return response()->json($announce);
    }

}
