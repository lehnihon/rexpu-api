<?php

namespace App\Http\Controllers;

use App\Financial;
use Illuminate\Http\Request;

class FinancialController extends Controller
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

    public function index(Financial $financial){
        $financialAll = $financial->orderBy('id', 'desc')->get();
        return response()->json($financialAll);
    }

    public function store(Request $request){
        $financial = new Financial;

        $financial->title = $request->title;
        $financial->done = false;
        $financial->amount = $request->amount;
        $financial->receipt = '';
        $financial->obs = $request->obs;
        $financial->user_id = $request->user_id;
        $financial->save();
        return response()->json(["error" => ""],200);
    }
    
    public function update($id, Request $request){
        $financial = Financial::find($id);
        $financial->title = $request->title;
        $financial->done = true;
        $financial->obs = $request->obs;
        if($request->receipt->isValid()){
            if($request->receipt->getSize() < 5000000){
                $filename = date('ymdhis').".".$request->receipt->extension();
                $financial->receipt = $filename;
                $resp = $request->receipt->move('.'.DIRECTORY_SEPARATOR."receipts".DIRECTORY_SEPARATOR,$filename);
            }else{
                return response()->json(["error" => "Arquivo maior que 5mb"],400);
            }
        }else{
            $financial->receipt = '';
        }
        $financial->save();
        return response()->json(["error" => ""],200);
    }

    public function getByUser($user){
        $financial = new Financial;
        $financialByUser = $financial->where('user_id',$user)->orderBy('id', 'desc')->get();
        return response()->json($financialByUser);
    }

}
