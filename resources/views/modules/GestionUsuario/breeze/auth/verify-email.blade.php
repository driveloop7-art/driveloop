<x-guest-layout>
    <div class="mb-4 text-sm text-black-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-button x-data="">{{ __('Resend Verification Email') }}</x-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-breeze::secondary-button class="ml-4">
                {{ __('Log Out') }}
            </x-breeze::secondary-button>
        </form>
    </div>
</x-guest-layout>