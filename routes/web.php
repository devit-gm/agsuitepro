<?php

use App\Http\Controllers\FamiliasController;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('usuarios.index');
    })->name('home.index');
    Route::get('/home', function () {
        return view('usuarios.index');
    })->name('home.index');
    Route::get('/usuarios', function () {
        return view('usuarios.index');
    })->name('usuarios.index');

    Route::get('/familias', FamiliasController::class . '@index')->name('familias.index');
    Route::get('/familias/create', FamiliasController::class . '@create')->name('familias.create');
    Route::post('/familias', FamiliasController::class . '@store')->name('familias.store');
    Route::get('/familias/{familia}', FamiliasController::class . '@show')->name('familias.show');
    Route::get('/familias/{familia}/edit', FamiliasController::class . '@edit')->name('familias.edit');
    Route::put('/familias/{familia}', FamiliasController::class . '@update')->name('familias.update');
    Route::delete('/familias/{familia}', FamiliasController::class . '@destroy')->name('familias.destroy');

    Route::get('/productos', ProductosController::class . '@index')->name('productos.index');
    Route::get('/productos/create', ProductosController::class . '@create')->name('productos.create');
    Route::post('/productos', ProductosController::class . '@store')->name('productos.store');
    Route::get('/productos/{producto}', ProductosController::class . '@show')->name('productos.show');
    Route::get('/productos/{producto}/edit', ProductosController::class . '@edit')->name('productos.edit');
    Route::get('/productos/{producto}/list', ProductosController::class . '@list')->name('productos.list');
    Route::put('/productos/{producto}', ProductosController::class . '@update')->name('productos.update');
    Route::delete('/productos/{producto}', ProductosController::class . '@destroy')->name('productos.destroy');

    Route::get('/fichas', function () {
        return view('fichas.index');
    })->name('fichas.index');
    Route::get('/reservas', function () {
        return view('reservas.index');
    })->name('reservas.index');
    Route::get('/informes', function () {
        return view('informes.index');
    })->name('informes.index');
    Route::get('/servicios', function () {
        return view('servicios.index');
    })->name('servicios.index');
    Route::get('/ajustes', function () {
        return view('ajustes.index');
    })->name('ajustes.index');
});
