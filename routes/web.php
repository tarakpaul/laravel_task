<?php
use Illuminate\Support\Facades\Route;
use App\Models\State;
use App\Models\User;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('login',function(){
	if(session()->has('admin_data')){
		return redirect('/');
	}
	return view('login');
});

Route::post('login/check','App\Http\Controllers\LoginController@login_check')->name('login.check');
Route::get('logout',function(){
	session()->forget('admin_data');
	return redirect('login');
});


Route::group(['middleware'=>'AdminCheck'],function(){	
	Route::get('/', function () {
		return view('dashboard')->with(['dashboard_data'=>['total_state'=>count(State::all()),'total_user'=>count(User::all())]]);
	})->name('dashboard');

	Route::get('state', function () {
		return view('state');
	});

	Route::get('state_listing','App\Http\Controllers\StateController@state_listing');
	Route::post('state_save','App\Http\Controllers\StateController@state_save');
	Route::post('delete_state','App\Http\Controllers\StateController@delete_state');
	// Route::get('user/index','App\Http\Controllers\UserController@index');
	Route::get('user', function () {
		return view('user')->with('state_a',State::all()->sortBy('state_name'));
	});
	Route::get('user_listing/{slug?}','App\Http\Controllers\UserController@user_listing');
	Route::post('user_save','App\Http\Controllers\UserController@user_save');
});
