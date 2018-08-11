<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'album_name',
        'album_description',
        'album_token',
        'album_owner'
    ];

    public function photo()
    {
        return $this->hasMany(Photo::class,'album_id','album_id');
    }
}
