<section>
    <header>
        <h2 class="text-lg font-medium text-black-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-black-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input
            name="nom"
            label="{{ __('Name') }}"
            type="text"
            :value="old('nom', $user->nom)"
            required/>
            <x-breeze::input-error class="mt-2" :messages="$errors->get('nom')" />
        </div>

        <div>
            <x-input
            name="ape"
            label="{{ __('Last Name') }}"
            type="text"
            :value="old('ape', $user->ape)"
            required/>
            <x-breeze::input-error class="mt-2" :messages="$errors->get('ape')" />
        </div>


        <div>
            <x-input
            name="email"
            label="{{ __('Email') }}"
            type="email"
            :value="old('email', $user->email)"
            required/>
            <x-breeze::input-error class="mt-2" :messages="$errors->get('email')" />


            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-black-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-black-600 hover:text-black-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-button width="md"
                x-data=""
            >{{ __('Save') }}</x-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-black-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
