<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getMessage',[ChatController::class,'getMessages'])
    ->name('getMessage');
Route::post('sendMessage',[ChatController::class,'sendMessage']);