<x-guest-layout>
    <!-- Session Status -->
    <x-breeze::auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email Address -->
        <div>
            <x-input
            name="email"
            label="{{ __('Email') }}"
            type="email"
            :value="old('email')"
            required/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input
            name="password"
            label="{{ __('Password') }}"
            type="password"
            :value="old('password')"
            required/>
        </div>
        <!-- Errors -->
        <div class="block mt-4">
            <x-breeze::input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-black-600">{{ __('Remember me') }}</span>
            </label>
        </div>
      
        <div class="flex items-center justify-end mt-4">
            <x-button width="full"
                x-data=""
            >{{ __('Log in') }}</x-button>
        </div>
        <div class="flex items-center justify-left mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-black-600 hover:text-black-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <a class="underline text-sm text-black-600 hover:text-black-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-3" href="{{ route('register') }}">
                {{ __('Register') }}
            </a>
        </div>
    </form>
</x-guest-layout>
