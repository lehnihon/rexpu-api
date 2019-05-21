<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Subject;
use App\CPM;
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
        $subject->link_hash = md5($request->link);
        $subject->obs = $request->obs;
        $subject->user_id = $request->user_id;
        $subject->suggestion_id = $request->suggestion_id;
        $subject->save();
        return response()->json(["error" => ""],200);
    }

    public function link($hash){
        $subject = Subject::where('link_hash',$hash)->first();
        $cpmp = CPM::where('role_id',2)->orderBy('id', 'desc')->first();
        $cpmr = CPM::where('role_id',3)->orderBy('id', 'desc')->first();

        $subject->user->amount = $subject->user->amount+($cpmr->amount/1000);
        $subject->user->clicks_b = $subject->user->clicks_b+1;
        $subject->clicks = $subject->clicks+1;
        $subject->push();
        $subject->suggestion->user->amount = $subject->suggestion->user->amount+($cpmp->amount/1000);
        $subject->suggestion->user->clicks_a = $subject->suggestion->user->clicks_a+1;
        $subject->push();
    
        return redirect()->to($subject->link);
    }

    public function update(Request $request,Config $config){
        
        return response()->json(["error" => ""],200);
    }
}
