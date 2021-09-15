<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Student extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guarded=[];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'type'=>'student',
        ];
    }
     public function country(){
        return $this->belongsTo('App\Models\Country');
    }
     public function classroom(){
        return $this->belongsTo('App\Models\Classroom');
    }
     public function term(){
        return $this->belongsTo('App\Models\Term');
    }
}
