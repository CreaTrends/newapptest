<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Curso extends Model
{
    //
    protected $fillable = ['name','slug'];


    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class,'alumno_curso')->with('parent');
    }
    public function alumnos_list()
    {
        return $this->belongsToMany(Alumno::class,'alumno_curso')->with('parent');
    }
    public function alumno()
    {
        return $this->belongsToMany(Alumno::class,'alumno_curso','alumno_id');
    }
    public function teacher()
    {
        return $this->belongsToMany(User::class,'curso_teacher');
    }
    public function parent()
    {
        return $this->belongsToMany(User::class,'alumno_parent','alumno_id')->with('profile');
    }

    public function parent_list(){
        return $this->belongsToMany(User::class,'alumno_parent','user_id');
    }
    
    public function profile()
    {
       return $this->hasOne(Profile::class);
    }
    public function notes()
    {
       return $this->hasMany(Note::class);
    }
    public function readed()
    {
       return $this->belongsToMany(User::class,'note_user','note_id')->where('readed',1);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'alumno_parent','curso_id');
    }
}
