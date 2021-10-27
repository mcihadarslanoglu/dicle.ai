<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\registrationController;
use App\Http\Controllers;
use App\Http\Controllers\loginController;
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




Route::get('/', function(){
    return 'home';
});
Route::post('/', function(){
    return 'home';
});

Route::get('/register', 'App\Http\Controllers\registrationController@create')->name('/');
Route::post('register', 'App\Http\Controllers\registrationController@store')->name('/');



Route::get('/login',[loginController::class,'loginView'])->name('/');
Route::post('login',[loginController::class,'loginWithRequest'])->name('/');

Route::get("checkLogin", function(){
    return "<h1>".Auth::id()."</h1>";
});


Route::get('/logout', 'App\Http\Controllers\logoutController@logout'); 
Route::post('/logout', 'App\Http\Controllers\logoutController@logout'); 
 
 
 
