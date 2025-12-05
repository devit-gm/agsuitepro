<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de notificaciones con autenticación web (sesiones)
Route::middleware('auth:web')->post('/save-fcm-token', [NotificationController::class, 'saveToken']);
Route::middleware('auth:web')->post('/enviar-notificacion-global', [NotificationController::class, 'enviarNotificacionGlobal']);
