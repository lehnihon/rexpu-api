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
        $userAll = $user->orderBy('id', 'desc')->get();
        return response()->json($userAll);
    }

    public function show($user){
        $user = User::find($user)->first();
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
        $user = User::find($user)->first();
        $user->accepted = true;
        $user->save();
        return response()->json(["error" => ""],200);
    }
    
    public function update(Request $request){
        $user = User::find($request->id)->first();
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
        $user->save();
        return response()->json(["error" => ""],200);
    }
}
