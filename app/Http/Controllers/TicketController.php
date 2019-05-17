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
        $ticketAll = $ticket->orderBy('id', 'desc')->get();
        return response()->json($ticketAll);
    }

    public function store(Request $request){
        $ticket = new Ticket;

        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->user_id = $request->user_id;
        $ticket->save();
        return response()->json(["error" => ""],200);
    }

    public function update(Request $request){
        
        return response()->json(["error" => ""],200);
    }

    public function getByUser($user){
        $ticket = new Ticket;
        $ticketByUser = $ticket->where('user_id',$user)->orderBy('id', 'desc')->get();
        return response()->json($ticketByUser);
    }
}
