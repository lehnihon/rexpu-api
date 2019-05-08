<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class GeneralConfig extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
