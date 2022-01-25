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
    //return view("layouts.header");
    return View::make('layouts.header')->nest('footer','layouts.footer');
});
Route::post('/home', function(){
    return '@include("layouts.header")';
});

Route::get('/register', 'App\Http\Controllers\registrationController@create')->middleware('guest');
Route::post('register', 'App\Http\Controllers\registrationController@store')->middleware('guest');

Route::get('/test', 'App\Http\Controllers\registrationController@test');

Route::get('/login',[loginController::class,'loginView'])->middleware('guest');
Route::post('login',[loginController::class,'loginWithRequest'])->middleware('guest');

Route::post('listFolders',[userFolderController::class,'listFolder'])->middleware('auth');
Route::get('deleteDir',[userFolderController::class,'deleteDir'])->middleware('auth'); //-->kullanılırken post yapılacak.

Route::get('classification/upload',function(){
    return view('upload');
})->middleware('auth');
Route::post('classification/upload', [imageClassificationController::class, 'uploadDataset'])->middleware('auth');

Route::get("checkLogin", function(){
    return "<h1>".Auth::user('foldername')."</h1><br></br>";
});

Route::get('checkPermission', [imageClassificationController::class,'train']);


Route::get('/logout', 'App\Http\Controllers\logoutController@logout')->middleware('auth'); 
Route::post('/logout', 'App\Http\Controllers\logoutController@logout')->middleware('auth'); 

/*Route::get('/classification/train', function(){
    return view('classificationTrain');
})->middleware('auth'); 
*/

Route::get('classification/train', [imageClassificationController::class, 'trainView']); 

Route::post('classification/train', [imageClassificationController::class, 'train']); 



