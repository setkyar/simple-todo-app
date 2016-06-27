<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	return view('home');
});

use App\Tasks;
use Illuminate\Http\Request;

Route::get('/tasks', function() {
	return Tasks::select(['id', 'description'])->get()->toArray();
});

Route::post('/addtask', function(Request $request) {
	
	$data = $request->all();

	$task = Tasks::create($data);

	return [
		'id' => $task->id, 
		'description' => $task->description
	];
});

Route::delete('/deletetask/{id}', function(Request $request, $id) {
	Tasks::find($id)->delete();
});