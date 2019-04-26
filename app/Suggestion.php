<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Suggestion extends Model
{

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
    
}
