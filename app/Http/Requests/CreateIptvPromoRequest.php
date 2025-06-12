<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateIptvPromoRequest extends FormRequest
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
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'locality' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:13'],
            'email' => ['nullable', 'email', 'max:255'],
            'expiration' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => "Neplatný formát",
            'name.max' => "Maximální počet znaků je :max",
            'surname.string' => "Neplatný formát",
            'surname.max' => "Maximální počet znaků je :max",
            'locality.string' => "Neplatný formát",
            'phone.string' => "Neplatný formát",
            'phone.max' => "Maximální počet znaků je :max",
            'email.email' => "Naplatný formát",
            'email.max' => "Maximální počet znaků je :max",
            'expiration.required' => "Vyplňte kdy, se ukončí promo",
            'expiration.string' => "Neplatný formát"
        ];
    }
}
