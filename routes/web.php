<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Carbon;

Route::get('/', function () {
    return view('welcome');
});

// RUTAS DE PRUEBA
// Ruta con nombre
Route::get('/holamundoestaesunarutaconnombre', function () {
    return ('Esta es una ruta con nombre propio');
})->name('nombreDeRuta');

// Es una ruta creado por mi 
Route::get('/prueba', function () {
    return ('Hola mundo en prueba por defecto');
});
// Ruta pasandole un valor
Route::get('/prueba/{id}', function ($id) {
    // Uso de condicionales para redireccionar
    if($id === '2'){
        return redirect('/prueba');
    }

    // Redirección a una ruta por su nombre
    if($id === '3'){
        // Redirección por nombre convecional
        // return redirect()->route('nombreDeRuta');
        // Redirección por nombre simplificada
        return to_route('nombreDeRuta');
    }

    return ('Hola mundo estas en prueba por varaible <b>' . $id . '</b>');
});
// Ruta pasandole un valor (OPCIONAL)
// Se debe de agregar en la ruta una ? justo detrás del nombre de la variable
// Además el valor pasado en la función deberá tener uno por defecto
Route::get('/pruebaOpcional/{id?}', function ($id = null) {
    return ('Hola mundo estas en prueba opcional <b>' . $id . '</b>');
});


// RUTAS DE FUNCIONAMIENTO INTERFAZ EXTERNA
Route::resource('users', UserController::class);
Route::put('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
Route::resource('clientes', ClienteController::class);
Route::put('clientes/{cliente}/restore', [ClienteController::class, 'restore'])->name('clientes.restore');
Route::resource('contactos', ContactoController::class);
Route::put('contactos/{contacto}/restore', [ContactoController::class, 'restore'])->name('contactos.restore');
Route::resource('eventos', EventoController::class);
Route::put('eventos/{evento}/restore', [EventoController::class, 'restore'])->name('eventos.restore');
Route::resource('notas', NotaController::class);
Route::put('notas/{nota}/restore', [NotaController::class, 'restore'])->name('notas.restore');

// Comprobar que la hora este correcta
Route::get('/hora', function () {
    return ('<div style="font-family: monospace;"> Hora madrid: ' . Carbon::now()->toDateTimeString() . "</div>");
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Ruta con sesión iniciada 
    Route::get('/home', function () {
        return view('pruebasVistas.index');
    })->name('HomeAlabama');
    // Es la misma ruta pero tolera los post
    Route::post('/home', function () {
        return request();
    })->name('HomeAlabama');
});

require __DIR__.'/auth.php';
