<?php

namespace App\Restify;

use App\Models\Announce;
use App\Models\Location;
use App\Models\Picture;
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
            field('draught'),
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
        //$ID_user = $request->ID_user;
        $ID_user = auth()->user()->ID_user;

        $announces = Announce::with(Announce::required());

        $ID_userFilter = $request->ID_user;
        if ($ID_userFilter != null)
            $announces->where('announces.ID_user', $ID_userFilter);

        $title = $request->title;
        if ($title != null)
            $announces->whereRaw('LOWER(title) like ?', ['%' . strtolower($title) . '%']);

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

        $min_width = $request->min_width;
        if ($min_width == null)
            $min_width = 0;

        $max_width = $request->max_width;
        if ($max_width == null)
            $max_width = 999.99;

        $min_power = $request->min_power;
        if ($min_power == null)
            $min_power = 0;

        $max_power = $request->max_power;
        if ($max_power == null)
            $max_power = 9999;

        $announces->whereBetween('price', [$min_price, $max_price]);
        $announces->whereBetween('year', [$min_year, $max_year]);
        $announces->whereBetween('length', [$min_length, $max_length]);
        $announces->whereBetween('length', [$min_width, $max_width]);
        $announces->whereBetween('power', [$min_power, $max_power]);

        $available = $request->available;
        if ($available != null)
            $announces->where('available', $available);

        $type = $request->type;
        if ($type != null)
            $announces->where('type', $type);

        $fuel = $request->fuel;
        if ($fuel != null)
            $announces->where('fuel', $fuel);

        $location = $request->location;
        if ($location != null) {
            $ID_location = Location::where('provincia', $location)->pluck('ID_location');
            $announces->whereIn('ID_location', $ID_location);
        }

        $orderby = $request->orderby;
        switch ($orderby) {
            case 1: //Precio ascendente
                $announces = $announces->orderBy('announces.price', 'asc')->paginate(10);
                break;
            case 2: // Precio descendente
                $announces = $announces->orderBy('announces.price', 'desc')->paginate(10);
                break;
            case 3: // Fecha ascendente
                $announces = $announces->orderBy('announces.ID_announce', 'asc')->paginate(10);
                break;
            default: // Fecha descendente
                $announces = $announces->orderBy('announces.ID_announce', 'desc')->paginate(10);
        }
        
        foreach ($announces as $announce) {
            $announce->setAttribute('isFavourite', $announce->isFavourite($ID_user));
            //$announce->setAttribute('ableToEdit', $ID_user == $announce->ID_user ? true : false);
            $announce->setAttribute('ableToEdit', $announce->ableToEdit($ID_user));
        }
        
        return response()->json($announces);
    }

    //GET: /api/restify/announces/ID_announce
    public function show(Request $request, $ID_announce)
    {
        $announce = Announce::with(Announce::required())->findOrFail($ID_announce);
        $ID_user = auth()->user()->ID_user;
        $announce->setAttribute('isFavourite', $announce->isFavourite($ID_user));
        //$announce->setAttribute('ableToEdit', $ID_user == $announce->ID_user ? true : false);
        $announce->setAttribute('ableToEdit', $announce->ableToEdit($ID_user));

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
        $picturePaths = Picture::where('ID_announce', $ID_announce)->pluck('img')->toArray();
        foreach ($picturePaths as $picturePath) {
            $fullPath = public_path($picturePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        Announce::destroy($ID_announce);
        $response = ["response" => 'El anuncio ' . $ID_announce . ' fue eliminado'];
        return response()->json($response);
    }

    //POST /api/restify/announces Fichero JSON con los datos
    public function store(Request $request)
    {
        $data = $request->all();
        $ID_user = auth()->user()->ID_user;

        $localidad = $data['localidad'];
        $provincia = $data['provincia'];
        $location = Location::where('localidad', $localidad)->where('provincia', $provincia)->first();
        $data['ID_location'] = $location->ID_location;
        $data['ID_user'] = $ID_user;
        $data['available'] = true;

        $announce = Announce::create($data);

        return response()->json([
            'ID_announce' => $announce['ID_announce']
        ]);
    }

}
