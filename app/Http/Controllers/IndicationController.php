<?php

namespace App\Http\Controllers;

use App\Indication;
use App\GeneralConfig;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class IndicationController extends Controller
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
        $indication = Indication::where('done','0')->orderBy('id', 'desc')->with(['user','indicated'])->get();
        return response()->json($indication);
    }

    public function update(Request $request,$id){
        $indication = Indication::find($id);
        $general_config = GeneralConfig::first();
        $perc = $general_config->perc_member/100;
        $amountBefore = $indication->user->amount;
        $value = $indication->amount*$perc;
        $indication->user->amount = $indication->user->amount+$value;
        $indication->done = true;
        $indication->push();
        $this->saveTransaction($indication->user->id,$indication->user->amount,$amountBefore,$value);
        return response()->json(["error" => ""],200);
    }

    public function link(Request $request){
        $indicated = $this->saveUser($request);
        $user = User::where('indication_hash',$request->indication_hash)->first();
        $user->indication = $user->indication+1;
        $user->save();
        $this->saveIndication($user->id,$indicated);
    }

    private function saveUser($request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = app('hash')->make($request->password);
        $user->indication_hash = bin2hex(random_bytes(10));
        $user->wp_user = $request->wp_user;
        $user->wp_login = $request->wp_login;
        $user->wp_password = $request->wp_password;
        $user->active = true;
        $user->save();
        return $user->id;
    }

    private function saveIndication($user,$indicated){
        $indication = new Indication();
        $indication->user_id = $user;
        $indication->indicated_id = $indicated;
        $indication->save();
    }

    private function saveTransaction($id,$amount,$amountB,$value){
        $transaction = new Transaction();
        $transaction->title = "Crédito Indicação";
        $transaction->amount = $amount;
        $transaction->amount_before = $amountB;
        $transaction->value = $value;
        $transaction->user_id = $id;
        $transaction->save();
    }
    
}
