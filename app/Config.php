<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Config extends Model
{
    protected $fillable = [
        'wp_login', 'wp_password',
    ];
}
