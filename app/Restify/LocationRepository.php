<?php

namespace App\Restify;

use App\Models\Location;
use Binaryk\LaravelRestify\Filters\SearchableFilter;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class CustomLocSearchFilter extends SearchableFilter
{
    // GET: /api/restify/locations Archivo JSON: "search":ID_location
    public function filter(RestifyRequest $request, $query, $value)
    {
        $query->where('ID_location', $value);
        return response()->json($query);
    }
}

class LocationRepository extends Repository
{
    public static string $model = Location::class;

    public static function searchables(): array
    {
        return [
            'location' => CustomLocSearchFilter::make(),
        ];
    }

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

    
}
