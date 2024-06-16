<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $sid;
    protected $token;
    protected $from;
    protected $client;

    public function __construct()
    {
        $this->sid = config('twilio.sid');
        $this->token = config('twilio.token');
        $this->from = config('twilio.from');
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
}
