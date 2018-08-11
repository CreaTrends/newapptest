<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
    //
    //
    
    
    protected $fillable = ['name','lastname'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function childs()
    {
        return $this->belongsTo(Alumno::class,'alumno_parent');
    }
    
    public function profile()
    {
        return $this->belongsTo(Profile::class)->with('name', 'firstname');
    }
}
