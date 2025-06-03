<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('getMessage',[ChatController::class,'getMessages'])
    ->name('getMessage');
Route::post('sendMessage',[ChatController::class,'sendMessage']);