<?php

namespace App\Http\Controllers;

use App\GeneralConfig;
use Illuminate\Http\Request;

class GeneralConfigController extends Controller
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
        $general_config = GeneralConfig::first();
        return response()->json($general_config);
    }

    public function store(Request $request){
        $general_config = new GeneralConfig;
        $general_config->perc_member = $request->perc_member;
        $general_config->save();
        return response()->json(["error" => ""],200);
    }

    public function update(Request $request){
        $general_config = GeneralConfig::get()->first();
        if(!empty($request->perc_member)){
            $general_config->perc_member = $request->perc_member;
        }
        $general_config->save();
        return response()->json(["error" => ""],200);
    }

}
