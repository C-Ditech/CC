<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/sign-up', 'signUp');
    Route::post('/sign-in', 'signIn');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/show-articles', 'showArticles');
        Route::post('/create-article', 'createArticle');
        Route::get('/show-history', 'showHistory');
        Route::post('/sign-out', 'signOut');
        Route::get('/check-disease', 'checkDisease');
    });
});