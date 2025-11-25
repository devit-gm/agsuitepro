<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;
use App\Models\Ajustes;
use App\Models\User;
use App\Models\Site;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VerificarReservasProximas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservas:verificar-proximas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica y notifica sobre reservas próximas según configuración';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando reservas próximas...');
        
        try {
            $sitios = Site::all();
            if ($sitios->isEmpty()) {
                $this->error('❌ No hay sitios configurados');
                return 1;
            }
            foreach ($sitios as $sitio) {
                $this->info("\n🌐 Procesando sitio: {$sitio->nombre} ({$sitio->db_name})");
                // Configurar conexión dinámica para este sitio
                config([
                    'database.connections.site.host' => $sitio->db_host,
                    'database.connections.site.database' => $sitio->db_name,
                    'database.connections.site.username' => $sitio->db_user,
                    'database.connections.site.password' => $sitio->db_password,
                ]);
                \DB::purge('site');
                \DB::reconnect('site');

                $ajustes = Ajustes::on('site')->first();
                if (!$ajustes) {
                    $this->warn('   ⚠️  No se encontró configuración de ajustes para este sitio');
                    continue;
                }
                $diasAntelacion = $ajustes->recordatorio_reservas_dias ?? 1;
                $enviarEmail = $ajustes->recordatorio_reservas_email ?? true;
                $enviarPush = $ajustes->recordatorio_reservas_push ?? true;

                $fechaObjetivo = Carbon::now()->addDays($diasAntelacion)->toDateString();
                $this->info("   ⚙️  Configuración: {$diasAntelacion} día(s) de antelación");
                $this->info("   📅 Buscando reservas para el día: {$fechaObjetivo}");

                $reservas = Reserva::on('site')
                    ->whereDate('start_time', $fechaObjetivo)
                    ->where(function($query) {
                        $query->whereNull('notificado_recordatorio')
                              ->orWhere('notificado_recordatorio', false);
                    })
                    ->with('user')
                    ->get();

                if ($reservas->isEmpty()) {
                    $this->info('   ✅ No hay reservas próximas para notificar en este sitio');
                    continue;
                }

                $this->info("   📬 Encontradas {$reservas->count()} reserva(s) para notificar");

                foreach ($reservas as $reserva) {
                    try {
                        $usuario = $reserva->user;
                        if (!$usuario) {
                            $this->warn("   ⚠️  Reserva #{$reserva->id} sin usuario asociado");
                            continue;
                        }
                        $tiempoRestante = Carbon::parse($reserva->start_time)->diffForHumans();
                        $this->info("   📌 Procesando reserva #{$reserva->id} - {$reserva->name} - {$tiempoRestante}");
                        // Enviar email
                        if ($enviarEmail && $usuario->email) {
                            $this->enviarEmailRecordatorio($reserva, $usuario, $diasAntelacion);
                            $this->line("      ✉️  Email enviado a {$usuario->email}");
                        }
                        // Enviar notificación push
                        if ($enviarPush && $usuario->fcm_token) {
                            $this->enviarNotificacionPush($reserva, $usuario, $diasAntelacion);
                            $this->line("      🔔 Notificación push enviada");
                        }
                        // Marcar como notificada
                        $reserva->update(['notificado_recordatorio' => true]);
                        $this->line("      ✅ Reserva marcada como notificada");
                    } catch (\Exception $e) {
                        $this->error("      ❌ Error al procesar reserva #{$reserva->id}: {$e->getMessage()}");
                        Log::error("Error al notificar reserva #{$reserva->id} en sitio {$sitio->nombre}: " . $e->getMessage());
                    }
                }
            }
            $this->info("\n✅ Proceso completado para todos los sitios");
            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Error general: {$e->getMessage()}");
            Log::error('Error en VerificarReservasProximas: ' . $e->getMessage());
            return 1;
        }
    }
    
    /**
     * Enviar email de recordatorio
     */
    private function enviarEmailRecordatorio($reserva, $usuario, $minutos)
    {
        try {
            $hora = Carbon::parse($reserva->start_time)->format('H:i');
            $datos = [
                'nombre' => $usuario->name,
                'reserva_nombre' => $reserva->name,
                'fecha_hora' => $hora,
                'dias' => $dias = 1, // para el texto del email si quieres mostrar "mañana" o "en X días"
                'descripcion' => $reserva->description ?? 'Sin descripción'
            ];
            Mail::send('emails.recordatorio-reserva', $datos, function($message) use ($usuario, $reserva, $hora) {
                $message->to($usuario->email, $usuario->name)
                        ->subject('🔔 Recordatorio: Mañana tienes una reserva a las ' . $hora . ' - ' . $reserva->name);
            });
        } catch (\Exception $e) {
            Log::error("Error al enviar email de recordatorio: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Enviar notificación push
     */
    private function enviarNotificacionPush($reserva, $usuario, $minutos)
    {
        try {
            if (!$usuario->fcm_token) {
                return;
            }
            $hora = Carbon::parse($reserva->start_time)->format('H:i');
            $firebase = app(\App\Services\FirebaseService::class);
            $firebase->sendNotification(
                $usuario->fcm_token,
                '🔔 Recordatorio de Reserva',
                "Mañana tienes una reserva a las {$hora} - {$reserva->name}",
                [
                    'type' => 'recordatorio_reserva',
                    'reserva_id' => $reserva->id,
                    'fecha' => Carbon::parse($reserva->start_time)->format('Y-m-d H:i:s'),
                    'click_action' => route('reservas.index')
                ]
            );
        } catch (\Exception $e) {
            Log::error("Error al enviar notificación push: " . $e->getMessage());
            throw $e;
        }
    }
}
