<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'ID_fav';

    protected $fillable = [
        'ID_fav',
        'ID_announce',
        'ID_user',
    ];
}
