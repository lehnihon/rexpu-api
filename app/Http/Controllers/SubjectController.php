<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Subject;
use App\CPM;
use App\User;
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

    public function index(){
        $subject = Subject::where('active','1')->with(['users'])->orderBy('id', 'desc')->get();
        return response()->json($subject);
    }

    
    public function getByUserLink($user){
        $filter = function ($query) use($user) {
            $query->where('user_id',$user);
        };
        $subject = Subject::where('active','1')->whereHas('users', $filter)->with(['users' => $filter])->get();
        return response()->json($subject);
    }

    public function store(Request $request){
        $subject = new Subject;
        $users = User::all();
        $usersArray = array();

        $subject->title = $request->title;
        $subject->link = $request->link;
        $subject->obs = $request->obs;
        $subject->user_id = $request->user_id;
        $subject->suggestion_id = $request->suggestion_id;
        $subject->save();
        foreach($users as $user){ 
            $usersArray[$user->id] = ['link_hash' => bin2hex(random_bytes(16))];
        }
        $subject->users()->attach($usersArray);
        $subject->push();
        return response()->json(["error" => ""],200);
    }

    public function link($hash){
        $filter = function ($query) use($hash) {
            $query->where('link_hash',$hash);
        };

        $subject = Subject::whereHas('users', $filter)->with(['users' => $filter])->get();
        if($subject[0]->user->cpm_b == '0'){
            $cpm = CPM::where('role_id',3)->orderBy('id', 'desc')->first();
            $cpmr = $cpm->amount;
        }else{
            $cpmr = $subject[0]->user->cpm_b;
        }
        $subject[0]->user->amount = $subject[0]->user->amount+($cpmr/1000);
        $subject[0]->user->clicks_b = $subject[0]->user->clicks_b+1;
        $subject[0]->clicks = $subject[0]->clicks+1;
        $subject[0]->push();

        $subject = Subject::whereHas('users', $filter)->with(['users' => $filter])->get();
        if($subject[0]->users[0]->cpm_a == '0'){
            $cpm = CPM::where('role_id',2)->orderBy('id', 'desc')->first();
            $cpmp = $cpm->amount;
        }else{
            $cpmp = $subject[0]->users[0]->cpm_a;
        }
        $subject[0]->users[0]->amount = $subject[0]->users[0]->amount+($cpmp/1000);
        $subject[0]->users[0]->clicks_a = $subject[0]->users[0]->clicks_a+1;
        $subject[0]->push();
    
        return redirect()->to($subject[0]->link);
    }

    public function disable(Request $request){
        $subject = Subject::find($request->id);
        $subject->active = false;
        $subject->save();
        return response()->json(["error" => ""],200);
    }
}
