<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\Auth;
use \App\Http\Controllers\Api\V1\Admin;
use \App\Http\Controllers\Api\V1\Client;
use \App\Http\Controllers\Api\V1\Public;

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

Route::middleware('auth:sanctum')->group(function () {

    Route::group([
        'prefix' => 'admin',
        'middleware' => ['admin'],
    ], function () {
        Route::post('/plans', Admin\PlanController::class);
    });

    Route::group([
        'prefix' => 'client',
    ], function () {
        Route::get('/plans', Client\PlanController::class);

        Route::get('/posts', [Client\PostController::class, 'index']);
        Route::post('/posts', [Client\PostController::class, 'store']);
        Route::put('/posts/{id}', [Client\PostController::class, 'activate']);

        Route::post('/subscribe', Client\SubscriptionController::class);

    });

    Route::post('auth/logout', Auth\LogoutController::class);

});

Route::get('/posts', Public\PostController::class);

Route::post('auth/register', Auth\RegisterController::class);
Route::post('auth/login', Auth\LoginController::class);
