<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp message.
     * This is a placeholder for actual API integration (e.g., UltraMsg, Twilio, or Meta API).
     */
    public function sendMessage($to, $message)
    {
        // Example for Meta Cloud API or similar
        // $response = Http::withToken(config('services.whatsapp.token'))
        //     ->post(config('services.whatsapp.url'), [
        //         'messaging_product' => 'whatsapp',
        //         'to' => $to,
        //         'type' => 'text',
        //         'text' => ['body' => $message]
        //     ]);

        Log::info("WhatsApp message to {$to}: {$message}");

        return true;
    }
}
