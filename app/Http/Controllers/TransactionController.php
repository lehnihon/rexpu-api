<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
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

    public function index(Request $request){
        $from = $request->from;
        $to = $request->to;
        $transaction = Transaction::with('user')->whereBetween('created_at', [$from." 00:00" , $to." 23:59"])->orderBy('id', 'desc')->get();
        return response()->json($transaction);
    }

}
