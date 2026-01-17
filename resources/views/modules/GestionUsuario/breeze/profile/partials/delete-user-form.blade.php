<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-black-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-black-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-button class="text-xs w-60" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Delete Account') }}
    </x-button>

    <x-modal class="xl:max-w-1xl" name="confirm-user-deletion" title="Eliminar cuenta" :show="$errors->isNotEmpty()"
        focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-black-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-black-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input name="password" label="{{ __('Password') }}" type="password" required />
                <x-breeze::input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <x-button class="text-xs w-60 " x-data="" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-button>
                <x-button class="text-xs w-60" x-data="" type="tertiary">
                    {{ __('Delete Account') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>