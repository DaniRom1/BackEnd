<?php

namespace App\Http\Controllers;

use App\Models\Announce;
use App\Models\Location;
use App\Models\User;
use App\Models\Picture;
use Illuminate\Http\Request;
use Exception;

class AnnounceController extends Controller
{
    public function list()
    {
        $announces = Announce::all();
        foreach ($announces as $announce) {
            $location = Location::find($announce->ID_location);
            $user = User::find($announce->ID_user);
            $picture = Picture::where('ID_announce', $announce->ID_announce)->first();
            $announcesData[] = [
                'announce' => $announce,
                'user' => $user,
                'location' => $location,
                'picture' => $picture,
            ];
        }

        return response()->json($announcesData);
        //return response()->json($announces);
    }

    public function create(Request $request)
    {
        $announce = new Announce();
        $announce->title = $request->title;
        $announce->price = $request->price;
        $announce->description = $request->description;
        $announce->available = true;
        $announce->type = $request->type;
        $announce->year = $request->year;
        $announce->length = $request->length;
        $announce->width = $request->width;
        $announce->power = $request->power;
        $announce->engines = $request->engines;
        $announce->fuel = $request->fuel;
        $announce->flag = $request->flag;
        $location = $request->location;
        $announce->ID_location = Location::where('localidad', $location)->first()->ID_location;
        $announce->ID_user = $request->ID_user;

        try {
            $announce->save();
            $response = ['status' => 200, 'message' => 'Anuncio publicado'];
        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => $e->getMessage()]; //$e->getMessage()];
        }

        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $ID_announce = $request->ID_announce;

        try {
            $announce = Announce::findOrFail($ID_announce);
            $announce->delete();
            $response = ['status' => 200, 'message' => 'Anuncio eliminado'];
        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => $e->getMessage()];
        }

        return response()->json($response);
    }

    public function filterlist(Request $request)
    {
        $query = Announce::query();

        $ID_user = $request->ID_user;

        $min_price = $request->min_price;
        if ($min_price == null)
            $min_price = 0;

        $max_price = $request->max_price;
        if ($max_price == null)
            $max_price = 999999999;

        $min_year = $request->min_year;
        if ($min_year == null)
            $min_year = 0;

        $max_year = $request->max_year;
        if ($max_year == null)
            $max_year = 9999;

        $min_length = $request->min_length;
        if ($min_length == null)
            $min_length = 0;

        $max_length = $request->max_length;
        if ($max_length == null)
            $max_length = 999.99;

        $query->whereBetween('price', [$min_price, $max_price]);
        $query->whereBetween('year', [$min_year, $max_year]);
        $query->whereBetween('length', [$min_length, $max_length]);

        $location = $request->location;
        if ($location != null) {
            $locations = Location::where('provincia', $location)->get();
            $IDs = $locations->pluck('ID_location');
            $query->whereIn('ID_location', $IDs);
        }

        $title = $request->title;
        if ($title != null)
            $query->where('title', 'like', '%' . $title . '%');

        $type = $request->type;
        if ($type != null)
            $query->where('type', $type);

        $query->selectRaw('announces.*, CASE WHEN favs."ID_announce" IS NOT NULL THEN true ELSE false END AS "isFavourite"')
            ->from('announces')
            ->leftJoin('favs', function ($join) use ($ID_user) {
                $join->on('announces.ID_announce', '=', 'favs.ID_announce')
                    ->where('favs.ID_user', $ID_user);
            })
            ->orderBy('announces.ID_announce', 'desc');

        $announces = $query->get();
        $count = $query->count();

        foreach ($announces as $announce) {
            $location = Location::find($announce->ID_location);
            $user = User::find($announce->ID_user);
            $picture = Picture::where('ID_announce', $announce->ID_announce)->first();
            $announcesLoc[] = [
                'announce' => $announce,
                'location' => $location,
                'picture' => $picture,
                'user' => $user,
            ];
        }

        return response()->json([
            'totalResults' => $count,
            'announces' => $announcesLoc]);
    }

    public function announce(Request $request)
    {
        $ID_announce = $request->ID_announce;
        $announce = Announce::find($ID_announce);

        $user = User::find($announce->ID_user);
        $location = Location::find($announce->ID_location);
        $pictures = Picture::where('ID_announce', $announce->ID_announce)->get();

        $announceUserLoc = [
            'announce' => $announce,
            'user' => $user,
            'location' => $location,
            'pictures' => $pictures,
        ];

        return response()->json($announceUserLoc);

        /*
        $jsonResponse = response()->json($announceUser);
        $redirectResponse = redirect()->route('');
        return [$jsonResponse, $redirectResponse];
        */
    }

}