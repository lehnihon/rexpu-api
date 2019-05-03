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

    public function store(Request $request){
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = app('hash')->make($request->password);
        $user->active = true;
        $user->save();
        return response()->json(["error" => ""],200);
    }

    public function update(Request $request){
        
        return response()->json(["error" => ""],200);
    }
}
