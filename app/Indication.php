<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Indication extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function indicated()
    {
        return $this->belongsTo('App\User','indicated_id');
    }
    
}
