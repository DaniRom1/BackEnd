<?php

namespace App\Restify;

use App\Models\Fav;
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
}
