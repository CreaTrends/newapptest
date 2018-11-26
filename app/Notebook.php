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

    protected $dates = [
        'start_at',
        'time'
    ];
    protected $appends = ['date','css','name','info'];

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
        $array[$this->activity_type] = json_decode($value);
        return json_decode($value);
    }
    public function getAttachedAttribute($value)
    {
        return json_decode($value);
    }

    public function getDateAttribute()
    {
        return \Carbon\Carbon::parse($this->notebook_date)->diffForHumans();
    }

    public function getTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->notebook_date);
    }

    public function getNameAttribute()
    {
        return Alumno::findorfail($this->alumno_id)->firstname;
    }

    public function getInfoAttribute()
    {
        $var = $this->data;
        
        if(is_array($var)){
            foreach($var as $value){
                foreach($value as $k=>$v){
                    $rr[] =$v;
                }
            }
        }
        
        

        return is_array($var) ? $rr : $this->data;
    }

    public function getCssAttribute()
    {
        $css= array(
            'food' => array(
                'icon' => 'icofont icofont-fast-food',
                'bg-color'=>'is-green'
            ),
            'mood' => array(
                'icon' => 'icofont icofont-emo-laughing',
                'bg-color'=>'is-lightgreen'
            ),
            'nap' => array(
                'icon' => 'icofont icofont-bed',
                'bg-color'=>'is-yellow'
            ),
            'deposition' => array(
                'icon' => 'icofont icofont-baby-cloth',
                'bg-color'=>'is-orange'
            ),
            'photo' => array(
                'icon' => 'icofont icofont-camera',
                'bg-color'=>'is-default'
            ),
            'nota' => array(
                'icon' => 'icofont icofont-notepad',
                'bg-color'=>'is-purple'
            ),
            'activity' => array(
                'icon' => 'icofont icofont-abc',
                'bg-color'=>'is-pink'
            ),
            
        );
        return $css[$this->activity_type];
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
