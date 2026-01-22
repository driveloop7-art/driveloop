<section>
    <header>
        <h2 class="text-lg font-medium text-black-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-black-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input name="current_password" label="{{ __('Current Password') }}" type="password" required />
            <x-breeze::input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input name="password" label="{{ __('New Password') }}" type="password" required />
            <x-breeze::input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input name="password_confirmation" label="{{ __('Confirm Password') }}" type="password" required />
            <x-breeze::input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-button class="text-xs w-60" x-data="">{{ __('Save') }}</x-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>