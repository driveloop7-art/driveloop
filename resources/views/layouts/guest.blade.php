<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Driveloop') }}</title>

    <!-- Icon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div
        class="min-h-screen flex justify-center flex-col sm:justify-center items-center pt-6 sm:pt-0 img-background px-4">
        <div class="flex justify-center mb-1">
            <a href="/">
                <img src="{{ asset('images/logo_white.svg') }}" alt="Logo" class="w-24 h-20" />
            </a>
        </div>

        <div
            class="w-full sm:max-w-lg mt-1 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg flex flex-col justify-center">
            {{ $slot }}
        </div>
    </div>
</body>

</html>