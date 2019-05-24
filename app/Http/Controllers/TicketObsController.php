<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\TicketObs;
use Illuminate\Http\Request;

class TicketObsController extends Controller
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
        $ticketAll = $ticket->all();
        return response()->json($ticketAll);
    }

    public function store(Request $request){
        $ticketObs = new TicketObs;
        $ticketObs->ticket_id = $request->ticket_id;
        $ticketObs->user_id = $request->user_id;
        $ticketObs->obs = $request->obs;
        $ticketObs->save();
        return response()->json(["error" => ""],200);
    }

    public function update(Request $request){
        
        return response()->json(["error" => ""],200);
    }

    public function getByTicket($ticket){
        $ticketObsByTicket = TicketObs::with('ticket.user')->where('ticket_id',$ticket)->orderBy('id', 'desc')->get();
        return response()->json($ticketObsByTicket);
    }

}
