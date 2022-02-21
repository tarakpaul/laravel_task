<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\User_details;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
class UserController extends Controller
{

  function user_listing(Request $req,$slug=''){ 
   $res=DB::table('user_details')
   ->rightjoin('users', 'users.id', '=', 'user_details.user_id')
   ->leftjoin('states', 'states.id', '=', 'user_details.state_id')
   ->where('users.name', 'LIKE', "%{$slug}%")
   ->orderBy('users.id','desc')
   ->get();
   return response()->json(['count'=>count($res),'data'=>$res]);

}
function user_save(Request $req){

   $validator=validator::make($req->all(),[
    'name'=>'required',
    'email'=>'required|email|unique:users',                      
    'password'=>'required',
    'gender'=>'required',
    'phone_no'=>'required', 
    'state_id'=>'required',
    'image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
],
[   
    'state_id.required'    => 'The state field is required',
    'image.image'          => 'The photo must be an image',
]);
   if($validator->fails()){
    return response()->json(['status'=>400,'errors'=>$validator->messages()]);
}
$User=new User;
$User->name=$req->input('name');
$User->email=$req->input('email');
$User->password=$req->input('password');
if($req->hasfile('image'))
{
    $file = $req->file('image');
    $extenstion = $file->getClientOriginalExtension();
    $filename = time().'.'.$extenstion;
    $file->move('uploads/user_image/', $filename);
    $User->image = $filename;
}

$User->save();
$user_details=new User_details;
$user_details->user_id=$User->id;
$user_details->gender=$req->input('gender');
$user_details->phone_no=$req->input('phone_no');
$user_details->alternate_phone_no=$req->input('alternate_phone_no');  
$user_details->state_id=$req->input('state_id');
$user_details->save();
return response()->json(['status'=>200,'message'=>'Data added successfully.']);
}
}
