<?php

use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\EntidadComercialController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SucursalController;
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

Route::middleware('auth:sanctum')->group(function () {
    // asignar rol a usuario 
    Route::post("/users/{id}/roles", [UsuarioController::class, "funActualizarRoles"]);

    // signar permiso a rol 
    Route::post("/role/{id}/permisos", [RoleController::class, "funActualizarPermisos"]);

    // crud usuario 
    Route::get("/users", [UsuarioController::class, "funListar"]);
    Route::post("/users", [UsuarioController::class, "funGuardar"]);
    Route::get("/users/{id}", [UsuarioController::class, "funMostrar"]);
    Route::put("/users/{id}", [UsuarioController::class, "funModificar"]);
    Route::delete("/users/{id}", [UsuarioController::class, "funEliminar"]);

    //registro de subida de imagenes
    Route::post("producto/imagen", [ProductoController::class, "guardarProductoImagen"]);

    // crud roles 
    Route::apiResource("/role", RoleController::class);
    Route::apiResource("/almacen", AlmacenController::class);
    Route::apiResource("/categoria", CategoriaController::class);
    Route::apiResource("/contacto", ContactoController::class);
    Route::apiResource("/entidad-comercial", EntidadComercialController::class);
    Route::apiResource("/nota", NotaController::class);
    Route::apiResource("/permiso", PermisoController::class);
    Route::apiResource("/persona", PersonaController::class);
    Route::apiResource("/producto", ProductoController::class);
    Route::apiResource("/sucursales", SucursalController::class);
});

Route::get("/no-autorizado", function(){
    return response()->json(["message"=>"No Autorizado para ver el recurso"],401);
})->name('login');