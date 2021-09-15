<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Subject extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = [];
    protected $primaryKey = 'id';
    public function teacher(){
        $this->hasMany('App\Models\Teacher','subject_id');
    }
}
