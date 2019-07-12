<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Subject;
use App\CPM;
use App\User;
use App\Click;
use App\Indication;
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
        $subject = Subject::where('active','1')->whereHas('users', $filter)->withCount(['clicks' => $filter])->with(['users' => $filter])->orderBy('id', 'desc')->get();
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
        $subject->save();
        foreach($users as $user){ 
            $usersArray[$user->id] = ['link_hash' => bin2hex(random_bytes(16))];
        }
        $subject->users()->attach($usersArray);
        $subject->push();
        return response()->json(["error" => ""],200);
    }

    public function storeList(Request $request){
        $userid = $request->user;
        foreach($request->subjects as $sub){
            $check_id = Subject::where('wp_subject_id',$sub['id'])->first();
            if(!$check_id){
                $subject = new Subject;
                $users = User::all();
                $usersArray = array();
                $subject->title = $sub['title']['rendered'];
                $subject->link = $sub['link'];
                $subject->wp_subject_id = $sub['id'];
                $subject->wp_subject_modified = $sub['modified'];
                if(!empty($sub['_embedded']['wp:featuredmedia'])){
                    $subject->wp_subject_img = $sub['_embedded']['wp:featuredmedia'][0]['source_url'];
                }else{
                    $subject->wp_subject_img = '';
                }
                $subject->user_id = $userid;
                $subject->save();
                foreach($users as $user){ 
                    $usersArray[$user->id] = ['link_hash' => bin2hex(random_bytes(16))];
                }
                $subject->users()->attach($usersArray);
                $subject->push();
            }else{
                $check_modified = Subject::where('wp_subject_modified',$sub['modified'])->first();
                if(!$check_modified){
                    $check_id->title = $sub['title']['rendered'];
                    $check_id->link = $sub['link'];
                    $check_id->wp_subject_modified = $sub['modified'];
                    if(!empty($sub['_embedded']['wp:featuredmedia'])){
                        $check_id->wp_subject_img = $sub['_embedded']['wp:featuredmedia'][0]['source_url'];
                    }else{
                        $check_id->wp_subject_img = $sub['_embedded']['wp:featuredmedia'][0]['source_url'];
                    }
                    $check_id->save();
                }
            }
        }
        
        return response()->json(["error" => ""],200);
    }

    public function link($hash, Request $request){
        $ip = $request->ip();

        $filter = function ($query) use($hash) {
            $query->where('link_hash',$hash);
        };

        $subject = Subject::whereHas('users', $filter)->with(['users' => $filter])->first();
        $click = Click::where('ip',$ip)->where('subject_id',$subject->id)->first();

        if(!$click){
            $cpmr = $this->getCPM($subject->user->cpm_b,3);
            $this->saveIndication($subject->user,$cpmr);
            $this->saveClick($subject,$subject->user,$cpmr,3,$ip);
            $subject->user->amount = $subject->user->amount+$cpmr;
            $subject->user->clicks_b = $subject->user->clicks_b+1;
            $subject->clicks = $subject->clicks+1;
            $subject->push();

            $subject = Subject::whereHas('users', $filter)->with(['users' => $filter])->first();
            $cpmp = $this->getCPM($subject->users[0]->cpm_a,2);
            $this->saveIndication($subject->users[0],$cpmp);
            $this->saveClick($subject,$subject->users[0],$cpmp,2,$ip);
            $subject->users[0]->amount = $subject->users[0]->amount+$cpmp;
            $subject->users[0]->clicks_a = $subject->users[0]->clicks_a+1;
            $subject->push();
        }
        return redirect()->to($subject->link);
    }

    public function disable(Request $request){
        $subject = Subject::find($request->id);
        $subject->active = false;
        $subject->save();
        return response()->json(["error" => ""],200);
    }

    private function saveIndication($user,$cpm){
        $currentDt = date_create(date('Y-m-d H:i:s'));
        $userDt = date_create($user->created_at);
        $diff = date_diff($userDt,$currentDt);
        if($diff->d < 30){
            $indication = Indication::where('indicated_id',$user->id)->first();
            if($indication){
                $indication->clicks = $indication->clicks+1;
                $indication->amount = $indication->amount+$cpm;
                $indication->save();
            }
        }
    }

    private function saveClick($subject,$user,$value,$role,$ip){
        $click = new Click();
        $click->value = $value;
        $click->clicks = $subject->clicks;
        $click->user_id = $user->id;
        $click->role_id = $role;
        $click->subject_id = $subject->id;
        $click->ip = $ip;
        $click->save();
    }

    private function getCPM($cpm,$role){
        if($cpm == '0'){
            $cpmStar = CPM::where('role_id',$role)->orderBy('id', 'desc')->first();
            return ($cpmStar->amount/1000);
        }else{
            return ($cpm/1000);
        }
    }

    public function report(Request $request){
        $user = $request->user;
        $from = $request->from;
        $to = $request->to;
        $filter = function ($query) use($user,$from,$to) {
            $query->where('user_id',$user)->whereBetween('created_at', [$from." 00:00" , $to." 23:59"]);
        };
        $subject = Subject::where('active','1')->withCount(['clicks' => $filter])->orderBy('id', 'desc')->get();
        return response()->json($subject);
    }
    
}
