<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExampleController;

Route::get('/', [ExampleController::class, "homepage"]);

Route::get('/post', [ExampleController::class, "singlePost"]);

Route::post('/register', [UserController::class, "register"]);
