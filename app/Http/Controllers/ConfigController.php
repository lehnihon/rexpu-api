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

    public function edit(Config $config){
        $configFirst = $config->get()->first();
        return response()->json($configFirst);
    }

    public function update(Request $request,Config $config){
        $configFirst = $config->get()->first();
        $configFirst->wp_login = $request->wp_login;
        $configFirst->wp_password = $request->wp_password;
        $configFirst->save();
        return response()->json(["error" => ""],200);
    }
}
