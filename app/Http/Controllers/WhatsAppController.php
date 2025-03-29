<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
        $this->middleware('auth');
    }

    /**
     * Enviar un mensaje simple de WhatsApp
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'message' => 'required|string',
        ]);

        $to = $request->input('to');
        $message = $request->input('message');

        // Enviamos el mensaje de WhatsApp
        $success = $this->twilioService->sendWhatsAppMessage($to, $message);

        if ($success) {
            return response()->json(['success' => true, 'message' => 'Mensaje de WhatsApp enviado con éxito']);
        } else {
            return response()->json(['success' => false, 'message' => 'Error al enviar el mensaje de WhatsApp'], 500);
        }
    }

    /**
     * Enviar un archivo multimedia por WhatsApp
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendMedia(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'media_url' => 'required|url',
            'caption' => 'nullable|string',
        ]);

        $to = $request->input('to');
        $mediaUrl = $request->input('media_url');
        $caption = $request->input('caption');

        // Enviamos el archivo multimedia por WhatsApp
        $success = $this->twilioService->sendWhatsAppMedia($to, $mediaUrl, $caption);

        if ($success) {
            return response()->json(['success' => true, 'message' => 'Archivo multimedia enviado por WhatsApp con éxito']);
        } else {
            return response()->json(['success' => false, 'message' => 'Error al enviar el archivo multimedia por WhatsApp'], 500);
        }
    }

    /**
     * Enviar una plantilla de mensaje por WhatsApp
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendTemplate(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'template_name' => 'required|string',
            'parameters' => 'nullable|array',
        ]);

        $to = $request->input('to');
        $templateName = $request->input('template_name');
        $parameters = $request->input('parameters', []);

        // Enviamos la plantilla de WhatsApp
        $success = $this->twilioService->sendWhatsAppTemplate($to, $templateName, $parameters);

        if ($success) {
            return response()->json(['success' => true, 'message' => 'Plantilla de WhatsApp enviada con éxito']);
        } else {
            return response()->json(['success' => false, 'message' => 'Error al enviar la plantilla de WhatsApp'], 500);
        }
    }

    /**
     * Envía automáticamente una notificación de reserva por WhatsApp
     * 
     * @param Reserva $reserva
     * @return bool
     */
    public function sendReservaNotification($reserva)
    {
        try {
            $usuario = $reserva->usuario;
            if (!$usuario || !$usuario->telefono) {
                Log::error('No se pudo enviar la notificación de WhatsApp: Usuario o teléfono no disponible');
                return false;
            }

            $telefono = $this->formatearTelefono($usuario->telefono);
            $mensaje = "Hola {$usuario->name}, tu reserva para el {$reserva->fecha} a las {$reserva->hora} ha sido confirmada. Gracias por confiar en nosotros.";

            return $this->twilioService->sendWhatsAppMessage($telefono, $mensaje);
        } catch (\Exception $e) {
            Log::error('Error al enviar notificación automática de reserva: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Envía automáticamente una notificación de ficha actualizada por WhatsApp
     * 
     * @param Ficha $ficha
     * @return bool
     */
    public function sendFichaUpdateNotification($ficha)
    {
        try {
            // Obtenemos todos los usuarios asociados a la ficha
            $usuarios = $ficha->usuarios;
            $resultados = [];

            foreach ($usuarios as $usuario) {
                if ($usuario->telefono) {
                    $telefono = $this->formatearTelefono($usuario->telefono);
                    $mensaje = "Hola {$usuario->name}, la ficha #{$ficha->id} ha sido actualizada. Puedes revisarla en nuestra plataforma.";

                    $resultados[$usuario->id] = $this->twilioService->sendWhatsAppMessage($telefono, $mensaje);
                }
            }

            return !empty($resultados) && !in_array(false, $resultados);
        } catch (\Exception $e) {
            Log::error('Error al enviar notificación automática de ficha: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Comparte el resumen de una ficha por WhatsApp
     * 
     * @param Ficha $ficha
     * @param string $telefono
     * @return bool
     */
    public function shareResumenFicha($ficha, $telefono)
    {
        try {
            $telefono = $this->formatearTelefono($telefono);

            // Cargamos las relaciones necesarias para el resumen
            if (!$ficha->relationLoaded('productos')) {
                $ficha->load(['productos', 'servicios', 'gastos', 'usuarios']);
            }

            // Calculamos los totales
            $total_consumos = 0;
            $total_servicios = 0;
            $total_gastos = 0;

            if ($ficha->productos) {
                foreach ($ficha->productos as $producto) {
                    $total_consumos += $producto->precio;
                }
            }

            if ($ficha->servicios) {
                foreach ($ficha->servicios as $servicio) {
                    $total_servicios += $servicio->precio;
                }
            }

            if ($ficha->gastos) {
                foreach ($ficha->gastos as $gasto) {
                    $total_gastos += $gasto->precio;
                }
            }

            // Construimos el resumen
            $resumen = "Resumen de la Ficha #{$ficha->uuid}\n";
            $resumen .= "Fecha: {$ficha->fecha}\n";
            $resumen .= "Cliente: {$ficha->cliente}\n\n";

            // Añadimos productos si los hay
            if ($ficha->productos && count($ficha->productos) > 0) {
                $resumen .= "Productos:\n";
                foreach ($ficha->productos as $producto) {
                    $nombreProducto = $producto->producto ? $producto->producto->nombre : 'Producto';
                    $cantidad = $producto->cantidad ?? 1;
                    $resumen .= "- {$nombreProducto} x{$cantidad}: {$producto->precio}€\n";
                }
                $resumen .= "\n";
            }

            // Añadimos servicios si los hay
            if ($ficha->servicios && count($ficha->servicios) > 0) {
                $resumen .= "Servicios:\n";
                foreach ($ficha->servicios as $servicio) {
                    $nombreServicio = $servicio->servicio ? $servicio->servicio->nombre : 'Servicio';
                    $resumen .= "- {$nombreServicio}: {$servicio->precio}€\n";
                }
                $resumen .= "\n";
            }

            // Añadimos gastos si los hay
            if ($ficha->gastos && count($ficha->gastos) > 0) {
                $resumen .= "Gastos:\n";
                foreach ($ficha->gastos as $gasto) {
                    $descripcion = $gasto->descripcion ?: 'Gasto';
                    $resumen .= "- {$descripcion}: {$gasto->precio}€\n";
                }
                $resumen .= "\n";
            }

            // Total
            $total = $total_consumos + $total_servicios + $total_gastos;
            $resumen .= "Total: {$total}€\n";

            return $this->twilioService->sendWhatsAppMessage($telefono, $resumen);
        } catch (\Exception $e) {
            Log::error('Error al compartir resumen de ficha: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Formatea el número de teléfono para enviarlo por WhatsApp
     * 
     * @param string $telefono
     * @return string
     */
    private function formatearTelefono($telefono)
    {
        // Eliminar espacios, guiones y paréntesis
        $telefono = preg_replace('/\s+|\(|\)|-/', '', $telefono);

        // Asegurarse de que el número comienza con el código de país
        if (substr($telefono, 0, 1) === '+') {
            return ltrim($telefono, '+');
        } else if (substr($telefono, 0, 2) === '00') {
            return substr($telefono, 2);
        } else if (substr($telefono, 0, 1) === '0') {
            return '34' . substr($telefono, 1); // Añadir código de España
        } else if (strlen($telefono) === 9) {
            return '34' . $telefono; // Añadir código de España
        }

        return $telefono;
    }
}
