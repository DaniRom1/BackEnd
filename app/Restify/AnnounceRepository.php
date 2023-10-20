<?php

namespace App\Restify;

use Illuminate\Http\Request;
use App\Models\Announce;
use Binaryk\LaravelRestify\Filters\SearchableFilter;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Binaryk\LaravelRestify\Filters\AdvancedFilter;

/*
class CustomAnnounceSearchFilter extends SearchableFilter
{
    public function filter(RestifyRequest $request, $query, $value)
    {
        $query->where('ID_announce', $value);
        $announces = $query->get();
        return response()->json($announces);
    }
}
*/

class AnnounceRepository extends Repository
{
    public static string $model = Announce::class;

    //public static array $search = ['title'];

    /*
    public static function searchables(): array
    {
        return [
            'title' => CustomAnnounceSearchFilter::make(),
        ];
    }
    */

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

    //GET: /api/restify/announces/ID_announce
    public function show(Request $request, $ID_announce)
    {
        $announce = Announce::findOrFail($ID_announce);
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
        $request->validate([
            'title'=> 'required',
        ]);

        $data = $request->all();
        $announce = Announce::create($data);
        return response()->json($announce);
        //$announce->save();
    }

    /*
    public function filters(RestifyRequest $request): array
    {
        return [
            AnnounceFilter::new(),
        ];
    }*/



}
