<?php

namespace App\Modules\GestionUsuario\breeze\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\GestionUsuario\breeze\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:80'],
            'ape' => ['required', 'string', 'max:80'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:80', 'unique:'.User::class],
            'tel' => ['nullable', 'string', 'max:30'], 
            'fecnac' => ['nullable', 'date'],
            'lic' => ['nullable', 'string', 'max:30'],
            'numcue' => ['nullable', 'string', 'max:34'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'ape' => $request->ape,
            'email' => $request->email,
            'tel' => $request->tel,
            'fecnac' => $request->fecnac,
            'lic' => $request->lic,
            'numcue' => $request->numcue,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
