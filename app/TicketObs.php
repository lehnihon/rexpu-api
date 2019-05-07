<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TicketObs extends Model
{

    public function ticket()
    {
        return $this->hasOne('App\Ticket');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    
}
