<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Ticket $ticket){
        $ticket = $ticket->all();
        return response()->json($ticket);
    }

    public function update(){
       
    }

    public function showByUser($user){
        var_dump($user);
    }
}
