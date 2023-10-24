<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announce;
use App\Models\Location;
use App\Models\Fav;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    public function list()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function delete(Request $request)
    {
        $ID_user = $request->ID_user;

        try {
            $user = User::findOrFail($ID_user);
            $user->delete();
            $response = ['status' => 200, 'message' => 'Usuario eliminado'];
        } catch (Exception $e) {
            $response = ['status' => 500, 'message' => $e->getMessage()];
        }

        return response()->json($response);
    }


    public function user(Request $request)
    {
        $ID_user = $request->ID_user;
        $user = User::find($ID_user);

        $announces = Announce::where("ID_user", $user->ID_user)->get();
        $announcesLoc = [];
        foreach ($announces as $announce) {
            $location = Location::find($announce->ID_location);
            $announcesLoc[] = [
                'announce' => $announce,
                'location' => $location,
            ];
        }

        $favs = Fav::where("ID_user", $user->ID_user)->get();
        $favsAnnounces = [];
        foreach($favs as $fav){
            $favData = Announce::find($fav->ID_announce);
            $favsAnnounces[] = [
                'fav' => $fav,
                'favData' => $favData
            ];
        }

        $userData = [
            'user' => $user,
            'announces' => $announcesLoc,
            'favs' => $favsAnnounces,
            //'location' => $location,
        ];

        return response()->json($userData);

        /*
        $jsonResponse = response()->json($announceUser);
        $redirectResponse = redirect()->route('');
        return [$jsonResponse, $redirectResponse];
        */
    }

}