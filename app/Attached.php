<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attached extends Model
{
    //
    protected $table = "attaches";
    protected $fillable = [
        'file'=> 'array'
    ];
    protected $casts = [
         'file' => 'array',
    ];
    public function getFileAttribute($value)
    {
        return json_decode($value);
    }
    public function notebooks()
    {
        return $this->belongsToMany(Notebook::class);
    }
}
