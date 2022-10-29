<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarUserController;
use App\Http\Controllers\AssignController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('/manage/cars', CarController::class)->except(['create', 'edit']);
    Route::resource('/manage/car_users', CarUserController::class)->except(['create', 'edit']);

    Route::get('/assign/free_users', [AssignController::class, 'freeUsers'])->name('free_users');
    Route::get('/assign/free_cars', [AssignController::class, 'freeCars'])->name('free_cars');
    Route::get('/assign/assing_car/{car}/{user}', [AssignController::class, 'assignCar'])->name('assign_car');
    Route::get('/assign/release_car/{car}/{user}', [AssignController::class, 'releaseCar'])->name('release_car');
});
