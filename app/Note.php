<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    protected $fillable = [
        'curso_id', 'user_id', 'subject', 'body', 'attached', 'status', 'sticky'
    ];
    protected $casts = [
         'attached' => 'array',
    ];

    public function getAttachedAttribute($value)
    {
        return json_decode($value,true);
    }
    public function setAttachedAttribute( $val )
        {
            $this->attributes['attached'] = json_encode($val);
        }
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
        return $this->belongsToMany(User::class,'note_user')->with('profile')->wherePivot('readed','=','1')->wherePivot('user_id','!=',auth()->user()->id);
    }
    public function unreaded()
    {
        return $this->belongsToMany(User::class,'note_user')->wherePivot('readed','=','0');
    }
    public function note_user()
    {
        return $this->belongsToMany(User::class,'note_user')->with('profile');
    }
    public function user()
    {
        return $this->belongsTo(User::class)->with('profile','roles');
    }

    public function author()
    {
        return $this->belongsTo(Profile::class,'user_id');
    }

    public function getUseremail_by_curso($user_id){
        
        return static::selectRaw('users.name, count(*) submitted_games')
            ->join('games', 'games.user_id', '=', 'users.id')
            ->groupBy('users.name')
            ->orderBy('submitted_games', 'DESC')
            ->get();
    }
}
