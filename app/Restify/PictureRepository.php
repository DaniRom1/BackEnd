<?php

namespace App\Restify;

use App\Models\Picture;
use App\Models\Announce;
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
        $pictures = [];

        /*$ID_announce = $data['ID_announce'];
        $announce = Announce::findOrFail($announceId);
        $currentImageCount = $announce->pictures->count();*/
        
        $ID_announce = $data['pictures'][0]['ID_announce'];
        $announce = Announce::findOrFail($ID_announce);
        $announcePictures = $announce->pictures->count();

        foreach ($data['pictures'] as $i => $pictureData) {
            $picNumber = $announcePictures + $i + 1;
            $picName = "announce" . $pictureData['ID_announce'] . "_picture" . $picNumber . ".jpg";
            $picture = Picture::create([
                'img' => $picName,
                'ID_announce' => $pictureData['ID_announce'],
            ]);
            $pictures[] = $picture;
        }
        return response()->json($pictures);
    }

    //DELETE: /api/restify/pictures/ID_picture No funciona con JSON
    public function destroy(Request $request, $ID_picture)
    {
        Picture::destroy($ID_picture);
        $response = ["response" => 'La imagen ' . $ID_picture . ' fue eliminada'];
        return response()->json($response);
    }
}
