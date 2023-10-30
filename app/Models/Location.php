<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'ID_location';

    protected $fillable = [
        'ID_location',
        'localidad',
        'provincia',
        'comunidad',
        'country',
    ];
}
