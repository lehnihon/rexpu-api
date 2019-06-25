<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Earning extends Model
{
    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }
}
