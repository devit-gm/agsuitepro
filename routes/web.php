<?php

use App\Http\Controllers\FamiliasController;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\UsuariosController;

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
        return view('fichas.index');
    })->name('home.index');
    Route::get('/home', function () {
        return view('fichas.index');
    })->name('home.index');

    Route::get('/usuarios', UsuariosController::class . '@index')->name('usuarios.index');
    Route::get('/usuarios/create', UsuariosController::class . '@create')->name('usuarios.create');
    Route::post('/usuarios', UsuariosController::class . '@store')->name('usuarios.store');
    Route::get('/usuarios/{usuario}', UsuariosController::class . '@show')->name('usuarios.show');
    Route::get('/usuarios/{usuario}/edit', UsuariosController::class . '@edit')->name('usuarios.edit');
    Route::get('/usuarios/{usuario}/view', UsuariosController::class . '@view')->name('usuarios.view');
    Route::put('/usuarios/{usuario}', UsuariosController::class . '@update')->name('usuarios.update');
    Route::delete('/usuarios/{usuario}', UsuariosController::class . '@destroy')->name('usuarios.destroy');

    Route::get('/familias', FamiliasController::class . '@index')->name('familias.index');
    Route::get('/familias/create', FamiliasController::class . '@create')->name('familias.create');
    Route::post('/familias', FamiliasController::class . '@store')->name('familias.store');
    Route::get('/familias/{familia}', FamiliasController::class . '@show')->name('familias.show');
    Route::get('/familias/{familia}/edit', FamiliasController::class . '@edit')->name('familias.edit');
    Route::get('/familias/{familia}/view', FamiliasController::class . '@view')->name('familias.view');
    Route::put('/familias/{familia}', FamiliasController::class . '@update')->name('familias.update');
    Route::delete('/familias/{familia}', FamiliasController::class . '@destroy')->name('familias.destroy');

    Route::get('/productos', ProductosController::class . '@index')->name('productos.index');
    Route::get('/productos/create', ProductosController::class . '@create')->name('productos.create');
    Route::post('/productos', ProductosController::class . '@store')->name('productos.store');
    Route::get('/productos/{producto}', ProductosController::class . '@show')->name('productos.show');
    Route::get('/productos/{producto}/edit', ProductosController::class . '@edit')->name('productos.edit');
    Route::get('/productos/{producto}/list', ProductosController::class . '@list')->name('productos.list');
    Route::get('/productos/{producto}/components', ProductosController::class . '@components')->name('productos.components');
    Route::put('/productos/{producto}/update', ProductosController::class . '@update')->name('productos.update');
    Route::put('/productos/{producto}/update_components', ProductosController::class . '@update_components')->name('productos.update_components');
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

    Route::get('/servicios', ServiciosController::class . '@index')->name('servicios.index');
    Route::get('/servicios/create', ServiciosController::class . '@create')->name('servicios.create');
    Route::post('/servicios', ServiciosController::class . '@store')->name('servicios.store');
    Route::get('/servicios/{servicio}', ServiciosController::class . '@show')->name('servicios.show');
    Route::get('/servicios/{servicio}/edit', ServiciosController::class . '@edit')->name('servicios.edit');
    Route::get('/servicios/{servicio}/view', ServiciosController::class . '@view')->name('servicios.view');
    Route::put('/servicios/{servicio}', ServiciosController::class . '@update')->name('servicios.update');
    Route::delete('/servicios/{servicio}', ServiciosController::class . '@destroy')->name('servicios.destroy');

    Route::get('/ajustes', function () {
        return view('ajustes.index');
    })->name('ajustes.index');
});
