<section>
    <header>
        <h2 class="text-lg font-medium text-black-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-black-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6" x-data="passwordMeter()" @submit="submitForm">
        @csrf
        @method('put')

        <div>
            <x-password_show name="current_password" label="{{ __('Current Password') }}" type="password" required />
            <x-breeze::input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-password_show name="password" label="{{ __('New Password') }}" type="password" required x-model="password" @input="checkPassword" />
            <x-breeze::input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            
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

        <div>
            <x-password_show name="password_confirmation" label="{{ __('Confirm Password') }}" type="password" required />
            <x-breeze::input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-button class="text-xs w-full lg:w-60" x-bind:disabled="!allConditionsMet" x-bind:class="!allConditionsMet ? 'opacity-50 cursor-not-allowed' : ''">{{ __('Save') }}</x-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>