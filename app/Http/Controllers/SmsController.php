<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TwilioService;

class SmsController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function sendSms(Request $request)
    {
        $to = $request->input('to');
        $message = $request->input('message');

        $sent = $this->twilio->sendSms($to, $message);

        if ($sent) {
            return response()->json(['success' => 'SMS enviado exitosamente.']);
        } else {
            return response()->json(['error' => 'Error al enviar SMS.'], 500);
        }
    }
}
