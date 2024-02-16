<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\ApiAuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(ApiAuthController::class)->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('apiadminauth');
    });
});

Route::controller(DataController::class)->middleware('apiadminauth')->group(function () {
    Route::get('/users', 'getUserData');
    Route::get('/user/{id}', 'findUser');
    Route::get('/employers', 'getEmployerData');
    Route::get('/employers/{id}', 'findEmployer');
    Route::post('/post/users', 'importUser');
    Route::post('/post/employers', 'importEmployer');
});
