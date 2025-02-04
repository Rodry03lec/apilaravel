<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioControlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/v1/auth')->group(function(){
    Route::post("login", [AuthController::class, 'funLogin']);
    Route::post("registrar", [AuthController::class, 'funRegistrar']);

    Route::middleware(['auth:sanctum'])->group(function() {
        Route::get("perfil", [AuthController::class, 'funPerfil']);
        Route::post("logout", [AuthController::class, 'funLogout']);
    });

});


//CRUD DE USUARIOS
Route::apiResource('usuario', UsuarioControlador::class);
