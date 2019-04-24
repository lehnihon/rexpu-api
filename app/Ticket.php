<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Ticket extends Model
{
    protected $fillable = [
        'title', 'description'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }
    
}
