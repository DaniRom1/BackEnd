<?php

namespace App\Http\Controllers;

use App\Models\Announce;
use App\Models\Location;
use Illuminate\Http\Request;
use Exception;

class AnnounceController extends Controller
{
    public function list()
    {
        $announces = Announce::all();
        return response()->json($announces);
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
        $announce->ID_location = Location::where('localidad',$location)->first()->ID_location;
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

        try{
            $announce = Announce::findOrFail($ID_announce);
            $announce->delete();
            $response = ['status'=> 200, 'message'=> 'Anuncio eliminado'];
        } catch(Exception $e){
            $response = ['status'=> 500, 'message'=> $e->getMessage()];
        }

        return response()->json($response);
    }

}