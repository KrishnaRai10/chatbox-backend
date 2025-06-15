<?php

use App\Events\ChatMessageEvent;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('get-message',[ChatController::class,'getMessages'])
    ->name('get-message');
Route::post('sendMessage',[ChatController::class,'sendMessage']);
Route::post('typing',[ChatController::class,'typing']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/room',[RoomController::class,'index']);
    Route::post('/room',[RoomController::class,'store']);
});