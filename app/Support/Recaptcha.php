<?php

namespace App\Support;

use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class Recaptcha
{
    /**
     * Build the front-end configuration payload for a given reCAPTCHA action.
     */
    public static function configuration(string $action): array
    {
        return [
            'enabled' => config('googlerecaptchav3.is_service_enabled'),
            'siteKey' => config('googlerecaptchav3.site_key'),
            'scriptUrl' => config('googlerecaptchav3.api_js_url'),
            'action' => $action,
        ];
    }

    /**
     * Return validation rules for the provided reCAPTCHA action.
     *
     * @return array<string, mixed>
     */
    public static function validationRules(string $action): array
    {
        if (! config('googlerecaptchav3.is_service_enabled')) {
            return [];
        }

        return [
            'g-recaptcha-response' => [
                'required',
                new GoogleReCaptchaV3ValidationRule($action),
            ],
        ];
    }
}
