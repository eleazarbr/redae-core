<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'company_name' => 'required|string|max:255|unique:companies,company_name',
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ];

        // Add Google reCAPTCHA v3 validation rule if the service is enabled.
        if (config('googlerecaptchav3.is_service_enabled')) {
            $rules['g-recaptcha-response'] = [
                'required',
                new GoogleReCaptchaV3ValidationRule('register'),
            ];
        }

        return $rules;
    }
}
