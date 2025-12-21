<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <!--<x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus autocomplete="name" /> -->
            <x-input
            name="nom"
            label="{{ __('Name') }}"
            type="text"
            :value="old('nom')"
            required/>
            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <!--<x-input-label for="lastname" :value="__('Last Name')" />
            <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="ape" :value="old('ape')" required autofocus autocomplete="name" /> -->
            <x-input
            name="ape"
            label="{{ __('Last Name') }}"
            type="text"
            :value="old('ape')"
            required/>
            <x-input-error :messages="$errors->get('ape')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <!--<x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" /> -->
            <x-input
            name="email"
            label="{{ __('Email') }}"
            type="email"
            :value="old('email')"
            required/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <!--<x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" /> -->
            <x-input
            name="password"
            label="{{ __('Password') }}"
            type="password"
            :value="old('password')"
            required/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <!--<x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" /> -->

            <x-input
            name="password_confirmation"
            label="{{ __('Password') }}"
            type="password"
            :value="old('password_confirmation')"
            required/>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button width="full"
                x-data=""
            >{{ __('Register') }}</x-button>
        </div>
        <div class="mt-4 ">
            <a class="underline text-sm text-black-600 hover:text-black-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
</x-guest-layout>