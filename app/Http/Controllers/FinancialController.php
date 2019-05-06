<?php

namespace App\Http\Controllers;

use App\Financial;
use Illuminate\Http\Request;

class FinancialController extends Controller
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

    public function index(Financial $financial){
        $financialAll = $financial->orderBy('id', 'desc')->get();
        return response()->json($financialAll);
    }

    public function store(Request $request){
        $financial = new Financial;

        $financial->title = $request->title;
        $financial->done = $request->done;
        $financial->amount = $request->amount;
        $financial->error = $request->error;
        $financial->error_obs = $request->error_obs;
        $financial->user_id = $request->user_id;
        $financial->save();
        return response()->json(["error" => ""],200);
    }

    public function getByUser($user){
        $financial = new Financial;
        $financialByUser = $financial->where('user_id',$user)->orderBy('id', 'desc')->get();
        return response()->json($financialByUser);
    }

    public function update(Request $request){
        
        return response()->json(["error" => ""],200);
    }

}
