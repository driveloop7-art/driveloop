<x-split-layout>
    <x-slot name="banner">
        <div class="relative z-10 px-12 text-center text-white">
            <h1 class="text-5xl font-extrabold mb-6 tracking-tight leading-tight">
                El auto que buscas,<br> la oportunidad que necesitas.
            </h1>
            <p class="text-xl text-gray-200 font-light">
                Forma parte de la comunidad DriveLoop. <br>Tu tiempo, tus reglas.
            </p>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input class="h-14" name="nom" label="{{ __('Name') }}" type="text" :value="old('nom')" required />

            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input class="h-14" name="ape" label="{{ __('Last Name') }}" type="text" :value="old('ape')" required />

            <x-input-error :messages="$errors->get('ape')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input class="h-14" name="email" label="{{ __('Email') }}" type="email" :value="old('email')" required />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input class="h-14" name="password" label="{{ __('Password') }}" type="password" :value="old('password')"
                required />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input class="h-14" name="password_confirmation" label="{{ __('Confirm Password') }}" type="password"
                :value="old('password_confirmation')" required />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Conditions -->
        <div class="mt-4">
            <label for="terms" class="inline-flex items-center">
                <input id="terms" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="terms"
                    required>
                <span class="ms-2 text-sm text-gray-600">{{ __('Acepto') }} <a href="{{ asset('terminos.pdf') }}"
                        target="_blank"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Terminos y Condiciones') }}</a></span>
            </label>
            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button width="full" x-data="">{{ __('Join us') }}</x-button>
        </div>
        <div class="mt-4 ">
            <a class="underline text-sm text-black-600 hover:text-black-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>

</x-split-layout>