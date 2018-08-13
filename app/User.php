<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Lexx\ChatMessenger\Traits\Messagable;
class User extends Authenticatable 
{
    use LaratrustUserTrait;
    use Notifiable;
     use Messagable;

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','api_token','first_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function curso()
    {
        //return $this->belongsToMany(Alumno::class)->withPivot('details');
        return $this->belongsToMany(Curso::class,'alumno_teacher','user_id');
    }
    public function students()
    {
        //return $this->belongsToMany(Alumno::class)->withPivot('details');
        return $this->belongsToMany(Alumno::class,'alumno_parent');
    }
    public function teacher_course()
    {
        return $this->belongsToMany(Curso::class,'curso_teacher')->with('alumnos_list');
    }
    public function childs()
    {
        //return $this->belongsToMany(Alumno::class)->withPivot('details');
        return $this->belongsToMany(Alumno::class,'alumno_parent','alumno_id');
    }
    public function teacher_of_child()
    {
        return $this->belongsToMany(Alumno::class,'alumno_teacher','user_id');
    }
    public function course_of_child()
    {
        return $this->hasMany(Alumno::class,'alumno_parent');
    }

    public function childs_of_course()
    {
        return $this->belongsToMany(Alumno::class,'alumno_curso','curso_id');
    }

    public function note_read_by()
    {
        return $this->hasMany(Note::class,'note_user');
    }
    public function note()
    {
        return $this->hasMany(Note::class);
    }

    public function alumno_parent(){
        return $this->belongsToMany(Alumno::class,'alumno_parent');
    }

    public function hijo(){
        return $this->belongsToMany(Alumno::class,'alumno_parent');
    }

    
    
}
