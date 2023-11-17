<?php

namespace App\Restify;

use App\Models\Location;
use Illuminate\Http\Request;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class LocationRepository extends Repository
{
    public static string $model = Location::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            field('ID_location'),
            field('localidad'),
            field('provincia'),
            field('comunidad'),
            field('country'),
        ];
    }

    public function index(Request $request)
    {
        $locations = Location::distinct('comunidad')->orderBy('comunidad', 'asc')->get('comunidad');

        $comunidad = $request->comunidad;
        if ($comunidad != null)
            $locations = Location::distinct('provincia')->orderBy('provincia', 'asc')->where('comunidad', $comunidad)->get('provincia');

            $provincia = $request->provincia;
        if ($provincia != null)
            $locations = Location::distinct('localidad')->orderBy('localidad', 'asc')->where('provincia', $provincia)->get('localidad');

        
        return response()->json($locations);
    }
    
}
