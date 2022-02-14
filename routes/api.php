<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/user', function (Request $request) {
    return \Illuminate\Support\Facades\Auth::user();

})->middleware('auth:api');
Route::post('/token_test',function (){
    return response(['a'=>'b'],200);
})->middleware('auth:api')->name('test_token');


Route::post('/login',[\App\Http\Controllers\ApiController::class,'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/makeCommunityLog',[\App\Http\Controllers\ApiController::class,'makeCommunityLog']);
    Route::post('/getComunnityList',[\App\Http\Controllers\ApiController::class,'get_CommunityList']);
    Route::post('/continueComunnityList',[\App\Http\Controllers\ApiController::class,'continue_CommunityList']);
    Route::post('/getCurrentGoing',[\App\Http\Controllers\ApiController::class,'getCurrentGoing']);
    Route::post('/logout', [\App\Http\Controllers\ApiController::class,'logout'])->name('logout.api');
    Route::post('/setNotificationToken',[\App\Http\Controllers\ApiController::class,'setNotificationToken']);
    Route::post('/changePassword',[\App\Http\Controllers\ApiController::class,'changePassword']);
    Route::post('/updateProfile',[\App\Http\Controllers\ApiController::class,'updateProfile']);
    Route::post('/getFirstChatList',[\App\Http\Controllers\ApiController::class,'getFirstChat']);
    Route::post('/getMoreChatList',[\App\Http\Controllers\ApiController::class,'getMoreChatList']);
    Route::post('/chatMessage',[\App\Http\Controllers\ApiController::class,'chatMessage']);
});
