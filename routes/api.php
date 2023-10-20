<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnnounceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::post('/register',[AuthController::class,'register']);
//Route::post('/login',[AuthController::class,'login']);

// Route::restifyAuth();
Route::get('/boat-list',[AnnounceController::class,'list']);
Route::post('/create-announce', [AnnounceController::class,'create']);
Route::post('/delete-announce', [AnnounceController::class,'delete']);
Route::get('/boat-filterlist',[AnnounceController::class,'filterlist']);
Route::post('/announce',[AnnounceController::class,'announce']);

Route::post('login', \App\Http\Controllers\Restify\Auth\LoginController::class)
    ->middleware('throttle:6,1')
    ->name('restify.login');

    Route::post('register', \App\Http\Controllers\Restify\Auth\RegisterController::class)
    ->name('restify.register');

    Route::post('forgotPassword', \App\Http\Controllers\Restify\Auth\ForgotPasswordController::class)
    ->middleware('throttle:6,1')
    ->name('restify.forgotPassword');

    Route::post('forgotPassword', \App\Http\Controllers\Restify\Auth\ForgotPasswordController::class)
    ->middleware('throttle:6,1')
    ->name('restify.forgotPassword');

    Route::post('forgotPassword', \App\Http\Controllers\Restify\Auth\ForgotPasswordController::class)
    ->middleware('throttle:6,1')
    ->name('restify.forgotPassword');

    Route::post('resetPassword', \App\Http\Controllers\Restify\Auth\ResetPasswordController::class)
    ->middleware('throttle:6,1')
    ->name('restify.resetPassword');

    Route::post('verify/{id}/{hash}', \App\Http\Controllers\Restify\Auth\VerifyController::class)
    ->middleware('throttle:6,1')
    ->name('restify.verify');

    Route::post('verify/{id}/{hash}', \App\Http\Controllers\Restify\Auth\VerifyController::class)
    ->middleware('throttle:6,1')
    ->name('restify.verify');

