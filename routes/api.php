<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//rutas
Route::get('/saludo', function () {
    return [
        "message" => "saludos desde api jhovi"
    ];
});

Route::get('/nombre/{nom}', function ($nombre) {
    return [
        "nombre" => $nombre
    ];
});

Route::get('/nombre/{n}/edad/{ed}', function ($nombre, $edad) {
    return [
        "nombre" => $nombre,
        "edad" => $edad
    ];
});

//autenticacion
Route::post("/auth/login", [AuthController::class, "funLogin"]);
Route::post("/auth/register", [AuthController::class, "funRegister"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::get("/auth/profile", [AuthController::class, "funProfile"])->middleware('auth:sanctum');
    Route::post("/auth/logout", [AuthController::class, "funLogout"])->middleware('auth:sanctum');
});

// crud usuario 

Route::get("/users", [UsuarioController::class, "funListar"]);
Route::post("/users", [UsuarioController::class, "funGuardar"]);
Route::get("/users/{id}", [UsuarioController::class, "funMostrar"]);
Route::put("/users/{id}", [UsuarioController::class, "funModificar"]);
Route::delete("/users/{id}", [UsuarioController::class, "funEliminar"]);

// crud roles 
Route::apiResource("/role", RoleController::class);
