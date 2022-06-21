<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\QueueController;
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

Route::get('/mails',[MailController::class, 'getQueue']);
Route::get('/users',[MailController::class,'getUsers']);
Route::get('/check',[MailController::class,'checkBilling']);
Route::post('/add',[QueueController::class, 'addQueue']);
