<?php

use App\Http\Controllers\MailController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::match(['get', 'post'], '/admin',[MailController::class, 'index'])->name('admin')->middleware('auth');
Route::match(['get', 'post'], '/',[MailController::class, 'AdminLogin'])->name('login');
Route::match(['get', 'post'],'/logout', [MailController::class, 'logout'])->name('logout');
Route::post('/delete/{id}', [MailController::class, 'delete'])->name('delete');
Route::post('/reset', [MailController::class, 'reset'])->name('reset');
