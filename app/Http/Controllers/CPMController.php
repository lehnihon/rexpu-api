<?php

namespace App\Http\Controllers;

use App\CPM;
use Illuminate\Http\Request;

class CPMController extends Controller
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
        $cpm->amount = str_replace(",",".",$request->amount);
        $cpm->save();
        return response()->json(["error" => ""],200);
    }

    public function update(Request $request){
        
        return response()->json(["error" => ""],200);
    }

    public function getLastCPM(){
        $data = array();
        $data['publisher'] = CPM::where('role_id',2)->orderBy('id', 'desc')->first();
        $data['redator'] = CPM::where('role_id',3)->orderBy('id', 'desc')->first();
        return response()->json($data);
    }

}
