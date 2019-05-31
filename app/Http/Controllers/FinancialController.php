<?php

namespace App\Http\Controllers;

use App\Financial;
use App\Transaction;
use App\User;
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

    public function index(){
        $financial = Financial::with('user')->orderBy('id', 'desc')->get();
        return response()->json($financial);
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
        
        $this->debitUser($financial->user_id,$request->title,$financial->amount);
        
        return response()->json(["error" => ""],200);
    }

    public function updateb($id, Request $request){
        $financial = Financial::find($id);
        $financial->title = $request->title;
        $financial->done = true;
        $financial->obs = $request->obs;
        $financial->save();
        return response()->json(["error" => ""],200);
    }

    public function getByUser($user){
        $financialByUser = Financial::with('user')->where('user_id',$user)->orderBy('id', 'desc')->get();
        return response()->json($financialByUser);
    }

    private function debitUser($id,$title,$amount){
        $user = User::find($id);
        $amountBefore = $user->amount;
        $user->amount = ($user->amount-$amount);
        $user->save();

        $transaction = new Transaction();
        $transaction->title = $title;
        $transaction->amount = $user->amount;
        $transaction->amount_before = $amountBefore;
        $transaction->value = $amount;
        $transaction->user_id = $id;
        $transaction->save();
    }

}
