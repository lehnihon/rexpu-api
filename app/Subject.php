<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Subject extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function users()
    {
        return $this->belongsToMany('App\User')
            ->withPivot('link_hash')
    	    ->withTimestamps();
    }


    public function clicks()
    {
        return $this->hasMany('App\Click');
    }

}
