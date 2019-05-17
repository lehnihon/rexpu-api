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
        $subjectAll = $subject->orderBy('id', 'desc')->get();
        return response()->json($subjectAll);
    }

    public function store(Request $request){
        $subject = new Subject;

        $subject->title = $request->title;
        $subject->link = $request->link;
        $subject->link_hash = urlencode(app('hash')->make($request->link));
        $subject->obs = $request->obs;
        $subject->user_id = $request->user_id;
        $subject->suggestion_id = $request->suggestion_id;
        $subject->save();
        return response()->json(["error" => ""],200);
    }

    public function link($hash){
        $subject = Subject::where('link_hash',$hash)->first();
        return response()->json($subject->link);
    }

    public function update(Request $request,Config $config){
        
        return response()->json(["error" => ""],200);
    }
}
