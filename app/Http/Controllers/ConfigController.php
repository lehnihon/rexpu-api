<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
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

    public function index(Config $config){
        $configFirst = $config->get()->first();
        return response()->json($configFirst);
    }

    public function update(Request $request,Config $config){
        $configFirst = $config->where('user_id',$request->user_id)->first();
        if(!empty($request->wp_user)){
            $configFirst->wp_user = $request->wp_user;
        }
        if(!empty($request->wp_login)){
            $configFirst->wp_login = $request->wp_login;
        }
        if(!empty($request->wp_password)){
            $configFirst->wp_password = $request->wp_password;
        }
        if(!empty($request->bank)){
            $configFirst->bank = $request->bank;
        }
        if(!empty($request->agency)){
            $configFirst->agency = $request->agency;
        }
        if(!empty($request->account)){
            $configFirst->account = $request->account;
        }
        if(!empty($request->cpf)){
            $configFirst->cpf = $request->cpf;
        }
        $configFirst->save();
        return response()->json(["error" => ""],200);
    }
}
