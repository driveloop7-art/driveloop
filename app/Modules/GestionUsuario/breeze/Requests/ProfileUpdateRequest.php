<?php

namespace App\Modules\GestionUsuario\breeze\Requests;

use App\Modules\GestionUsuario\breeze\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:80'],
            'ape' => ['required', 'string', 'max:80'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:80',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
