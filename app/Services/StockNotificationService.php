<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\Ajustes;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class StockNotificationService
{
    protected $firebase;

    public function __construct()
    {
        $this->firebase = new FirebaseService();
    }

    /**
     * Verifica el stock de un producto y envía notificaciones si está bajo
     */
    public function verificarYNotificar($productoUuid)
    {
        $ajustes = Ajustes::first();
        
        // Si las notificaciones están desactivadas, no hacer nada
        if (!$ajustes || !$ajustes->notificar_stock_bajo) {
            return;
        }

        $producto = Producto::with('familiaObj')->find($productoUuid);
        
        if (!$producto) {
            return;
        }

        // Verificar si el stock está por debajo del mínimo
        if ($producto->stock <= $ajustes->stock_minimo) {
            $this->enviarNotificaciones($producto, $ajustes);
        }
    }

    /**
     * Verifica todos los productos y notifica los que tengan stock bajo
     */
    public function verificarTodosLosProductos()
    {
        $ajustes = Ajustes::first();
        
        if (!$ajustes || !$ajustes->notificar_stock_bajo) {
            return;
        }

        $productos = Producto::with('familiaObj')
            ->where('combinado', 0)
            ->where('stock', '<=', $ajustes->stock_minimo)
            ->get();

        foreach ($productos as $producto) {
            $this->enviarNotificaciones($producto, $ajustes);
        }
    }

    /**
     * Envía notificaciones por email y push a administradores
     */
    protected function enviarNotificaciones($producto, $ajustes)
    {
        $site = app('site');
        
        // Obtener usuarios con role_id < 4 (administradores y gerentes)
        $usuarios = User::where('site_id', $site->id)
            ->where('role_id', '<', 4)
            ->whereNotNull('email')
            ->get();

        if ($usuarios->isEmpty()) {
            return;
        }

        $data = [
            'producto_nombre' => $producto->nombre,
            'stock_actual' => $producto->stock,
            'stock_minimo' => $ajustes->stock_minimo,
            'familia' => $producto->familiaObj ? $producto->familiaObj->nombre : 'Sin familia',
            'site_nombre' => $site->nombre
        ];

        // Enviar emails
        foreach ($usuarios as $usuario) {
            try {
                Mail::send('emails.stock-bajo', $data, function ($message) use ($usuario, $producto) {
                    $message->to($usuario->email, $usuario->name)
                        ->subject('⚠️ Alerta de Stock Bajo: ' . $producto->nombre);
                });
            } catch (\Exception $e) {
                Log::warning('Error al enviar email de stock bajo: ' . $e->getMessage());
            }
        }

        // Enviar notificaciones push a usuarios con token FCM
        $usuariosConFCM = User::where('site_id', $site->id)
            ->where('role_id', '<', 4)
            ->whereNotNull('fcm_token')
            ->get();

        $tokensEnviados = [];
        
        foreach ($usuariosConFCM as $usuario) {
            // Evitar duplicados por token
            if (in_array($usuario->fcm_token, $tokensEnviados)) {
                continue;
            }

            try {
                $this->firebase->sendNotification(
                    $usuario->fcm_token,
                    'Alerta de Stock',
                    '⚠️ Stock bajo: ' . $producto->nombre . ' (' . $producto->stock . ' unidades)',
                    [
                        'type' => 'stock_bajo',
                        'producto_uuid' => $producto->uuid,
                        'producto_nombre' => $producto->nombre,
                        'stock_actual' => $producto->stock,
                        'url' => route('productos.inventory')
                    ]
                );

                $tokensEnviados[] = $usuario->fcm_token;
            } catch (\Exception $e) {
                Log::warning('Error al enviar notificación FCM de stock bajo: ' . $e->getMessage());
            }
        }
    }
}
