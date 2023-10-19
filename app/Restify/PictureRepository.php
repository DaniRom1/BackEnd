<?php

namespace App\Restify;

use App\Models\Picture;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class PictureRepository extends Repository
{
    public static string $model = Picture::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            field('ID_picture'),
            field('img'),
            field('ID_announce'),
        ];
    }
}
