<x-guest-layout>
    <div class="mb-4 text-sm text-black-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex flex-col sm:flex-row items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-button class="text-xs w-60 sm:w-full">{{ __('Resend Verification Email') }}</x-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-button class="text-xs w-60 mt-2 sm:ml-2 sm:mt-0 sm:w-24" type="tertiary">
                {{ __('Log Out') }}
            </x-button>
        </form>
    </div>
</x-guest-layout>