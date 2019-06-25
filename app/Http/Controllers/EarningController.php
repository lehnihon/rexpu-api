<?php

namespace App\Http\Controllers;

use App\Earning;
use Illuminate\Http\Request;

class EarningController extends Controller
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
        $earning = Earning::with('partner')->orderBy('id', 'desc')->get();
        return response()->json($earning);
    }

    public function report(Request $request){
        $from = $request->from;
        $to = $request->to;
        $earning = Earning::with('partner')->whereBetween('date_earning', [$from." 00:00" , $to." 23:59"])->orderBy('id', 'desc')->get();
        return response()->json($earning);
    }

    public function store(Request $request){
        $earning = new Earning;

        $earning->value = str_replace(",",".",$request->value);
        $earning->partner_id = $request->partner_id;
        $earning->date_earning = $request->date_earning;
        
        $earning->save();
        return response()->json(["error" => ""],200);
    }

    public function delete($id){
        $earning = Earning::find($id);
        $earning->delete();
        return response()->json(["error" => ""],200);
    }

}
