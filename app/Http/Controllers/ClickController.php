<?php

namespace App\Http\Controllers;

use App\Click;
use App\User;
use Illuminate\Http\Request;

class ClickController extends Controller
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

    public function clicksByUser(){
        $filter = function ($query) {
            $query->whereBetween('created_at', [date('Y-m-d')." 00:00" , date('Y-m-d')." 23:59"]);
        };
        $user = User::where('active','1')->with(['clicks' => $filter])->orderBy('id', 'desc')->get();
        return response()->json($user);
    }

    public function clicksByUserWhere(Request $request){
        $from = $request->from;
        $to = $request->to;
        $filter = function ($query) use($from,$to) {
            $query->whereBetween('created_at', [$from." 00:00" , $to." 23:59"]);
        };
        $user = User::where('active','1')->with(['clicks' => $filter])->orderBy('id', 'desc')->get();
        return response()->json($user);
    }

}
