<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Classroom extends Model implements TranslatableContract
{
    use Translatable;
    

    public $translatedAttributes = ['name'];
    protected $guarded = [];
    public function country(){
        return $this->belongsTo('App\Models\Country');
    }
    public function student(){
        return $this->hasMany('App\Model\Student','student_id');
    }
}
