<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use App\Models\Setting;

trait ValidatesRecaptcha
{
    protected function validateRecaptcha($response, $enabled)
    {
        if (!$enabled) {
            return true;
        }

        $settings = Setting::first();
        if (!$settings || !$settings->recaptcha_secret_key) {
            return true;
        }

        $verify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $settings->recaptcha_secret_key,
            'response' => $response,
        ]);

        return $verify->json('success');
    }
}
