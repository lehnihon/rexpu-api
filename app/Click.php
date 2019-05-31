<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Click extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    
}
