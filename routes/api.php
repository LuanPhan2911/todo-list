<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::group([
    'prefix' => 'todolist',
], function () {
    Route::post('/create', [TodoListController::class, 'store']);
    Route::get('/index', [TodoListController::class, 'index']);
    Route::delete('/delete', [TodoListController::class, 'destroy']);
    Route::get('/deleted-list', [TodoListController::class, 'getDeletedTodo']);
    Route::patch('/restore-todo', [TodoListController::class, 'restoreTodo']);
    Route::patch('/edit', [TodoListController::class, 'update']);
});
Route::group([
    'prefix' => 'post'
], function () {
    Route::post('/store', [PostController::class, 'store']);

    Route::get('/', [PostController::class, 'index']);
    Route::get('/show', [PostController::class, 'show']);
});
Route::group([
    'prefix' => 'comment'
], function () {
    Route::post('/store', [CommentController::class, 'store']);
    Route::get('/', [CommentController::class, 'index']);
    Route::post('/reply/store', [CommentController::class, 'replyStore']);
});
