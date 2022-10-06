<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [BoardController::class, 'index'])->name('home');
Route::post('/newthread', [BoardController::class, 'newThread'])->name('newthread');
Route::post('/newreply/{id}', [ThreadController::class, 'newReply'])->name('newreply');
Route::get('/thread/{id}', [ThreadController::class, 'index'])->name('thread');
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
