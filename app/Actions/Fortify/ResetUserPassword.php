<?php

namespace App\Actions\Fortify;

// use App\Models\User;
use Illuminate\Foundation\Auth\User as FortifyUser; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  FortifyUser $user  // Cambiar el tipo aquí
     * @param  array<string, string>  $input
     */

    // public function reset(User $user, array $input): void
    public function reset(FortifyUser $user, array $input): void
    {
        Validator::make($input, [
            'password' => $this->passwordRules(),
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
