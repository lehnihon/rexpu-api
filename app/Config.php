<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Config extends Model
{
    protected $fillable = [
        'wp_login', 'wp_password','wp_user'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }
    
}
