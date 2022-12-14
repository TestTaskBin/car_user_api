<?php

use Illuminate\Support\Facades\Route;
use Vyuldashev\LaravelOpenApi\Generator;
use App\Models\User;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    $user = User::first();
    $token = null;
    if ($user) {
        $user->tokens()->delete();
        $token = $user->createToken('api-access')->plainTextToken;
    }
    return view('welcome', ['user' => $user, 'token' => $token]);
})->name('welcome');

Route::get('/openapi.json', function () {
    return response()->file(app_path('../openapi.json'), ['content-type' => 'application/json']);
});

Route::get('/openapi_dynamic.json', function (Generator $generator) {
    return response($generator->generate());
});
