<?php

namespace App\Modules\GestionUsuario\services;

use App\Models\MER\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAnonymizationService
{
    /**
     * Anonimiza y desactiva la cuenta de un usuario.
     */
    public function execute(User $user): void
    {
        $fakeNom = 'Usuario eliminado ' . $user->id;
        $fakeApe = 'Usuario eliminado ' . $user->id;
        $fakeEmail = 'deleted_user' . $user->id . '@deleted.com';
        $fakePassword = Hash::make(Str::random(20));

        $user->update([
            'is_active' => false,
            'nom' => $fakeNom,
            'ape' => $fakeApe,
            'email' => $fakeEmail,
            'password' => $fakePassword,
            'cod' => null,
            'tel' => null,
            'fecnac' => null,
            'lic' => null,
            'numcue' => null,
            'numdir' => null,
            'codciu' => null,
        ]);
    }
}
