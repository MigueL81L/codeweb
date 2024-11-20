<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    // protected function passwordRules(): array
    // {
    //     return ['required', 'string', Password::default(), 'confirmed'];
    // }

    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            Password::min(8) // Establece la longitud mínima de 8 caracteres
                ->max(20) // Establece la longitud máxima de 20 caracteres
                ->mixedCase() // Requiere al menos una letra mayúscula y una minúscula
                ->numbers() // Requiere al menos un número
                ->symbols(), // Requiere al menos un símbolo
            'regex:/^\S*$/u', // No permite espacios
            'confirmed',
        ];
    }
}
