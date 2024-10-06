<?php

use App\Http\Controllers\Api\Auth\{LoginController, LogoutController, PasswordController, RegisterController};
use App\Http\Controllers\Api\{CategoryController, PostController, UserController};
use App\Http\Controllers\Api\BookmarkController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [RegisterController::class, 'register'])
    ->name('register');
Route::post('/login', [LoginController::class, 'login'])
    ->name('login');


Route::post('/password/email', [PasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('/password/reset', [PasswordController::class, 'getResetLink'])
    ->name('password.reset.get');
Route::post('/password/reset', [PasswordController::class, 'reset'])
    ->middleware('signed')
    ->name('password.reset');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class)
        ->name('logout');

    Route::resource('/users', UserController::class);
    Route::post('/posts/{post}', [PostController::class, 'update'])->name('posts.update_v2');
    Route::resource('/posts', PostController::class);
    Route::resource('/categories', CategoryController::class);

    Route::get('/categories/{category:slug}/posts', [CategoryController::class, 'showPosts'])
        ->name('categories.posts');

    Route::get('/bookmarks', [BookmarkController::class, 'index'])
        ->name('bookmark.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])
        ->name('bookmarks.store');
    Route::delete('/bookmarks/{post}', [BookmarkController::class, 'destroy'])
        ->name('bookmarks.destroy');
});
