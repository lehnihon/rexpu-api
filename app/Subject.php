<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Subject extends Model
{

    public function suggestion()
    {
        return $this->hasOne('App\Suggestion');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
    
}
