<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('register', [AuthenticationController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('quotes', QuoteController::class)->only(['index']);
});
