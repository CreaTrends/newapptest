<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notebook extends Model
{
    protected $fillable = [
        'alumno_id',
        'foods',
        'naps',
        'moods',
        'depositions',
        'accidents',
        'comment',
        'activity_type',
        'data',
        'attached'
    ];
    protected $casts = [
        'foods'         => 'array',
        'naps'          => 'array',
        'depositions'   => 'array',
        'data'          => 'array',
        'attached'      => 'array',
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

    public function getDataAttribute($value)
    {
        return $value;
    }
    public function getAttachedAttribute($value)
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
        return $this->belongsTo(Alumno::class);
    }
    public function attachs()
    {
        return $this->belongsToMany(Attached::class);
    }
    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }

    public function alumno_notebook()
    {
        return $this->belongsToMany(Alumno::class,'alumno_notebook');
    }
    public function info()
    {
        return $this->belongsToMany(Alumno::class,'alumno_notebook','notebook_id');
    }
}
