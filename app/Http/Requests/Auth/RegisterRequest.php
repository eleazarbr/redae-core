<?php

namespace App\Http\Requests\Auth;

use App\Support\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

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
            'company_name' => 'required|string|max:255|unique:companies,name',
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'terms_accepted' => 'required|accepted',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ];

        return array_merge($rules, Recaptcha::validationRules('register'));
    }
}
