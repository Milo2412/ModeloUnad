<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-code', [AuthController::class, 'verify']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/check-username', [AuthController::class, 'checkUsername']);
Route::post('/update-profile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->put('/estante', [EstanteController::class, 'update']);

Route::get('/estante/{id}', [EstanteController::class, 'mostrar']);
