<?php

namespace App\Http\Controllers;

use App\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
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

    public function index(Suggestion $suggestion){
        $suggestionAll = $suggestion->orderBy('id', 'desc')->get();
        return response()->json($suggestionAll);
    }

    public function store(Request $request){
        $suggestion = new Suggestion;

        $suggestion->title = $request->title;
        $suggestion->link = $request->link;
        $suggestion->description = $request->description;
        $suggestion->user_id = $request->user_id;
        $suggestion->save();
        return response()->json(["error" => ""],200);
    }

    public function update(Request $request){
        
        return response()->json(["error" => ""],200);
    }


    public function delete($id){
        $suggestion = Suggestion::find($id);
        $suggestion->delete();
        return response()->json(["error" => ""],200);
    }
    
}
