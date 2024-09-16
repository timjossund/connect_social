<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExampleController;

//User related routes
Route::get('/', [UserController::class, "showCorrectHomepage"]);
Route::post('/register', [UserController::class, "register"]);
Route::post('/login', [UserController::class, "login"]);
Route::post('/logout', [UserController::class, "logout"]);

//blog related routes
Route::get('/create-post', [PostController::class, "createPost"]);
Route::post('/create-post', [PostController::class, "storeNewPost"]);
Route::get('/post/{post}', [PostController::class, "showPost"]);