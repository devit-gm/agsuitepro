<?php

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
        return view('welcome');
    })->name('home.index');
    Route::get('/home', function () {
        return view('welcome');
    })->name('home.index');
    Route::get('/usuarios', function () {
        return view('usuarios.index');
    })->name('usuarios.index');
    Route::get('/familias', function () {
        return view('familias.index');
    })->name('familias.index');
    Route::get('/productos', function () {
        return view('productos.index');
    })->name('productos.index');
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