<?php

namespace App\Http\Controllers;

use App\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
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
        $partner = Partner::orderBy('id', 'desc')->get();
        return response()->json($partner);
    }

    public function active(){
        $partner = Partner::where('active',1)->orderBy('id', 'desc')->get();
        return response()->json($partner);
    }

    public function store(Request $request){
        $partner = new Partner;

        $partner->name = $request->name;
        $partner->save();
        return response()->json(["error" => ""],200);
    }

    public function update(Request $request){
        $partner = Partner::find($request->id);
        $partner->name = $request->name;
        $partner->active = $request->active;
        $partner->save();
        return response()->json(["error" => ""],200);
    }


}
