<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThreadController;

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

Route::get('/moderation', [UserController::class, 'index'])->name('moderation.index');
Route::post('/moderation/login', [UserController::class, 'login'])->name('login');
Route::get('/moderation/archive/{thread}', [UserController::class, 'archive'])->name('moderation.archive');
Route::get('/moderation/pin/{thread}', [UserController::class, 'pin'])->name('moderation.pin');
Route::get('/moderation/thread/delete/{thread}', [UserController::class, 'deleteThread'])->name('moderation.thread.delete');
Route::get('/moderation/thread/ban/{thread}', [UserController::class, 'deleteThreadBan'])->name('moderation.thread.ban');
Route::get('/moderation/thread/search', [UserController::class, 'delete'])->name('moderation.thread.search');
Route::post('/moderation/board/new', [UserController::class, 'newBoard'])->name('moderation.board.new');
Route::post('/moderation/board/rename', [UserController::class, 'renameBoard'])->name('moderation.board.rename');
Route::post('/moderation/category/new', [UserController::class, 'newCategory'])->name('moderation.category.new');
Route::post('/moderation/category/rename', [UserController::class, 'renameCategory'])->name('moderation.category.rename');
Route::get('/moderation/category/delete/{category}', [UserController::class, 'deleteCategory'])->name('moderation.category.delete');
Route::get('/moderation/board/delete/{board}', [UserController::class, 'deleteBoard'])->name('moderation.board.delete');
Route::post('/moderation/users/password', [UserController::class, 'changePassword'])->name('moderation.users.password');
Route::post('/moderation/users/invite', [UserController::class, 'userInvite'])->name('moderation.users.invite');
Route::get('/moderation/users/delete/{user}', [UserController::class, 'deleteUser'])->name('moderation.users.delete');
Route::get('/moderation/files/delete/{reply}/{thread}', [UserController::class, 'deleteFile'])->name('moderation.files.delete');
Route::get('/moderation/files/spoiler/{reply}/{thread}', [UserController::class, 'spoilerFile'])->name('moderation.files.spoiler');
Route::get('/moderation/reply/delete/{reply}', [UserController::class, 'deleteReply'])->name('moderation.reply.delete');
Route::get('/moderation/reply/ban/{reply}', [UserController::class, 'deleteReplyBan'])->name('moderation.reply.ban');

Route::group(['middleware'=>['auth.custom:web']], function() {
    Route::get('/moderation/threads', [UserController::class, 'threads'])->name('moderation.threads');
    Route::get('/moderation/boards', [UserController::class, 'boards'])->name('moderation.boards');
    Route::get('/moderation/categories', [UserController::class, 'categories'])->name('moderation.categories');
    Route::get('/moderation/users', [UserController::class, 'users'])->name('moderation.users');
    Route::get('/moderation/register/{username}', [UserController::class, 'register'])->name('moderation.register');
    Route::get('/moderation/files', [UserController::class, 'files'])->name('moderation.files');
    Route::get('/moderation/archives', [UserController::class, 'archives'])->name('moderation.archives');
    Route::get('/moderation/pins', [UserController::class, 'pins'])->name('moderation.pins');
});

Route::get('/{board}/thread/{id}', [ThreadController::class, 'index'])->name('thread');
Route::get('/{board}', [BoardController::class, 'board'])->name('board');
Route::post('/newthread/{tag}', [BoardController::class, 'newThread'])->name('newthread');
Route::post('/newreply/{id}', [ThreadController::class, 'newReply'])->name('newreply');

