<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $fillable = [
        'description'
    ];
    public function notebooks()
    {
        return $this->belongsToMany(Notebook::class);
    }
}
