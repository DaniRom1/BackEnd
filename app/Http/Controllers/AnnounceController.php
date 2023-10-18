<?php

namespace App\Http\Controllers;

use App\Models\Announce;
use App\Models\User;
use Binaryk\LaravelRestify\Controllers\RestControllers;

class AnnounceController extends Controller
{
    public function list()
    {
        $announces = Announce::all();
        return response()->json($announces);
    }

}