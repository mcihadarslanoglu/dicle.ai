<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\registrationController;
use App\Http\Controllers;
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





Route::get('/register', 'App\Http\Controllers\registrationController@create');
Route::post('register', 'App\Http\Controllers\registrationController@store');

Route::get("checkLogin", function(){
    return "<h1>".Auth::id()."</h1>";
});
//Route::get('/login', 'SessionsController@create');
//Route::post('/login', 'SessionsController@store');

Route::get('/logout', 'App\Http\Controllers\registrationController@logout'); 
 
 
 
 
