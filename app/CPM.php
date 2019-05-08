<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CPM extends Model
{
    protected $table = "cpms";

    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    
}
