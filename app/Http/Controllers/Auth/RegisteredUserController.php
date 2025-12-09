<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'nomusu' => ['required', 'string', 'max:255'],
            'apeusu' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'telusu' => ['nullable', 'string', 'max:30'], 
            'fecnac' => ['nullable', 'date'],
            'licusu' => ['nullable', 'string', 'max:30'],
            'numcue' => ['nullable', 'string', 'max:34'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nomusu' => $request->nomusu,
            'apeusu' => $request->apeusu,
            'email' => $request->email,
            'telusu' => $request->telusu,
            'fecnac' => $request->fecnac,
            'licusu' => $request->licusu,
            'numcue' => $request->numcue,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
