<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\registrationController;
use App\Http\Controllers;
use App\Http\Controllers\loginController;
//include 'App\config\pathConfig.php';

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




Route::get('/home', function(){
    return 'home';
});
Route::post('/home', function(){
    return 'home';
});

Route::get('/register', 'App\Http\Controllers\registrationController@create')->middleware('guest');
Route::post('register', 'App\Http\Controllers\registrationController@store')->middleware('guest');

Route::get('/test', 'App\Http\Controllers\registrationController@test');

Route::get('/login',[loginController::class,'loginView'])->name('/')->middleware('guest');
Route::post('login',[loginController::class,'loginWithRequest'])->name('/')->middleware('guest');

Route::get("checkLogin", function(){
    return "<h1>".Auth::id()."</h1><br></br>";
});


Route::get('/logout', 'App\Http\Controllers\logoutController@logout'); 
Route::post('/logout', 'App\Http\Controllers\logoutController@logout'); 
 
 
 
