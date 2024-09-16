<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExampleController;

//User related routes
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('auth');

//blog related routes
Route::get('/create-post', [PostController::class, "createPost"])->middleware('auth');
Route::post('/create-post', [PostController::class, "storeNewPost"])->middleware('auth');
Route::get('/post/{post}', [PostController::class, "showPost"])->middleware('auth');

//Profile related routes
Route::get('/profile/{pizza:username}', [UserController::class, "showProfile"])->middleware('auth');
