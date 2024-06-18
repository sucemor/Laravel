<?php

use App\Http\Controllers\Api\ClienteApiController;
use App\Http\Controllers\Api\ContactoApiController;
use App\Http\Controllers\Api\EventoApiController;
use App\Http\Controllers\Api\NotaApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AtributoApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para usuarios
Route::get('/usuarios', [UserApiController::class, 'index']);
Route::post('/usuarios/login', [UserApiController::class, 'iniciarSesion']);
Route::post('/usuarios/cerrarsesion', [UserApiController::class, 'logout']);
Route::post('/usuarios/agregar', [UserApiController::class, 'agregar']);
Route::put('/usuarios/actualizar/{id}', [UserApiController::class, 'actualizar']);
Route::delete('/usuarios/borrar/{id}', [UserApiController::class, 'borrar']);
Route::put('/usuarios/restaurar/{id}', [UserApiController::class, 'restaurar']);

// Rutas para clientes
Route::get('/clientes', [ClienteApiController::class, 'index']);
Route::get('/clientes/{id}', [ClienteApiController::class, 'detalles']);
Route::post('/clientes/agregar', [ClienteApiController::class, 'agregar']);
Route::put('/clientes/actualizar/{id}', [ClienteApiController::class, 'actualizar']);
Route::delete('/clientes/borrar/{id}', [ClienteApiController::class, 'borrar']);
Route::put('/clientes/restaurar/{id}', [ClienteApiController::class, 'restaurar']);

// Rutas para contactos
Route::get('/contactos', [ContactoApiController::class, 'index']);
Route::get('/contactos/{id}', [ContactoApiController::class, 'detalles']);
Route::post('/contactos/agregar', [ContactoApiController::class, 'agregar']);
Route::put('/contactos/actualizar/{id}', [ContactoApiController::class, 'actualizar']);
Route::delete('/contactos/borrar/{id}', [ContactoApiController::class, 'borrar']);
Route::put('/contactos/restaurar/{id}', [ContactoApiController::class, 'restaurar']);

// Rutas para eventos
Route::get('/eventos', [EventoApiController::class, 'index']);
Route::get('/eventos/{id}', [EventoApiController::class, 'detalles']);
Route::post('/eventos/agregar', [EventoApiController::class, 'agregar']);
Route::put('/eventos/actualizar/{id}', [EventoApiController::class, 'actualizar']);
Route::delete('/eventos/borrar/{id}', [EventoApiController::class, 'borrar']);
Route::put('/eventos/restaurar/{id}', [EventoApiController::class, 'restaurar']);

// Rutas para notas
Route::get('/notas', [NotaApiController::class, 'index']);
Route::get('/notas/{id}', [NotaApiController::class, 'detalles']);
Route::post('/notas/agregar', [NotaApiController::class, 'agregar']);
Route::put('/notas/actualizar/{id}', [NotaApiController::class, 'actualizar']);
Route::get('/notas/descargar/{id}', [NotaApiController::class, 'descargarAdjunto']);
Route::delete('/notas/borrar/{id}', [NotaApiController::class, 'borrar']);
Route::put('/notas/restaurar/{id}', [NotaApiController::class, 'restaurar']);

// Rutas para atributo
Route::get('/atributos', [AtributoApiController::class, 'index'])->name('atributos.index');
Route::post('/atributos/agregar', [AtributoApiController::class, 'store'])->name('atributos.store');
Route::delete('/atributos/eliminar', [AtributoApiController::class, 'destroy'])->name('atributos.destroy');
Route::put('/atributos/editar', [AtributoApiController::class, 'update']);
Route::post('/atributos/tabla', [AtributoApiController::class, 'datosDeUnaTabla'])->name('atributos.datosDeUnaTabla');
/**
 * Ruta encargada de sincronizar la información de los atributos en las tablas
 */
Route::get('sincroniza', [AtributoApiController::class, 'syncAttributes']);