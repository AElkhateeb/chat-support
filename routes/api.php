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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 Route::namespace('App\Http\Controllers')->group(static function () {
    Route::post('/chat-bot', 'ChatBotController@listenToReplies');
   // Route::post('/call-back', 'ChatBotController@listenToReplies');
    Route::post('/call-back', static function () {
        return "اي خدمهة";
    });
 });