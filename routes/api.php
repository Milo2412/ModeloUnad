<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstanteController;
use App\Http\Controllers\PublicidadController;
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

//Registro de un nuevo usuario
Route::post('/register', [AuthController::class, 'register']);

// Verificar codigo de verificacion
Route::post('/verify-code', [AuthController::class, 'verify']);

// Loguear usuarios
Route::post('/login', [AuthController::class, 'login']);

// Actualizar el nombre del usuario
Route::post('/check-username', [UserController::class, 'checkUsername']);

// Mostrar informacion del estante
Route::get('/estante/{id}', [EstanteController::class, 'mostrar']);

// Obtener la información de publicidad
Route::get('/publicidad', [PublicidadController::class, 'obtenerPublicidad']);

//Enlistar estantes
Route::get('/listar-estantes', [EstanteController::class, 'listarEstantes']);

Route::middleware('auth:sanctum')->group(function () {

    // Obtener el perfil del usuario autenticado
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });

    // Actualizar perfil del usuario autenticado
    Route::post('/update-profile', [UserController::class, 'updateProfile']);

    // Enlistar usuarios (id, nombre, correo)
    Route::get('/listar-usuarios', [UserController::class, 'listarUsuarios']);

    // Asignar un usuario a un estante (actualiza id_user)
    Route::put('/estantes/{id}/asignar-usuario', [EstanteController::class, 'asignarUsuario']);

    //Actualizar publicidad del evento
    Route::put('/update-publicidad', [PublicidadController::class, 'actualizarPublicidad']);

    // Actualizar estante por id
    Route::put('/estantes/{id}/update', [EstanteController::class, 'update']);

    //Mostrar los estantes asignados a un usuario
    Route::get('/mis-estantes', [EstanteController::class, 'misEstantes']);

    //Limpiar datos de estante
    Route::delete('/estantes/{id}/limpiar', [EstanteController::class, 'limpiarEstante']);
});
