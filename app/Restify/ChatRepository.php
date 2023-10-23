<?php

namespace App\Restify;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Binaryk\LaravelRestify\Filters\SearchableFilter;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Binaryk\LaravelRestify\Filters\AdvancedFilter;

class ChatRepository extends Repository
{
    public static string $model = Chat::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            field('ID_message'),
            field('date_message'),
            field('message_content'),
            field('ID_from'),
            field('ID_to'),
        ];
    }

    //POST: /api/restify/chats Fichero JSON con los datos
    public function store(Request $request)
    {
        $data = $request->all();
        $message = Chat::create($data);
        return response()->json($message);
    }
}
