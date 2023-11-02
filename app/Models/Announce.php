<?php

namespace App\Models;

use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announce extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'ID_announce';

    protected $fillable = [
        'title',
        'price',
        'description',
        'available',
        'type',
        'year',
        'length',
        'width',
        'power',
        'engines',
        'fuel',
        'flag',
        'ID_location',
        'ID_user',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'ID_location');
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class, 'ID_announce');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'ID_user');
    }

    public function isFavourite($ID_user)
    {
        return Fav::where('ID_user', $ID_user)
            ->where('ID_announce', $this->ID_announce)
            ->exists();
    }

    public static function required()
    {
        return ['location', 'pictures', 'user'];
    }

}
