<?php

use App\Http\Controllers\AjustesController;
use App\Http\Controllers\FamiliasController;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\FichasController;
use App\Http\Controllers\InformesController;
use App\Http\Controllers\LicenciasController;
use App\Http\Controllers\SitiosController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Middleware\RoleMiddleware;

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

Route::middleware(['middleware' => 'detect.site', 'auth'])->group(function () {
    Route::get('/', FichasController::class . '@index')->name('fichas.index');
    Route::get('/home', FichasController::class . '@index')->name('fichas.index');

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
    Route::get('/familias/{uuid}', FamiliasController::class . '@show')->name('familias.show');
    Route::get('/familias/{uuid}/edit', FamiliasController::class . '@edit')->name('familias.edit');
    Route::get('/familias/{uuid}/view', FamiliasController::class . '@view')->name('familias.view');
    Route::put('/familias/{uuid}', FamiliasController::class . '@update')->name('familias.update');
    Route::delete('/familias/{uuid}', FamiliasController::class . '@destroy')->name('familias.destroy');

    Route::get('/productos', ProductosController::class . '@index')->name('productos.index');
    Route::get('/productos/create', ProductosController::class . '@create')->name('productos.create');
    Route::post('/productos', ProductosController::class . '@store')->name('productos.store');
    Route::get('/productos/{uuid}/edit', ProductosController::class . '@edit')->name('productos.edit');
    Route::get('/productos/{uuid}/list', ProductosController::class . '@list')->name('productos.list');
    Route::get('/productos/{uuid}/components', ProductosController::class . '@components')->name('productos.components');
    Route::put('/productos/{uuid}/update', ProductosController::class . '@update')->name('productos.update');
    Route::put('/productos/{uuid}/update_components', ProductosController::class . '@update_components')->name('productos.update_components');
    Route::delete('/productos/{uuid}', ProductosController::class . '@destroy')->name('productos.destroy');
    Route::get('/productos/inventory', ProductosController::class . '@inventory')->name('productos.inventory');
    Route::put('/productos/inventory', ProductosController::class . '@inventory')->name('productos.inventory');

    Route::get('/fichas', FichasController::class . '@index')->name('fichas.index');
    Route::put('/fichas', FichasController::class . '@index')->name('fichas.index');
    Route::get('/fichas/create', FichasController::class . '@create')->name('fichas.create');
    Route::post('/fichas', FichasController::class . '@store')->name('fichas.store');
    Route::get('/fichas/{uuid}/edit', FichasController::class . '@edit')->name('fichas.edit');
    Route::get('/fichas/{uuid}/familias', FichasController::class . '@familias')->name('fichas.familias');
    Route::get('/fichas/{uuid}', FichasController::class . '@show')->name('fichas.show');
    Route::get('fichas/{uuid}/familias/{uuid2}/productos', FichasController::class . '@productos')->name('fichas.productos');
    Route::post('fichas/{uuid}/familias/{uuid2}/productos', FichasController::class . '@addproduct')->name('fichas.addproduct');
    Route::put('/fichas/{uuid}', FichasController::class . '@update')->name('fichas.update');
    Route::delete('/fichas/{uuid}', FichasController::class . '@destroy')->name('fichas.destroy');
    Route::get('/fichas/{uuid}/lista', FichasController::class . '@lista')->name('fichas.lista');
    Route::delete('/fichas/{uuid}/lista/{uuid2}', FichasController::class . '@destroylista')->name('fichas.destroylista');
    Route::put('/fichas/{uuid}/lista/{uuid2}/{cantidad}', FichasController::class . '@updatelista')->name('fichas.updatelista');
    Route::get('/fichas/{uuid}/usuarios', FichasController::class . '@usuarios')->name('fichas.usuarios');
    Route::put('/fichas/{uuid}/usuarios', FichasController::class . '@updateusuarios')->name('fichas.updateusuarios');
    Route::get('/fichas/{uuid}/servicios', FichasController::class . '@servicios')->name('fichas.servicios');
    Route::put('/fichas/{uuid}/servicios', FichasController::class . '@updateservicios')->name('fichas.updateservicios');
    Route::get('/fichas/{uuid}/gastos', FichasController::class . '@gastos')->name('fichas.gastos');
    Route::get('/fichas/{uuid}/gastos/add', FichasController::class . '@addgastos')->name('fichas.addgastos');
    Route::put('/fichas/{uuid}/gastos', FichasController::class . '@updategastos')->name('fichas.updategastos');
    Route::delete('/fichas/{uuid}/gastos/{uuid2}', FichasController::class . '@destroygastos')->name('fichas.destroygastos');
    Route::get('/fichas/{uuid}/resumen', FichasController::class . '@resumen')->name('fichas.resumen');
    Route::put('/fichas/{uuid}/resumen', FichasController::class . '@enviar')->name('fichas.enviar');
    Route::post('/fichas/{uuid}/resumen/compartir', FichasController::class . '@compartirResumen')->name('fichas.compartir');
    Route::get('/informes', [InformesController::class, 'index'])->name('informes.index');
    Route::put('/informes', [InformesController::class, 'index'])->name('informes.balance');
    Route::put('/informes/facturar', [InformesController::class, 'facturar'])->name('informes.facturar');

    Route::get('/servicios', ServiciosController::class . '@index')->name('servicios.index');
    Route::get('/servicios/create', ServiciosController::class . '@create')->name('servicios.create');
    Route::post('/servicios', ServiciosController::class . '@store')->name('servicios.store');
    Route::get('/servicios/{uuid}', ServiciosController::class . '@show')->name('servicios.show');
    Route::get('/servicios/{uuid}/edit', ServiciosController::class . '@edit')->name('servicios.edit');
    Route::get('/servicios/{uuid}/view', ServiciosController::class . '@view')->name('servicios.view');
    Route::put('/servicios/{uuid}', ServiciosController::class . '@update')->name('servicios.update');
    Route::delete('/servicios/{uuid}', ServiciosController::class . '@destroy')->name('servicios.destroy');

    Route::get('/reservas', [ReservasController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/create', [ReservasController::class, 'create'])->name('reservas.create');
    Route::post('/reservas', [ReservasController::class, 'store'])->name('reservas.store');
    Route::delete('/reservas/{uuid}', ReservasController::class . '@destroy')->name('reservas.destroy');
    Route::get('/reservas/{uuid}/edit', ReservasController::class . '@edit')->name('reservas.edit');
    Route::put('/reservas/{uuid}', ReservasController::class . '@update')->name('reservas.update');

    Route::get('/ajustes', [AjustesController::class, 'index'])->name('ajustes.index');
    Route::put('/ajustes', [AjustesController::class, 'update'])->name('ajustes.update');

    Route::get('/sitios', [SitiosController::class, 'index'])->name('sitios.index');
    Route::get('/sitios/create', [SitiosController::class, 'create'])->name('sitios.create');
    Route::get('/sitios/{id}/edit', [SitiosController::class, 'edit'])->name('sitios.edit');
    Route::put('/sitios/{id}/update', [SitiosController::class, 'update'])->name('sitios.update');
    Route::delete('/sitios/{id}', [SitiosController::class, 'destroy'])->name('sitios.destroy');

    Route::get('/licencias', [LicenciasController::class, 'index'])->name('licencias.index');
    Route::put('/licencias', [LicenciasController::class, 'index'])->name('licencias.index');
    Route::get('/licencias/create', [LicenciasController::class, 'create'])->name('licencias.create');
    Route::get('/licencias/{id}/edit', [LicenciasController::class, 'edit'])->name('licencias.edit');
    Route::put('/licencias/{id}/update', [LicenciasController::class, 'update'])->name('licencias.update');
    Route::delete('/licencias/{id}', [LicenciasController::class, 'destroy'])->name('licencias.destroy');
    Route::get('/licencias/error', [LicenciasController::class, 'error'])->name('licencias.error');
    Route::put('/licencias/error', [LicenciasController::class, 'error'])->name('licencias.error');

    // Rutas para WhatsApp
    Route::post('/whatsapp/send', [WhatsAppController::class, 'sendMessage'])->name('whatsapp.send');
    Route::post('/whatsapp/send-media', [WhatsAppController::class, 'sendMedia'])->name('whatsapp.send-media');
    Route::post('/whatsapp/send-template', [WhatsAppController::class, 'sendTemplate'])->name('whatsapp.send-template');

    Route::post('/send-sms', [SmsController::class, 'sendSms'])->name('sms.enviar');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
