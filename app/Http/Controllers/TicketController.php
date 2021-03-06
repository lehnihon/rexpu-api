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

    public function index(){
        $ticket = Ticket::with('user')->orderBy('id', 'desc')->get();
        return response()->json($ticket);
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
        $ticketByUser = Ticket::with('user')->where('user_id',$user)->orderBy('id', 'desc')->get();
        return response()->json($ticketByUser);
    }
}
