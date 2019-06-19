<?php

namespace App\Http\Controllers;

use App\User;
Use App\Click;
use Illuminate\Http\Request;

class UserController extends Controller
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

    public function index(User $user){
        $user = User::orderBy('id', 'desc')->with(['role'])->get();
        return response()->json($user);
    }

    public function orderByEmail(){
        $user = User::orderBy('email', 'asc')->get();
        return response()->json($user);
    }

    public function show($userid){
        $user = User::find($userid);
        return response()->json($user);
    }

    public function showFull($userid){
        $data = null;
        $data['user'] = User::find($userid);
        $data['clicks_redator'] = Click::where('user_id',$userid)->where('role_id',3)->whereDate('created_at',date('Y-m-d'))->count();
        $data['clicks_publisher'] = Click::where('user_id',$userid)->where('role_id',2)->whereDate('created_at',date('Y-m-d'))->count();
        $data['value_redator'] = Click::where('user_id',$userid)->where('role_id',3)->whereDate('created_at',date('Y-m-d'))->sum('value');
        $data['value_publisher'] = Click::where('user_id',$userid)->where('role_id',2)->whereDate('created_at',date('Y-m-d'))->sum('value');

        return response()->json($data);
    }

    public function store(Request $request){
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = app('hash')->make($request->password);
        if(isset($request->fonts)){
            $user->fonts = $request->fonts;
        }
        $user->indication_hash = bin2hex(random_bytes(10));
        $user->wp_user = $request->wp_user;
        $user->wp_login = $request->wp_login;
        $user->wp_password = $request->wp_password;
        $user->active = true;
        
        $user->save();
        return response()->json(["error" => ""],200);
    }

    public function toAccepted(Request $request){
        $userAll = User::where('accepted','0')->orderBy('id', 'desc')->get();
        return response()->json($userAll);
    }

    public function accepted($user){
        $user = User::find($user);
        $user->accepted = '1';
        $user->save();
        return response()->json(["error" => ""],200);
    }

    public function notAccepted($user){
        $user = User::find($user);
        $user->accepted = '2';
        $user->save();
        return response()->json(["error" => ""],200);
    }
    
    public function update(Request $request){
        $user = User::find($request->id);
        if(!empty($request->name)){
            $user->name = $request->name;
        }
        if(!empty($request->email)){
            $user->email = $request->email;
        }
        if(!empty($request->password)){
            $user->password = app('hash')->make($request->password);
        }
        if(isset($request->accepted)){
            $user->accepted = $request->accepted;
        }
        if(isset($request->active)){
            $user->active = $request->active;
        }
        if(!empty($request->wp_user)){
            $user->wp_user = $request->wp_user;
        }
        if(!empty($request->wp_login)){
            $user->wp_login = $request->wp_login;
        }
        if(!empty($request->wp_password)){
            $user->wp_password = $request->wp_password;
        }
        if(!empty($request->favored)){
            $user->favored = $request->favored;
        }
        if(!empty($request->type)){
            $user->type = $request->type;
        }

        if(!empty($request->bank_id)){
            $user->bank_id = $request->bank_id;
        }
        if(!empty($request->agency)){
            $user->agency = $request->agency;
        }
        if(!empty($request->account)){
            $user->account = $request->account;
        }
        if(!empty($request->cpf)){
            $user->cpf = $request->cpf;
        }
        if(isset($request->cpm_a)){
            $user->cpm_a = $request->cpm_a;
        }
        if(isset($request->cpm_b)){
            $user->cpm_b = $request->cpm_b;
        }
        if(isset($request->role)){
            $roles = array();
            if($request->role['adm']){
                $roles[] = 1;
            }
            if($request->role['pub']){
                $roles[] = 2;
            }
            if($request->role['red']){
                $roles[] = 3;
            }
            $user->role()->sync($roles);
        }
        if(isset($request->fonts)){
            $user->fonts = $request->fonts;
        }
        $user->save();
        return response()->json(["error" => ""],200);
    }
}
