<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'ID_picture';

    protected $fillable = [
        'ID_picture',
        'img',
        'ID_announce',
    ];
}
