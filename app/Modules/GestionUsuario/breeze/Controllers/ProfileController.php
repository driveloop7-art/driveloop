<?php

namespace App\Modules\GestionUsuario\breeze\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\GestionUsuario\breeze\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        //Obtener usuario
        $user = $request->user();

        //Generar nombre, apellido y correo falsos para generar anonimización de datos
        $fakeNom = 'Usuario eliminado ' . $user->id;
        $fakeApe = 'Usuario eliminado ' . $user->id;
        $fakeEmail = 'deleted_user' . $user->id . '@deleted.com';
        $fakePassword = Hash::make(Str::random(20));
        //Actualizar registro (ahora active es false)
        $user->update([
            'is_active' => false,
            'nom' => $fakeNom,
            'ape' => $fakeApe,
            'email' => $fakeEmail,
            'password' => $fakePassword,
            'tel' => null,
            'fecnac' => null,
            'lic' => null,
            'numcue' => null,
            'numdir' => null,
            'codciu' => null,
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
