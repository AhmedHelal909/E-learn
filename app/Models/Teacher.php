<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Teacher extends Authenticatable implements JWTSubject
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
            'type'=>'teacher',
        ];
    }
    public function country(){
        return $this->belongsTo('App\Models\Country');
    }
    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }
}
