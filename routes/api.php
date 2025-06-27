<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\TareasController;

// Ruta de prueba protegida
Route::middleware('auth:sanctum')->get('/usuario-autenticado', function (Request $request) {
    return $request->user();
});


// Rutas de autenticación
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


//Rutas de gestión de usuarios
Route::post('/usuarios', [UsuarioController::class, 'store']);

// Rutas de gestión de tareas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tareas', [TareasController::class, 'store']);
    
    Route::get('/tareas/por-fecha', [TareasController::class, 'tareasPorFecha']);
    Route::get('/tareas/vencidas', [TareasController::class, 'tareasVencidas']);
    Route::get('/tareas/buscar', [TareasController::class, 'buscar']);
    Route::get('/tareas', [TareasController::class, 'index']);
    Route::get('/tareas/{id}', [TareasController::class, 'show']);
    
    Route::put('/tareas/{id}', [TareasController::class, 'update']);
    Route::delete('/tareas/{id}', [TareasController::class, 'destroy']);
    

});

Route::post('/tareas/trigger-recordatorios', [TareasController::class, 'triggerRecordatorios']);
Route::post('/tareas/enviar-recordatorios', [TareasController::class, 'enviarRecordatorios']);




