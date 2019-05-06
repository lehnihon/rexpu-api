<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Financial extends Model
{
    public function user()
    {
        return $this->hasOne('App\User');
    }
    
}
