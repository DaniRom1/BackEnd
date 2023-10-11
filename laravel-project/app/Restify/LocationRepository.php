<?php

namespace App\Restify;

use App\Models\Location;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class LocationRepository extends Repository
{
    public static string $model = Location::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
        ];
    }
}
