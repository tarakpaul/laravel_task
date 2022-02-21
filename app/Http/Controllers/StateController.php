<?php

namespace App\Http\Controllers;
use App\Models\State;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;


class StateController extends Controller
{
    function state_listing(Request $req){
    	// $res=State::get();
    	// return $res;
        return response()->json(['total_state'=>count(State::get()),'state_a'=>State::get()]);

    }
    function state_save(Request $req){
    	$validator=validator::make($req->all(),['state_name'=>'required']);
        if($validator->fails()){
            return response()->json(['status'=>400,'errors'=>$validator->messages()]);
        }
    	$state=new State;
    	$state->state_name=$req->input('state_name');
    	$state->save();
    	return response()->json(['status'=>200,'message'=>'Data added successfully.']);
    }
    function delete_state(Request $req){
        $res=State::find($req->input('state_id'));
        $res->delete();
        return response()->json(['status'=>200,'message'=>'Data deleted successfully.']);

    }
}
