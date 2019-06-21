<?php

namespace App\Http\Controllers;

use App\AskedQuestions;
use Illuminate\Http\Request;

class AskedQuestionsController extends Controller
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

    public function index(AskedQuestions $asked_questions){
        $asked_questionsAll = $asked_questions->orderBy('id', 'desc')->get();
        return response()->json($asked_questionsAll);
    }

    public function store(Request $request){
        $asked_questions = new AskedQuestions;

        $asked_questions->question = $request->question;
        $asked_questions->answer = $request->answer;
        $asked_questions->save();
        return response()->json(["error" => ""],200);
    }

    public function update(Request $request){
        
        return response()->json(["error" => ""],200);
    }

    public function delete($id){
        $asked_questions = AskedQuestions::find($id);
        $asked_questions->delete();
        return response()->json(["error" => ""],200);
    }

}
