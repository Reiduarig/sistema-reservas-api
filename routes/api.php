<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;

Route::post('/register', [AuthController::class, 'register'])
    ->name('register');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //Eventos
    Route::get('/events', [EventController::class, 'index'])
        ->name('events.index');
    Route::get('/events/{id}', [EventController::class, 'show'])
        ->name('events.show');

    //Auth
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});