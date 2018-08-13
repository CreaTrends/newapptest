<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notebook extends Model
{
    protected $fillable = [
        'foods',
        'naps',
        'moods',
        'depositions',
        'accidents',
        'comment'
    ];
    protected $casts = [
        'foods'=> 'array',
        'naps'=> 'array',
        'depositions'=> 'array',
    ];
    public function getFoodsAttribute($value)
    {
        return json_decode($value);
    }
    public function getNapsAttribute($value)
    {
        return json_decode($value);
    }
    
    public function getDepositionsAttribute($value)
    {
        return json_decode($value);
    }
    public function getMoodsAttribute($value)
    {
        return $value;
    }

    //
    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }
    public function alumno()
    {
        return $this->belongsToMany(Alumno::class)->with('parent');
    }
    public function attachs()
    {
        return $this->belongsToMany(Attached::class);
    }
    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }
}
