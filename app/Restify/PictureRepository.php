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

    public function index(Request $request)
    {
        $pictures = Picture::all();

        foreach($pictures as $picture){
            $picture['img'] = 'http://192.168.1.95:8000' . $picture['img'];
        }

        return response()->json($pictures);
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
        //$basePath = "http://192.168.1.95:8000/images/announce/";
        $basePath = "/images/announce/";
        //$defaultPicturePath = "http://192.168.1.95:8000/images/announce/announce_default.jpg";
        
        $ID_announce = $data['pictures'][0]['ID_announce'];
        Picture::where('ID_announce', $ID_announce)->delete();

        foreach ($data['pictures'] as $i => $pictureData) {
            $picNumber = $i + 1;
            $picName = "announce" . $pictureData['ID_announce'] . "_picture" . $picNumber . ".jpg";
            $picPath = $basePath . $picName;
            
            //Guardar imagen en el directorio
            //$image = $request->file('img');
            //$image->storeAs($basePath, $picName);
            
            $picture = Picture::create([
                'img' => $picPath,
                //'img' => $defaultPicturePath,
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
