<?php

use App\Http\Controllers\AcademicController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Users routes
Route::prefix('/user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

// Academic routes
Route::prefix('/academic')->group(function () {
    Route::get('/', [AcademicController::class, 'index']);
    Route::get('/{id}', [AcademicController::class, 'show']);
    Route::post('', [AcademicController::class, 'store']);
    Route::put('/{id}', [AcademicController::class, 'update']);
    Route::delete('/{id}', [AcademicController::class, 'destroy']);
});

// Portfolio routes
Route::prefix('/portfolio')->group(function () {
    Route::get('/', [PortfolioController::class, 'index']);
    Route::get('/{id}', [PortfolioController::class, 'show']);
    Route::post('', [PortfolioController::class, 'store']);
    Route::put('/{id}', [PortfolioController::class, 'update']);
    Route::delete('/{id}', [PortfolioController::class, 'destroy']);
});
