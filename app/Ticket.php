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
        return $this->belongsTo('App\User');
    }

    public function obs()
    {
        return $this->belongsToMany('App\TicketObs');
    }
    
}
