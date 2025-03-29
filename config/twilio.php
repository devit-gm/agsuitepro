<?php
return [
    'sid' => env('TWILIO_SID'),
    'token' => env('TWILIO_AUTH_TOKEN'),
    'from' => env('TWILIO_PHONE_NUMBER'),
    'whatsapp_from' => env('TWILIO_WHATSAPP_NUMBER'),
];
