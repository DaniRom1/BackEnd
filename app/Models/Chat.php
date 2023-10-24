<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'ID_message';

    protected $fillable = [
        'ID_message',
        'message_content',
        'ID_from',
        'ID_to',
    ];
}
