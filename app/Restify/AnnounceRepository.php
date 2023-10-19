<?php

namespace App\Restify;

use App\Models\Announce;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

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
}
