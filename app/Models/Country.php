<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Country extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = [];
    protected $primaryKey = 'id';
    public function classroom(){
        return $this->hasMany('App\Models\Classroom','country_id');
    }
    public function teacher(){
        $this->hasMany('App\Models\Teacher','country_id');
    }
    public function Student(){
        $this->hasMany('App\Models\Student','country_id');
    }


}
