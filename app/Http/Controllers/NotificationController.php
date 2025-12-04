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

    /**
     * Envía una notificación push a todos los usuarios del sitio
     */
    public function enviarNotificacionGlobal(Request $request)
    {
        Log::info('=== INICIO enviarNotificacionGlobal ===');
        Log::info('Request data:', $request->all());
        Log::info('User authenticated:', ['auth' => Auth::check(), 'user_id' => Auth::id()]);
        
        $validator = Validator::make($request->all(), [
            'mensaje' => 'required|string|max:200'
        ]);

        if ($validator->fails()) {
            Log::error('Validación fallida:', $validator->errors()->toArray());
            return response()->json([
                'error' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Obtener todos los usuarios del sitio actual con FCM token, excepto el remitente
            $usuarios = User::whereNotNull('fcm_token')
                ->where('fcm_token', '!=', '')
                ->where('id', '!=', Auth::id())
                ->get();

            Log::info('Usuarios con FCM token encontrados: ' . $usuarios->count());

            if ($usuarios->isEmpty()) {
                return response()->json([
                    'error' => 'No hay usuarios con notificaciones activadas'
                ], 404);
            }

            // Preparar la notificación
            $titulo = Auth::user()->name; // El título es el nombre del remitente
            $mensaje = $request->mensaje;
            $remitente = Auth::user()->name;

            // Enviar notificación a cada usuario usando Firebase
            $enviadas = 0;
            $errores = 0;

            foreach ($usuarios as $usuario) {
                try {
                    $this->enviarNotificacionFirebase(
                        $usuario->fcm_token,
                        $titulo,
                        $mensaje,
                        $remitente
                    );
                    $enviadas++;
                } catch (\Exception $e) {
                    Log::error("Error enviando a usuario {$usuario->id}: " . $e->getMessage());
                    $errores++;
                }
            }

            Log::info("Notificaciones enviadas: {$enviadas}, Errores: {$errores}");

            return response()->json([
                'success' => true,
                'enviadas' => $enviadas,
                'errores' => $errores,
                'total' => $usuarios->count()
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al enviar notificación global: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'Error al enviar notificaciones: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Envía notificación push usando Firebase Cloud Messaging
     */
    private function enviarNotificacionFirebase($fcmToken, $titulo, $mensaje, $remitente)
    {
        // Cargar credenciales de Firebase
        $credentialsPath = storage_path('firebase-credentials.json');
        
        if (!file_exists($credentialsPath)) {
            throw new \Exception('Archivo de credenciales Firebase no encontrado');
        }

        $credenciales = json_decode(file_get_contents($credentialsPath), true);
        $projectId = $credenciales['project_id'];

        // Obtener access token de Google OAuth2
        $accessToken = $this->getGoogleAccessToken($credenciales);

        // Construir el mensaje FCM
        $notification = [
            'message' => [
                'token' => $fcmToken,
                'notification' => [
                    'title' => $titulo,
                    'body' => $mensaje
                ],
                'data' => [
                    'remitente' => $remitente,
                    'timestamp' => now()->toIso8601String()
                ],
                'webpush' => [
                    'notification' => [
                        'icon' => url('/images/icons/icon-192x192.png'),
                        'badge' => url('/images/icons/icon-72x72.png'),
                        'requireInteraction' => false
                    ]
                ]
            ]
        ];

        // Enviar a Firebase
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification));
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            Log::error('Error FCM:', ['code' => $httpCode, 'response' => $response]);
            throw new \Exception("FCM error: {$httpCode}");
        }

        Log::info('Notificación FCM enviada correctamente');
        return true;
    }

    /**
     * Obtiene el access token de Google OAuth2 para Firebase
     */
    private function getGoogleAccessToken($credenciales)
    {
        $now = time();
        
        // JWT Header
        $header = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
        $headerEncoded = $this->base64UrlEncode($header);
        
        // JWT Claim Set
        $claimSet = json_encode([
            'iss' => $credenciales['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600
        ]);
        $claimSetEncoded = $this->base64UrlEncode($claimSet);
        
        // JWT Signature
        $signatureInput = "{$headerEncoded}.{$claimSetEncoded}";
        $privateKey = openssl_get_privatekey($credenciales['private_key']);
        openssl_sign($signatureInput, $signature, $privateKey, 'SHA256');
        $signatureEncoded = $this->base64UrlEncode($signature);
        
        // JWT completo
        $jwt = "{$signatureInput}.{$signatureEncoded}";
        
        // Solicitar access token
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ]));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        
        if (!isset($data['access_token'])) {
            throw new \Exception('No se pudo obtener access token de Google');
        }
        
        return $data['access_token'];
    }

    /**
     * Base64 URL encode
     */
    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
