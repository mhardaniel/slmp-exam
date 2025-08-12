<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/users/{user}/posts', [UserController::class, 'userPosts'])->name('userPosts');

    Route::get('/posts/{post}/comments', [PostController::class, 'postComments'])->name('postComments');

    Route::apiResources([
        'users' => UserController::class,
        'posts' => PostController::class,
        'comments' => CommentController::class,
    ]);
});
