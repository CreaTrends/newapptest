<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    public function cursos()
    {
        //return $this->belongsToMany(Alumno::class)->withPivot('details');
        return $this->hasMany(Curso::class,'curso_teacher');
    }
}
