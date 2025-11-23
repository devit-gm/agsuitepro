<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(storage_path('firebase-credentials.json'));
        $this->messaging = $factory->createMessaging();
    }

    public function sendNotification($token, $title, $body, $data = [])
    {
        if (empty($token)) return false;

        try {
            // Usar SOLO DATA → funciona en foreground y background
            $messageData = array_merge([
                'title' => $title,
                'body'  => $body,
            ], $data);

            $message = CloudMessage::withTarget('token', $token)
    ->withNotification([
        'title' => $title,
        'body'  => $body
    ])
    ->withData(array_merge([
        'title' => $title,
        'body'  => $body
    ], $data));


            $this->messaging->send($message);

            Log::info("Notificación enviada a $token");
            return true;
        } catch (\Exception $e) {
            Log::error("Error FCM: " . $e->getMessage());
            return false;
        }
    }
}
