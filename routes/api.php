<?php

use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\MainController;
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

Route::match(['GET', 'POST'], 'samiti',[MainController::class,'samiti']);
Route::match(['GET', 'POST'], 'noti',[MainController::class,'noti']);
Route::match(['GET', 'POST'], 'user',[MainController::class,'user']);
Route::match(['GET', 'POST'], 'news',[MainController::class,'news']);
Route::match(['GET', 'POST'], 'member',[MainController::class,'member']);
Route::match(['GET', 'POST'], 'single-member',[MainController::class,'singleMember']);
Route::match(['GET', 'POST'], 'subscribe',[MainController::class,'subscribe']);


Route::match(['get'],'init-date',[DataController::class,'init']);
