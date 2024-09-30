<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ExampleController;


Route::get('/admin-only', function() {
  return 'only admins here';
})->middleware('can:visitAdminPages');

//User related routes
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('auth');
Route::get('/manage-avatar', [UserController::class, "showAvatarForm"])->middleware('auth');
Route::post('/manage-avatar', [UserController::class, "saveAvatar"])->middleware('auth');

//follow related routes
Route::post('/create-follow/{user:username}', [FollowController::class, "createFollow"])->middleware('auth');
Route::post('/create-follow/{user:username}', [FollowController::class, "deleteFollow"])->middleware('auth');

//blog related routes
Route::get('/create-post', [PostController::class, "createPost"])->middleware('auth');
Route::post('/create-post', [PostController::class, "storeNewPost"])->middleware('auth');
Route::get('/post/{post}', [PostController::class, "showPost"])->middleware('auth');
Route::delete('/post/{post}', [PostController::class, "delete"])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, "showEditForm"])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, "updatePost"])->middleware('can:update,post');


//Profile related routes
Route::get('/profile/{user:username}', [UserController::class, "showProfile"])->middleware('auth');
