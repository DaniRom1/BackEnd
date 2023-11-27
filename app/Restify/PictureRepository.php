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
}
