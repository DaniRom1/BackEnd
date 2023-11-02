<?php

namespace App\Restify;

use App\Models\Picture;
use Illuminate\Http\Request;
use Binaryk\LaravelRestify\Filters\SearchableFilter;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

// GET: /api/restify/pictures Archivo JSON: "search":ID_announce
class CustomPicSearchFilter extends SearchableFilter
{
    public function filter(RestifyRequest $request, $query, $value)
    {
        $query->where('ID_announce', $value);
        return response()->json($query);
    }
}

class PictureRepository extends Repository
{
    public static string $model = Picture::class;

    public static function searchables(): array
    {
        return [
            'picture' => CustomPicSearchFilter::make(),
        ];
    }

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
