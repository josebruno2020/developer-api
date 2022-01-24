<?php

use App\Http\Controllers\DeveloperController;
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

Route::group(['prefix' => 'developers'], function () {
    Route::get('', [DeveloperController::class, 'index']);
    Route::post('', [DeveloperController::class, 'create']);
    Route::get('{id}', [DeveloperController::class, 'show']);
    Route::put('{id}', [DeveloperController::class, 'update']);
    Route::delete('{id}', [DeveloperController::class, 'delete']);


});
