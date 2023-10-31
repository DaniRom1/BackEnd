<?php

namespace App\Restify;

use App\Models\Announce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Binaryk\LaravelRestify\Filters\SearchableFilter;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;


// GET: /api/restify/announces Archivo JSON: "search":ID_user
class CustomAnnounceSearchFilter extends SearchableFilter
{
    public function filter(RestifyRequest $request, $query, $value)
    {
        $query->where('ID_user', $value);
        $query->orderBy('ID_announce', 'desc');
        $announces = $query->get();
        return response()->json($announces);
    }
}

class AnnounceRepository extends Repository
{
    public static string $model = Announce::class;


    public static function searchables(): array
    {
        return [
            'announce' => CustomAnnounceSearchFilter::make(),
        ];
    }


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

    /*
    public function index(Request $request)
    {
        $ID_user = $request->ID_user;
        $query = 'SELECT a.*, CASE WHEN f."ID_announce" IS NOT NULL THEN true ELSE false END AS favourite FROM announces a LEFT JOIN favs f ON a."ID_announce" = f."ID_announce" AND f."ID_user" ='.$ID_user.' ORDER BY favourite DESC, "ID_announce" DESC;';
        $response = DB::select($query);

        return response()->json($response);
    }
    */

    //GET: /api/restify/announces/ID_announce
    public function show(Request $request, $ID_announce/*, $ID_user*/)
    {
        // $announce = Announce::findOrFail($ID_announce);
        $announce = Announce::with('location', 'pictures', 'user')->findOrFail($ID_announce);
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
        $announce = Announce::create($data);
        return response()->json($announce);
    }

}
