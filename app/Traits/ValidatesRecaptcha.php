<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use App\Models\Setting;

trait ValidatesRecaptcha
{
    protected function validateRecaptcha($response, $enabled = true)
    {
        if (!$enabled) {
            return true;
        }

        $secretKey = env('RECAPTCHA_SECRET_KEY');
        if (!$secretKey) {
            $settings = Setting::first();
            $secretKey = $settings?->recaptcha_secret_key;
        }

        if (!$secretKey) {
            return true;
        }

        $verify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $response,
        ]);

        return $verify->json('success');
    }
}
