<?php

namespace App\Restify;

use App\Models\Picture;
use App\Models\Announce;
use Illuminate\Http\Request;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Intervention\Image\ImageManagerStatic as Image;

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
    }*/

    public function store(Request $request){
        $data = $request->all();
        $basePath = "/images/announce/";
        $ID_announce = $data['ID_announce'];

        $picturePaths = Picture::where('ID_announce', $ID_announce)->pluck('img')->toArray();

        Picture::where('ID_announce', $ID_announce)->delete();

        $pictures = $request->file('picture');
        
        foreach ($picturePaths as $picturePath) {
            $fullPath = public_path($picturePath);
    
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
        
        foreach($pictures as $i => $picture){
            $picNumber = $i + 1;
            $picName = "announce" . $ID_announce . "_picture" . $picNumber . ".jpg";
            $picPath = $basePath . $picName;

            $picture->move(public_path($basePath), $picName);

            $picture = Picture::create([
                'img' => $picPath,
                'ID_announce' => $ID_announce,
            ]);
        }

        return response()->json($picNumber);
    }

    //DELETE: /api/restify/pictures/ID_picture No funciona con JSON
    public function destroy(Request $request, $ID_picture)
    {
        Picture::destroy($ID_picture);
        $response = ["response" => 'La imagen ' . $ID_picture . ' fue eliminada'];
        return response()->json($response);
    }
}
