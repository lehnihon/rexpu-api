<?php

namespace App\Http\Controllers;

use App\User;
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
        $userAll = $user->orderBy('id', 'desc')->with(['role'])->get();
        return response()->json($userAll);
    }

    public function show($user){
        $user = User::find($user);
        return response()->json($user);
    }

    public function store(Request $request){
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = app('hash')->make($request->password);
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
        if(!empty($request->bank)){
            $user->bank = $request->bank;
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
            $user->role()->attach($roles);
        }
        $user->save();
        return response()->json(["error" => ""],200);
    }
}
