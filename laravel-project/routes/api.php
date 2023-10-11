<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RestifyAuthController::class, 'register']);
Route::post('/login', [RestifyAuthController::class, 'login']);
Route::post('/restify/forgotPassword', [RestifyAuthController::class, 'forgotPassword']);
Route::post('/restify/resetPassword', [RestifyAuthController::class, 'resetPassword']);
Route::post('/restify/verify/{id}/{emailHash}', [RestifyAuthController::class, 'verifyEmail']);

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
