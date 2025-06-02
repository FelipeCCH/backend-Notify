<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsuarioController;

// Ruta de prueba protegida
Route::middleware('auth:sanctum')->get('/usuario-autenticado', function (Request $request) {
    return $request->user();
});


// Rutas de autenticación
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


//Rutas de gestión de usuarios
Route::post('/usuarios', [UsuarioController::class, 'store']);
