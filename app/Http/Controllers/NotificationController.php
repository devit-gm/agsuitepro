<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class NotificationController extends Controller
{
    /**
     * Guarda el token FCM del usuario
     */
    public function saveToken(Request $request)
    {
        Log::info('=== INICIO saveToken ===');
        Log::info('Request data:', $request->all());
        Log::info('User authenticated:', ['auth' => Auth::check(), 'user_id' => Auth::id()]);
        
        $validator = Validator::make($request->all(), [
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            Log::error('Validación fallida:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Token inválido',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = Auth::user();
            
            if (!$user) {
                Log::error('Usuario no autenticado');
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            Log::info('Intentando guardar token para usuario: ' . $user->id);
            $user->fcm_token = $request->token;
            $saved = $user->save();
            Log::info('Token guardado result:', ['saved' => $saved, 'fcm_token' => substr($user->fcm_token, 0, 20) . '...']);

            
            Log::info('Token FCM guardado para usuario: ' . $user->id, ['token' => substr($request->token, 0, 20) . '...']);

            return response()->json([
                'success' => true,
                'message' => 'Token guardado correctamente',
                'user_id' => $user->id
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al guardar token FCM: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el token: ' . $e->getMessage()
            ], 500);
        }
    }
}
