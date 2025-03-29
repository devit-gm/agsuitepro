<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $sid;
    protected $token;
    protected $from;
    protected $whatsappFrom;
    protected $client;

    public function __construct()
    {
        $this->sid = config('twilio.sid');
        $this->token = config('twilio.token');
        $this->from = config('twilio.from');
        $this->whatsappFrom = config('twilio.whatsapp_from');
        $this->client = new Client($this->sid, $this->token);
    }

    public function sendSms($to, $message)
    {
        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message
            ]);
            return true;
        } catch (\Exception $e) {
            // Maneja el error aquí
            return false;
        }
    }

    public function sendWhatsAppMessage($to, $message)
    {
        try {
            // Para WhatsApp, se debe formatear el número con el prefijo 'whatsapp:'
            $this->client->messages->create('whatsapp:' . $to, [
                'from' => 'whatsapp:' . $this->whatsappFrom,
                'body' => $message
            ]);
            return true;
        } catch (\Exception $e) {
            // Registrar el error para debugging
            Log::error('Error al enviar mensaje de WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    public function sendWhatsAppTemplate($to, $templateName, $parameters = [])
    {
        try {
            // Envío de mensaje de plantilla para WhatsApp
            $this->client->messages->create('whatsapp:' . $to, [
                'from' => 'whatsapp:' . $this->whatsappFrom,
                'body' => $message = null,
                'contentSid' => $templateName,
                'contentVariables' => json_encode($parameters)
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Error al enviar plantilla de WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    public function sendWhatsAppMedia($to, $mediaUrl, $caption = null)
    {
        try {
            $messageOptions = [
                'from' => 'whatsapp:' . $this->whatsappFrom,
                'mediaUrl' => [$mediaUrl]
            ];

            // Si hay un pie de foto, incluirlo
            if ($caption) {
                $messageOptions['body'] = $caption;
            }

            $this->client->messages->create('whatsapp:' . $to, $messageOptions);
            return true;
        } catch (\Exception $e) {
            Log::error('Error al enviar multimedia por WhatsApp: ' . $e->getMessage());
            return false;
        }
    }
}
