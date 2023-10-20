<?php

namespace App\Restify;

use App\Models\Announce;
use Binaryk\LaravelRestify\Filters\SearchableFilter;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Binaryk\LaravelRestify\Filters\AdvancedFilter;


class CustomAnnounceSearchFilter extends SearchableFilter
{
    public function filter(RestifyRequest $request, $query, $value)
    {
        $query->where('ID_announce',  $value);
        $announces = $query->get();
        return response()->json($announces);
    }
}

class AnnounceRepository extends Repository
{
    public static string $model = Announce::class;

    //public static array $search = ['title'];

    public static function searchables(): array
    {
        return [
            'title' => CustomAnnounceSearchFilter::make(),
        ];
    }

    public function fields(RestifyRequest $request): array
    {
        return [
            field('ID_announce'),
            field('title'),
            field('price'),
            field('description'),
            field('available'),
            field('date_announce'),
            field('type'),
            field('year'),
            field('length'),
            field('width'),
            field('power'),
            field('engines'),
            field('fuel'),
            field('flag'),
            field('ID_location'),
            field('ID_user'),
        ];
    }

    

    /*
    public function store(RestifyRequest $request): void
    {
        $announce = Announce::create($request->validated());
        $announce->save();
    }


    public function filters(RestifyRequest $request): array
    {
        return [
            AnnounceFilter::new(),
        ];
    }*/



}
