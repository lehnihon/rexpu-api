<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Suggestion extends Model
{

    public function subject()
    {
        return $this->hasOne('App\Subject');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
