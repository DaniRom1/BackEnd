<?php

namespace App\Restify;

use App\Models\User;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class UserRepository extends Repository
{
    public static string $model = User::class;

    public function fields(RestifyRequest $request): array
    {
        return [
            field('ID_user'),
            field('nickname')->rules('required'),

            field('email')->storingRules('required', 'unique:users')->messages([
                'required' => 'This field is required.',
            ]),
            field('profile_picture'),
            field('profile_type'),

        ];
    }
}
