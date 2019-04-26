<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
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

    public function index(Config $config){
        $configFirst = $config->get()->first();
        return response()->json($configFirst);
    }

    public function store(Request $request){
        $subject = new Subject;

        $subject->title = $request->title;
        $subject->link = $request->link;
        $subject->obs = $request->obs;
        $subject->user_id = $request->user_id;
        $suggestion->save();
        return response()->json(["error" => ""],200);
    }


    public function update(Request $request,Config $config){
        
        return response()->json(["error" => ""],200);
    }
}
