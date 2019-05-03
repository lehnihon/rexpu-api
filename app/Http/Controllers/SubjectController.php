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

    public function index(Subject $subject){
        $subjectAll = $subject->all();
        return response()->json($subjectAll);
    }

    public function store(Request $request){
        $subject = new Subject;

        $subject->title = $request->title;
        $subject->link = $request->link;
        $subject->obs = $request->obs;
        $subject->user_id = $request->user_id;
        $subject->suggestion_id = $request->suggestion_id;
        $subject->save();
        return response()->json(["error" => ""],200);
    }


    public function update(Request $request,Config $config){
        
        return response()->json(["error" => ""],200);
    }
}
