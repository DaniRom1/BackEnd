<?php

namespace App\Restify;

use App\Models\Chat;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class ChatRepository extends Repository
{
    public static string $model = Chat::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
        ];
    }
}
