<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Term extends Model implements TranslatableContract
{
    use Translatable;
    protected $guarded = [];

    public $translatedAttributes = ['name'];
    public function student(){
        return $this->hasMany('App\Model\Student','student_id');
    }

}
