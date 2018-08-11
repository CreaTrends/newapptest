<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    //
    

    protected $fillable = [
    'firstname','lastname','image'
    ];

    
    public function curso()
    {
        return $this->belongsToMany(Curso::class,'alumno_curso');
    }
    public function teacher()
    {
        return $this->belongsToMany(User::class,'curso_teacher','user_id');
    }
    public function parent()
    {
        return $this->belongsToMany(User::class,'alumno_parent');
    }
    public function parent_with_profile()
    {
        return $this->belongsToMany(User::class,'alumno_parent')->with('profile');
    }
    public function notes()
    {
        return $this->belongsToMany(Note::class,'alumno_curso','curso_id');
    }
    public function curso_export()
    {
        return $this->belongsToMany(Note::class,'alumno_curso','curso_id');
    }
    public function notebooks()
    {
        return $this->belongsToMany(Notebook::class);
    }

}
