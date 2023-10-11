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
            id(),
        ];
    }
}
