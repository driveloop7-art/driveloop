<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" x-data="passwordMeter()" @submit="submitForm">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input class="h-14" name="email" label="{{ __('Email') }}" type="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-password_show class="h-14" name="password" label="{{ __('Password') }}" type="password" required
                autocomplete="new-password" x-model="password" @input="checkPassword" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            
            <!-- Medidor de seguridad de contraseña -->
            <div class="mt-2" x-show="password.length > 0" x-cloak style="display: none;">
                <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden flex">
                    <div class="h-full transition-all duration-300"
                         :class="{
                             'w-1/3 bg-red-500': strength === 'low',
                             'w-2/3 bg-orange-500': strength === 'medium',
                             'w-full bg-green-500': strength === 'high'
                         }"></div>
                </div>
                <div class="mt-2 text-xs text-gray-600">
                    <p class="font-semibold mb-1">La contraseña debe cumplir con:</p>
                    <ul class="space-y-1">
                        <li class="flex items-center" :class="conditions.length ? 'text-green-600' : 'text-gray-500'">
                            <span class="mr-1" x-text="conditions.length ? '✓' : '○'"></span> Mínimo 8 caracteres
                        </li>
                        <li class="flex items-center" :class="conditions.uppercase ? 'text-green-600' : 'text-gray-500'">
                            <span class="mr-1" x-text="conditions.uppercase ? '✓' : '○'"></span> Al menos una mayúscula
                        </li>
                        <li class="flex items-center" :class="conditions.number ? 'text-green-600' : 'text-gray-500'">
                            <span class="mr-1" x-text="conditions.number ? '✓' : '○'"></span> Al menos un número
                        </li>
                        <li class="flex items-center" :class="conditions.special ? 'text-green-600' : 'text-gray-500'">
                            <span class="mr-1" x-text="conditions.special ? '✓' : '○'"></span> Al menos 1 carácter especial
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-password_show class="h-14" name="password_confirmation" label="{{ __('Confirm Password') }}" type="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mt-4 text-xs">
            <x-button class="w-full" x-bind:disabled="!allConditionsMet" x-bind:class="!allConditionsMet ? 'opacity-50 cursor-not-allowed' : ''">
                {{ __('Reset Password') }}
            </x-button>
        </div>
    </form>
</x-guest-layout>