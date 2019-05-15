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

    public function index(CPM $cpm){
        $cpmAll = $cpm::with('role')->orderBy('id', 'desc')->get();
        return response()->json($cpmAll);
    }

    public function store(Request $request){
        $cpm = new CPM;

        $cpm->role_id = $request->role_id;
        $cpm->amount = $request->amount;
        $cpm->save();
        return response()->json(["error" => ""],200);
    }

}
