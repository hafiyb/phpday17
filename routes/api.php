<?php

use App\Http\Controllers\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [ApiController::class, 'login']);


// Route::post('/dashboard', [ApiController::class, 'dashboard']);


Route::group([
    'middleware' => 'auth.jwt'
],function(){
    Route::post('/dashboard', [ApiController::class, 'dashboard']);
    Route::post('/users', [ApiController::class, 'users']);
    Route::post('/getemployee', [ApiController::class, 'getEmployee']);
});