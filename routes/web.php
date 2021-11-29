<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\registrationController;
use App\Http\Controllers;
use App\Http\Controllers\loginController;
use App\Http\Controllers\userFolderController;
use App\Http\Controllers\imageClassificationController;
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

Route::get('/login',[loginController::class,'loginView'])->middleware('guest');
Route::post('login',[loginController::class,'loginWithRequest'])->middleware('guest');

Route::get('listFolders',[userFolderController::class,'listFolder'])->middleware('auth');
Route::get('deleteDir',[userFolderController::class,'deleteDir'])->middleware('auth'); //-->kullanılırken post yapılacak.

Route::get('upload',function(){
    return view('upload');
})->middleware('auth');
Route::post('upload/classification', [imageClassificationController::class, 'uploadDataset'])->middleware('auth');

Route::get("checkLogin", function(){
    return "<h1>".Auth::user('foldername')."</h1><br></br>";
});


Route::get('/logout', 'App\Http\Controllers\logoutController@logout')->middleware('auth'); 
Route::post('/logout', 'App\Http\Controllers\logoutController@logout')->middleware('auth'); 
 
 
 
//28 kasım pazar günü ara rapor son yükleme tarihi.
//sonraki toplantı 3 aralık.