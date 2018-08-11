<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    protected $fillable = [
        'curso_id', 'user_id', 'subject', 'body', 'attached', 'status', 'sticky'
    ];

    
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
    public function students()
    {
        return $this->belongsTo(Alumno::class,'alumno_curso','curso_id');
    }
    public function readed()
    {
        return $this->belongsToMany(User::class,'note_user')->wherePivot('readed','=','1');
    }
    public function unreaded()
    {
        return $this->belongsToMany(User::class,'note_user')->wherePivot('readed','=','0');
    }
    public function note_user()
    {
        return $this->belongsToMany(User::class,'note_user');
    }
    public function user()
    {
        return $this->belongsTo(User::class)->with('profile','roles');
    }
}
