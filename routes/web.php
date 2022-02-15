<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/',function(){
    return phpinfo();
    return view('community');
})->middleware('auth');
Route::get('/users',function(){
    return view('users');
})->middleware('auth');
Route::get('/chat',function(){
    return view('chat');
})->middleware('auth');
Route::post('/chatMessage',[\App\Http\Controllers\ApiController::class,'chatMessage'])->middleware('auth');
Route::get('/login',function(){

    return view('login');
})->name('login');
Route::post('/login',[\App\Http\Controllers\UserController::class,'login']);
Route::get('/logout',function(){
    \Illuminate\Support\Facades\Auth::logout();
    return response()->redirectTo(\route('login'));
});
Route::post('/register',[\App\Http\Controllers\UserController::class,'register'])->middleware('auth');
