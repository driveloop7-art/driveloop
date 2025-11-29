<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Driveloop') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Icon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="min-h-screen img-background">
            <div class="mx-4 sm:mx-[5rem] sm:px-6 lg:px-8">
                <div class="py-[0.6rem]">
                    <div class="p-3 text-gray-900">
                        @include('layouts.navigation')
                    </div>                    
                </div>
                <!-- Page Heading -->
                <!-- @isset($header)
                    <header class="shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset -->

                <!-- Page Content -->
                <main>
                    <div class="py-5">
                        <div class="sm:rounded-lg">
                            <div class="p-3">
                                {{ $slot }}
                            </div>         
                        </div>
                    </div>                    
                </main>
            </div>
        </div>
    </body>
</html>
