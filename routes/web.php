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

Route::prefix('moderation')->group(function () {
Route::get('/', [UserController::class, 'index'])->name('moderation.index');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/archive/{thread}', [UserController::class, 'archive'])->name('moderation.archive');
Route::get('/pin/{thread}', [UserController::class, 'pin'])->name('moderation.pin');
Route::get('/thread/delete/{thread}', [UserController::class, 'deleteThread'])->name('moderation.thread.delete');
Route::get('/thread/ban/{thread}', [UserController::class, 'deleteThreadBan'])->name('moderation.thread.ban');
Route::get('/thread/search', [UserController::class, 'delete'])->name('moderation.thread.search');
Route::post('/board/new', [UserController::class, 'newBoard'])->name('moderation.board.new');
Route::post('/board/rename', [UserController::class, 'renameBoard'])->name('moderation.board.rename');
Route::post('/category/new', [UserController::class, 'newCategory'])->name('moderation.category.new');
Route::post('/category/rename', [UserController::class, 'renameCategory'])->name('moderation.category.rename');
Route::get('/category/delete/{category}', [UserController::class, 'deleteCategory'])->name('moderation.category.delete');
Route::get('/board/delete/{board}', [UserController::class, 'deleteBoard'])->name('moderation.board.delete');
Route::post('/users/password', [UserController::class, 'changePassword'])->name('moderation.users.password');
Route::post('/users/invite', [UserController::class, 'userInvite'])->name('moderation.users.invite');
Route::get('/users/delete/{user}', [UserController::class, 'deleteUser'])->name('moderation.users.delete');
Route::get('/files/delete/{reply}/{thread}', [UserController::class, 'deleteFile'])->name('moderation.files.delete');
Route::get('/files/delete/{reply}/{thread}/ban', [UserController::class, 'deleteFileBan'])->name('moderation.files.delete.ban');
Route::get('/files/delete/{reply}/{thread}/post', [UserController::class, 'deleteFilePost'])->name('moderation.files.delete.post');
//Route::get('/files/spoiler/{reply}/{thread}', [UserController::class, 'spoilerFile'])->name('moderation.files.spoiler');
Route::get('/reply/delete/{reply}', [UserController::class, 'deleteReply'])->name('moderation.reply.delete');
Route::get('/reply/ban/{reply}', [UserController::class, 'deleteReplyBan'])->name('moderation.reply.ban');

Route::group(['middleware'=>['auth.custom:web']], function() {
    Route::get('/threads', [UserController::class, 'threads'])->name('moderation.threads');
    Route::get('/boards', [UserController::class, 'boards'])->name('moderation.boards');
    Route::get('/categories', [UserController::class, 'categories'])->name('moderation.categories');
    Route::get('/users', [UserController::class, 'users'])->name('moderation.users');
    Route::get('/register/{username}', [UserController::class, 'register'])->name('moderation.register');
    Route::get('/files', [UserController::class, 'files'])->name('moderation.files');
    Route::get('/archives', [UserController::class, 'archives'])->name('moderation.archives');
    Route::get('/pins', [UserController::class, 'pins'])->name('moderation.pins');
});

});

Route::get('/newcaptcha', [ThreadController::class, 'newCaptcha'])->name('captcha');
Route::get('/{board}/thread/{id}', [ThreadController::class, 'index'])->name('thread');
Route::get('/{board}', [BoardController::class, 'board'])->name('board');
Route::post('/newthread/{tag}', [BoardController::class, 'newThread'])->name('newthread');
Route::post('/newreply/{id}', [ThreadController::class, 'newReply'])->name('newreply');


