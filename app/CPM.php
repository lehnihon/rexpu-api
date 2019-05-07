<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CPM extends Model
{

    public function role()
    {
        return $this->hasOne('App\Role');
    }
    
}
