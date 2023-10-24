<?php

namespace App\Restify;

use App\Models\Picture;
use Illuminate\Http\Request;
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

    //POST /api/restify/pictures Fichero JSON con los datos
    /*
    FICHERO JSON EJEMPLO

    {
        "pictures": [
            {
                "img": "pic1.jpg",
                "ID_announce": 1
            },
            {
                "img": "pic2.jpg",
                "ID_announce": 1
            },
            {
                "img": "pic3.jpg",
                "ID_announce": 1
            },
            {
                "img": "pic4.jpg",
                "ID_announce": 1
            }
        ]
    }

    */
    public function store(Request $request)
    {
        $data = $request->all();
        foreach ($data['pictures'] as $pictureData) {
            $picture = Picture::create($pictureData);
        }
        return response()->json($picture);
    }
}
