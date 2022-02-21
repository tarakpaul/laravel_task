<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\validator;
class LoginController extends Controller
{
	function index(){
		return view('login');
	}
	function login_check(Request $req){

		$validator=validator::make($req->all(),['username'=>'required','password'=>'required']);
		if($validator->fails()){
			return response()->json(['type'=>'validation_error','errors'=>$validator->messages()]);
		}
		$admin_data=DB::table('admins')
		->where(['user_name'=>$req->input('username'),'password'=>$req->input('password')])
		->get();
		if(count($admin_data)>0){
			$req->session()->put('admin_data',$admin_data);
			return response()->json(['type'=>'success','message'=>$admin_data]);
		}
		else{
			return response()->json(['type'=>'login_error','message'=>'Incorrect Login Details.']);
		}
	}
}
