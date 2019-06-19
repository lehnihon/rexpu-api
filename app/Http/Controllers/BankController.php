<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
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
        $bank = Bank::orderBy('id', 'desc')->get();
        return response()->json($bank);
    }

    public function active(){
        $bank = Bank::where('active',1)->orderBy('id', 'desc')->get();
        return response()->json($bank);
    }

    public function store(Request $request){
        $bank = new Bank;

        $bank->name = $request->name;
        $bank->save();
        return response()->json(["error" => ""],200);
    }

    public function update(Request $request){
        $bank = Bank::find($request->id);
        $bank->name = $request->name;
        $bank->active = $request->active;
        $bank->save();
        return response()->json(["error" => ""],200);
    }


}
